<?php

namespace frontend\modules\profi\controllers;

use common\models\User;
use yii\web\Controller;
use Yii;
/**
 * Default controller for the `profi` module
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

    public function actionLocation($lat,$long)
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->lat = $lat;
        $user->long = $long;
        $user->active_date = date('Y-m-d h:i:s');
        $user->active = 1;
        if($user->save(false)){
            return 'success';
        }else{
            return 'error';
        }
    }
}
