<?php

namespace backend\controllers;


use backend\models\User;
use common\models\Call;
use common\models\UserHistory;
use Yii;
use yii\data\Pagination;
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
        $user->active_date = date('Y-m-d H:i:s');
        $user->active = 1;

        $his = new UserHistory();
        $his->year = date('Y');
        $his->month = date('m');
        $his->day = date('d');
        $his->hour = date('H');
        $his->minute = date('i');
        $his->second = date('s');
        $his->user_id = $user->id;
        $his->lat = $user->lat;
        $his->long = $user->long;
        $his->save(false);

        if($user->save(false)){
            if($model = Call::find()->where(['user_id'=>$user->id,'status'=>1])->one()){
                $gender = [
                    0=>'Ayol',
                    1=>'Erkak',
                ];
                $model->status = 2;
                $model->save(false);
                return [
                    'success'=>true,
                    'has_data'=>true,
                    'data'=>[
                        'id'=>$model->id,
                        'address'=>$model->address,
                        'code'=>$model->code,
                        'name'=>$model->name,
                        'phone'=>$model->phone,
                        'gender'=>$gender[$model->gender],
                        'type'=>$model->type->name,
                        'detail'=>$model->detail,
                        'created'=>$model->created,
                        'map'=>'https://www.google.com/maps/search/?api=1&query='.$model->lat.','.$model->long
                    ]
                ];
            }
            return [
                'success'=>true,
                'has_data'=>false,
            ];
        }else{
            return [
                'success'=>true,
                'has_data'=>false,
            ];
        }
    }


    public function actionView($id)
    {
        if($model = Call::findOne($id)){
            $gender = [
                0=>'Ayol',
                1=>'Erkak',
            ];
            return [
                'success'=>true,
                'has_data'=>true,
                'data'=>[
                    'id'=>$model->id,
                    'address'=>$model->address,
                    'code'=>$model->code,
                    'name'=>$model->name,
                    'phone'=>$model->phone,
                    'gender'=>$gender[$model->gender],
                    'type'=>$model->type->name,
                    'detail'=>$model->detail,
                    'created'=>$model->created,
                    'map'=>'https://www.google.com/maps/search/?api=1&query='.$model->address0->lat.','.$model->address0->long
                ]
            ];
        }else{
            return [
                'success'=>false,
                'has_data'=>false,
            ];
        }
    }


    public function actionWeek($page = 1)
    {
        $_7 = date('Y-m-d',time().' -7 days');
        $model = Call::find()

//            ->andWhere(['user_id'=>Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC]);

        $limit = 10;
        $offset = $limit * ($page - 1);
        $models = $model->offset($offset)
            ->limit($limit)
            ->all();
        $count = $model->count();
        if($count==0){
            return [
                'success'=>false,
                'message'=>'Chaqiruv topilmadi'
            ];
        }
        $next = -1;
        $prev = -1;
        if($page > 1){
            $prev = $page - 1;
        }
        if($offset+$limit < $count){
            $next = $page + 1;
        }
        $data = [];
        foreach ($models as $item){
            $adr = $item->address0;
            $data[$item->id] = [
                'id'=>$item->id,
                'address'=>$item->address,
                'map'=>'https://www.google.com/maps/search/?api=1&query='.$adr->lat.','.$adr->long,
                'code'=>$item->code
            ];
        }
        return [
            'success'=>true,
            '_7'=>$_7,
            'totalcount'=>$count,
            'page'=>$page,
            'prev'=>$prev,
            'next'=>$next,
            'data'=>$data,

        ];
    }


}