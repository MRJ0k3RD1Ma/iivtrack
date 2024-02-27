<?php

namespace frontend\modules\cc\controllers;

use common\models\Address;
use common\models\Call;
use common\models\DistrictView;
use common\models\Event;
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
            'markers'=>json_encode($markers),
            'model'=>$model
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
        /* @var $item Address*/
        foreach ($model as $item){
            $c = Call::find()->where(['address'=>$item->address])->andWhere(['<>','status',4])->one();
            $status = 0;
            if($c){
                $status = $c->status;
            }
            $markers[] = [$item->address,$item->lat, $item->long,$status,0];
        }

        $model = User::find()->where(['>','active',0])->all();

        foreach ($model as $item){
            $status = 0;
            $markers[] = [$item->name,$item->lat, $item->long,$status,1];
        }
        return json_encode($markers);
    }



    public function actionEvent()
    {
        $model = new Event();


        if($model->load($this->request->post())){
            echo "<pre>";
            var_dump($model);
            exit;
        }

        return $this->render('event',[
            'model'=>$model
        ]);
    }

}
