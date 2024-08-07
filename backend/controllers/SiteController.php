<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use common\models\Balans;
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
    public function getphone($phone){
        $phone_new = "";
        if(strlen($phone) < 9 ){
            return false;
        }
        for ($i=0; $i<strlen($phone);  $i++){
            if('0'<=$phone[$i] and $phone[$i] <= '9'){
                $phone_new.= $phone[$i];
            }
        }
        if(strlen($phone_new) > 9){
            if($phone_new[0]=='9' and $phone_new[1]=='9' and $phone_new[2]=='8'){
                $phone_new = substr($phone_new,3,strlen($phone_new));
            }else{
                return false;
            }
        }
//        (99)967-0395

        return '('.substr($phone_new,0,2).')'.substr($phone_new,2,3).'-'.substr($phone_new,5,4);
    }
    public function actionLogin(){

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->getBodyParams(),'')) {
            $phone = $this->getphone($model->username);
            $model->username = $phone;
            if( $model->login()){

                $user = Yii::$app->user->identity;

                $token = $this->generateToken($user);

                return [
                    'token' => (string) $token,
//                    'change'=>Yii::$app->user->identity->status == 1 ? true : false,
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

    public function actionBalans()
    {
        if(Yii::$app->params['localpasscode'] == Yii::$app->request->post('pascode')){

        }else{
            throw new HttpException(404, 'Page not found');
        }
    }
}
