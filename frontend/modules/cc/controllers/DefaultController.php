<?php

namespace frontend\modules\cc\controllers;

use common\models\Address;
use common\models\Call;
use common\models\DistrictView;
use common\models\Event;
use common\models\EventUser;
use common\models\Shift;
use common\models\User;
use common\models\UserHistory;
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
        /*foreach ($model as $item){
            $c = Call::find()->where(['address'=>$item->address])->andWhere(['<>','status',4])->one();
            $status = 0;
            if($c){
                $status = $c->status;
            }
        }*/

        foreach (Call::find()->where(['<>','status',4])->groupBy('address')->all() as $item){
            $adr = $item->address0;
            $markers[] = [$item->address,$adr->lat, $adr->long,$item->status];
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
            $res = Sms::send($model->phone,'Sizning chaqiruvingizga asosan sizga profilaktika inspektori '.$model->user->name.' yuborildi. Tel:'. $model->user->username." sayt:mnazorat.uz");
            $res = Sms::send($model->user->username,$model->address.' manzilda yashovchi '.$model->name.' tomonidan '.$model->type->name.' sabab bilan chaqiruv. Tel:'.$model->phone." sayt:mnazorat.uz");


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
                $model->image->saveAs(\Yii::$app->basePath.'/web/upload/all/'.$name);
                $model->image = $name;
                if(file_exists(\Yii::$app->basePath.'/web/upload/all/'.$image) and $image!="default/avatar.png"){
                    unlink(\Yii::$app->basePath.'/web/upload/all/'.$image);
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
        date_default_timezone_set('Asia/Tashkent');

        $time = date('H:i');
        $time = explode(':',$time);
        $u = ['<>','active',2];
        if($time[0] == 8 and $time[1] >= 30){
            $u = ' 1 ';
        }elseif($time[0] > 8 and $time[0] <= 20){
            $u = ' 1 ';
        }


        $model = User::find()->where(['is not','active_date',null])
            ->andWhere($u)
            ->andWhere(['is not','lat',null])->andWhere(['is not','long',null])->all();

        foreach ($model as $item){


            $event_user = EventUser::find()
                ->where('event_id in (select event.id from event where event.status = 2 and "'.date('Y-m-d').'" BETWEEN event.date_start AND event.date_end )')
                ->andWhere(['user_id'=>$item->id])
                ->one();
            $type = 1;
            $txt = "";
            $radius = -1;
            $elat = 0;
            $elong = 0;
            if($event_user){
                $event = $event_user->event;
                $radius = $event->radius;
                $elat = $event->lat;
                $elong = $event->long;

                $start = explode(':',$event_user->time_start);
                $end = explode(':',$event_user->time_end);

                $now = date('H:i');
                $now = explode(':',$now);

                $startMin = $start[0]*60+$start[1];
                $endMin = $end[0] * 60 + $end[1];
                $nowMin = $now[0] * 60 + $now[1];

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

                if($item->active == 0){
                    $txt = '<b><br>'.$event->address.' manzilda bo`lishi kerak</b>';
                }

            }
            $txt .= '<br>'.@$item->hudud.'<br>'.@$item->username.'<br>'.$item->pozivnoy;
            if($item->active == 2){
                $item->active = 0;
            }
            $markers[] = ["<img src='/upload/{$item->image}' style='width: 100%; height: auto;' />".'<br>'.$item->name.$txt,$item->lat, $item->long,$item->active,$type,$item->id,$radius,$elat,$elong];
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
        $model = User::find()->orderBy(['name'=>SORT_ASC])->all();
        return $this->render('nonactive',['model'=>$model]);
    }

    public function actionView($id, $date=null)
    {
        $model = User::findOne($id);
        if(!$date){
            $date = date('Y-m-d');
        }
        $locations = [];


        if($model){
            $start = null;
            $end = null;
            $locs = UserHistory::find()->where(['user_id'=>$model->id])->andFilterWhere(['like','created',$date])->orderBy(['created'=>SORT_ASC])->all();
            $n=0;
            $cnt = count($locs);
            foreach ($locs as $item){
                $n++;
                if($n==1){
                    $start = [$item->lat,$item->long];
                }
                if($n == $cnt){
                    $end = [$item->lat,$item->long];
                }
                $locations[] = [$item->lat,$item->long];
            }

            if(count($locations) == 0){
                $locations = null;
            }
            return $this->render('view',[
                'model'=>$model,
                'date'=>$date,
                'locations'=>json_encode($locations),
                'start'=>json_encode($start),
                'end'=>json_encode($end)
            ]);
        }else{
            Yii::$app->session->setFlash('error','Bunday hodim topilmadi');
            return $this->redirect(['nonactive']);
        }

    }


    public function actionShiftone($date = null)
    {
        if(!$date ){
            $date = date('Y-m-d');
        }

        $model = new Shift();
        $model->date = date('Y-m-d');
        $model->shift_id = 1;
        if($model->load($this->request->post())){
            if($model->save()){
                Yii::$app->session->setFlash("success",'Ushbu hodim tezkor guruhga qo`shildi');
            }else{
                Yii::$app->session->setFlash("error",'Ushbu hodim tezkor guruhga qo`shishda xatolik');
            }
            return $this->redirect(['shiftone']);
        }
        $data = User::find()->where('id in (select user_id from shift where  shift_id = 1 and date = "'.$date.'")')->all();
        return $this->render('shiftone',[
            'model'=>$model,
            'data'=>$data,
            'date'=>$date
        ]);


    }

    public function actionShifttwo($date = null)
    {
        if(!$date ){
            $date = date('Y-m-d');
        }

        $model = new Shift();
        $model->date = date('Y-m-d');
        $model->shift_id = 2;
        if($model->load($this->request->post())){
            if($model->save()){
                Yii::$app->session->setFlash("success",'Ushbu hodim tungi guruhga qo`shildi');
            }else{
                Yii::$app->session->setFlash("error",'Ushbu hodim tungi guruhga qo`shishda xatolik');
            }
            return $this->redirect(['shifttwo']);
        }
        $data = User::find()->where('id in (select user_id from shift where shift_id = 2 and date = "'.$date.'")')->all();
        return $this->render('shifttwo',[
            'model'=>$model,
            'data'=>$data,
            'date'=>$date
        ]);


    }


    public function actionShiftremove($user_id,$shift_id)
    {
        $model = Shift::find()->where(['date'=>date('Y-m-d'),'user_id'=>$user_id,'shift_id'=>$shift_id])->one();
        if($model){
            $model->delete();
            Yii::$app->session->setFlash('success','Ushbu hodim guruhdan o`chirildi');
        }else{
            Yii::$app->session->setFlash('error','Bunday hodim topilmadi');
        }
        $r = $shift_id == 1 ? 'one' : 'two';
        return $this->redirect(['shift'.$r]);
    }


}


