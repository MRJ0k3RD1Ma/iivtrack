<?php

namespace frontend\modules\cc\controllers;

use common\models\Address;
use common\models\Call;
use common\models\DistrictView;
use common\models\Event;
use common\models\EventUser;
use common\models\User;
use frontend\components\Sms;
use yii\web\Controller;
use yii\web\UploadedFile;
use function common\models\Soato;
use Yii;
/**
 * Default controller for the `cp` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $markers = [];

        $model = Address::find()->all();
        /* @var $item Address*/
        foreach ($model as $item){
            $c = Call::find()->where(['address'=>$item->address])->andWhere(['<>','status',4])->one();
            $status = 0;
            if($c){
                $status = $c->status;
            }
            $markers[] = [$item->address,$item->lat, $item->long,$status];
        }

        $event = Event::find()->where(['status'=>2])
            ->andWhere('"'.date('Y-m-d').'" BETWEEN date_start AND date_end')
            ->all();

        $ev_marker = [];
        foreach ($event as $item){
            $ev_marker[] = [$item->lat,$item->long,$item->radius,$item->address,$item->id];
        }


        $model = new Call();
        if($model->load($this->request->post())){

            $code_id = Call::find()->filterWhere(['like','created',date('Y')])->max('code_id');
            if(!$code_id){
                $code_id = 0;
            }
            $code_id++;
            $code = substr(date('Y'),2,2).'/'.$code_id;
            $model->code = $code;
            $model->code_id = $code_id;
            $res = Sms::send($model->phone,'Sizning chaqiruvingizga asosan sizga profilaktika inspektori '.$model->user->name.' yuborildi. Tel:'. $model->user->username);
            $res = Sms::send($model->user->username,$model->address.' manzilda yashovchi '.$model->name.' tomonidan '.$model->type->name.' sabab bilan chaqiruv. Tel:'.$model->phone);


            if($model->save()){
                Yii::$app->session->setFlash('success','Ushbu murojaat qabul qilindi.');
            }else{
                Yii::$app->session->setFlash('error','Murojaatni saqlashda xatolik.');
            }

            return $this->redirect(['index']);
        }

        return $this->render('index',[
            'locs'=>json_encode($markers),
            'model'=>$model,
            'ev_locs'=>json_encode($ev_marker)
        ]);
    }



    public function actionProfile(){
        $model = User::findOne(Yii::$app->user->id);
        $pas = $model->password;
        $image = $model->image;
        if($model->load($this->request->post())){
            if($model->password){
                $model->setPassword($model->password);
            }else{
                $model->password = $pas;
            }
            if($model->image = UploadedFile::getInstance($model,'image')){
                $name = "image/".microtime(true).'.'.$model->image->extension;
                $model->image->saveAs(\Yii::$app->basePath.'/web/upload/'.$name);
                $model->image = $name;
                if(file_exists(\Yii::$app->basePath.'/web/upload/'.$image) and $image!="default/avatar.png"){
                    unlink(\Yii::$app->basePath.'/web/upload/'.$image);
                }
            }else{
                $model->image = $image;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success','Sizning ma`lumotlaringiz yangilandi.');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotlarni yangilashda xatolik');
            }
        }


        $model->password = "";
        return $this->render('profile',[
            'model'=>$model
        ]);
    }

    public function actionGetdistrict($id){
        $model = DistrictView::find()->where(['region_id'=>$id])->all();
        $res = "<option>-Tumanni tanlang-</option>";
        /* @var $item DistrictView*/
        foreach ($model as $item){
            $res .= "<option value='{$item->id}'>{$item->name_lot}</option>";
        }
        return $res;
    }


    public function actionPolice()
    {
        $model = Address::find()->all();
        $markers = [];


        $model = User::find()->where(['>','active',0])->all();

        foreach ($model as $item){
            $status = 0;
            $event_user = EventUser::find()
                ->where('event_id in (select event.id from event where event.status = 2 and "'.date('Y-m-d').'" BETWEEN event.date_start AND event.date_end )')
                ->andWhere(['user_id'=>$item->id])
                ->one();
            $type = 1;
            $txt = "";
            if($event_user){
                $event = $event_user->event;
                $start = explode(':',$event_user->time_start);
                $end = explode(':',$event_user->time_end);

                $now = date('h:i');
                $now = explode(':',$now);
                $startMin = $start[0]*60+$start[1];
                $endMin = $end[0]*60+$end[1];
                $nowMin = $now[0]*60+$now[1];

                if($start[0]>=$end[0]){
                    $endMin += 24*60;
                    if($now[0] <= $end[0]){
                        $nowMin += 24*60;
                    }
                }

                if($startMin <= $nowMin and $nowMin <= $endMin){
                    $r = sqrt(($event->lat - $item->lat)*($event->lat - $item->lat) + ($event->long - $item->long)*($event->long - $item->long));
                    if($r <= $event->radius){
                        $txt = '<b><br>'.$event->address.' manzilda bo`lishi kerak</b>';
                        $type = 0;
                    }else{
                        $type = 1;
                    }
                }

            }
            $markers[] = [$item->name.$txt,$item->lat, $item->long,$status,$type,$item->id];
        }

        return json_encode($markers);
    }



    public function actionEvent()
    {
        $model = new Event();

        if($model->load($this->request->post())){
            $model->user_id = Yii::$app->user->id;
            $model->status = 1;
            if($model->save()){
                Yii::$app->session->setFlash('success','Tadbir joyi muvoffaqiyatli saqlandi');
                return $this->redirect(['/cc/event/view','id'=>$model->id]);
            }else{
                Yii::$app->session->setFlash('error','Tadbir joyini saqlashda xatolik');
                return $this->redirect(['event']);
            }
        }

        return $this->render('event',[
            'model'=>$model
        ]);
    }


    public function actionNonactive()
    {
        $model = User::find()->where(['status'=>0])->all();
        return $this->render('nonactive',['model'=>$model]);
    }

}
