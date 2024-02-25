<?php

namespace backend\controllers;


use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\Response;


class UserController extends Controller
{
    public function behaviors() {

        return [
            'corsFilter'=>[
                'class' => Cors::class,
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
        ];
    }

    public function actionMe()
    {

        $user = Yii::$app->user->identity;
        /* @var $user \backend\models\User */
        return [
            'name'=>$user->name,
            'username'=>$user->username,
            'image'=>Yii::$app->request->hostInfo.'/upload/'.$user->image,
        ];
    }


    public function actionTrack($lat,$long)
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->lat = $lat;
        $user->long = $long;
        $user->active_date = date('Y-m-d h:i:s');
        $user->active = 1;
        $user->save(false);

        return ['success'=>true];
    }


}