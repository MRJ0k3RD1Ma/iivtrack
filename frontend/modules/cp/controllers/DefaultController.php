<?php

namespace frontend\modules\cp\controllers;

use common\models\DistrictView;
use common\models\User;
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
        return $this->render('index');
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
}
