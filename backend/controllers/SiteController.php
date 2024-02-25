<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionLogin(){

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->getBodyParams(),'')) {

            if( $model->login()){

                $user = Yii::$app->user->identity;

                $token = $this->generateToken($user);


                return [
                    'token' => (string) $token,
                ];
            }else{
                return [$model->getFirstErrors()];
            }
        } else {
            throw new HttpException(400, 'Bad request');
        }
    }


    public function actionRefreshToken(){
        if($token = Yii::$app->request->post('token')){

            $user = User::findOne(['access_token'=>$token]);

            $token = $this->generateToken($user);

            return [
                'token' => (string) $token,
            ];
        }else{
            throw new HttpException(204, 'OK');
            return false;
        }
    }

    private function generateToken($user)
    {
        $expiry = 86400;
        $issuedAt = time();
        $expire = $issuedAt + $expiry;
        $payload = [
            'id' => $user->id,
            'iat' => $issuedAt,
            'nbf' => $expire,
            'name'=>$user->name,
        ];
        $token = Yii::$app->jwt->generateToken($payload);


        return $token;
    }

    public function actionValidateToken($token)
    {
        $isValid = Yii::$app->jwt->validateToken($token);
        return ['valid' => $isValid];
    }


    public function actionCheck(){
        $token = Yii::$app->user->identity->access_token;

        $decode = Yii::$app->jwt->decodeToken($token);

        return ['nbf'=>$decode->nbf,'time'=>time(),
            'check'=>$decode->nbf < time()];

    }
}
