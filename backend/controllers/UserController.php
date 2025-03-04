<?php

namespace backend\controllers;


use backend\models\User;
use common\models\Call;
use common\models\CallResult;
use common\models\Shift;
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
use common\models\UserActiveHistory;


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
        $user->last_lat = $user->lat;
        $user->last_long = $user->long;
        $time = date('H:i');
        $time = explode(':',$time);
        $u = false;
        if($time[0] == 8){
            if($time[1] >= 30){
                $u = true;
            }
        }elseif($time[0] > 8 and $time[0] < 20){
            $u = true;
        }else{
            $one = Shift::findOne(['user_id'=>$user->id,'date'=>date('Y-m-d',strtotime('-1 day'))]);
            $two = Shift::findOne(['user_id'=>$user->id,'date'=>date('Y-m-d')]);
            if($time[0] < 8 and $one){
                $u = true;
            }elseif($time[0] <= 23 and $time[1] <= 59 and $two){
                $u = true;
            }
        }
 if($user->role_id == 18){
            // send request to urganchshypx.mnazorat.uz
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://urganchshypx.mnazorat.uz/api/track?phone='.$user->username.'&lat='.$lat.'&long='.$long,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }
        if(!$u){
            if($user->active != 2){
                $active = new UserActiveHistory();
                $active->user_id = $user->id;
                $active->active = date('Y-m-d H:i:s');
                $active->type = 2;
                $active->lat = $user->lat;
                $active->long = $user->long;
                $active->save(false);
            }
            $user->active = 2;
            $user->save(false);
            return [
                'success'=>true,
                'has_data'=>false,
            ];
        }
        $user->lat = $lat;
        $user->long = $long;
        $user->active_date = date('Y-m-d H:i:s');
        if($user->active != 1){
            $active = new UserActiveHistory();
            $active->user_id = $user->id;
            $active->active = date('Y-m-d H:i:s');
            $active->type = 1;
            $active->lat = $user->lat;
            $active->long = $user->long;
            $active->save(false);
        }
        $user->active = 1;
        $user->is_sms_send = 0;
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
        if($his->save(false)){
            $asabim = 10;
        }

        if($user->save(false)){
            if($model = Call::find()
                ->where(['user_id'=>$user->id])
                ->andWhere(['status'=>1])
                ->one()){
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
                        'map'=>'https://www.google.com/maps/search/?api=1&query='.$model->address0->lat.','.$model->address0->long
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

            $res = CallResult::find()->where(['call_id'=>$model->id])->orderBy(['id'=>SORT_DESC])->all();
            $result = [];
            foreach ($res as $item){
                $result [] = [
                    'id'=>$item->id,
                    'result'=>$item->result,
                ];
            }
            $u = false;
            if(count($res) > 0){
                $u = true;
            }
            $report_yuborish = true;
            if($model->status < 3){
                $report_yuborish = false;
            }
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
                    'map'=>'https://www.google.com/maps/search/?api=1&query='.$model->address0->lat.','.$model->address0->long,
                    'has_result'=>$u,
                    'send_result'=>$report_yuborish,
                    'result'=>$result
                ]
            ];
        }else{
            return [
                'success'=>false,
                'has_data'=>false,
            ];
        }
    }

    public function actionRunning($page = 1)
    {

        $model = Call::find()
            ->where(['<','status',3])
            ->andWhere(['user_id'=>Yii::$app->user->id])
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
            $data[] = [
                'id'=>$item->id,
                'address'=>$item->address,
                'map'=>'https://www.google.com/maps/search/?api=1&query='.$adr->lat.','.$adr->long,
                'code'=>$item->code,
                'name'=>$item->name,
                'phone'=>$item->phone,
                'type'=>$item->type->name,
                'detail'=>$item->detail,
                'created'=>$item->created,
            ];
        }
        return [
            'success'=>true,
            'totalcount'=>$count,
            'page'=>$page,
            'prev'=>$prev,
            'next'=>$next,
            'data'=>$data,

        ];
    }


    public function actionToday($page = 1)
    {
        $_7 = date('Y-m-d');
        $model = Call::find()
            ->filterWhere(['like','created',$_7])
            ->andWhere(['user_id'=>Yii::$app->user->id])
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
            $data[] = [
                'id'=>$item->id,
                'address'=>$item->address,
                'map'=>'https://www.google.com/maps/search/?api=1&query='.$adr->lat.','.$adr->long,
                'code'=>$item->code,
                'name'=>$item->name,
                'phone'=>$item->phone,
                'type'=>$item->type->name,
                'detail'=>$item->detail,
                'created'=>$item->created,
            ];
        }
        return [
            'success'=>true,
            'totalcount'=>$count,
            'page'=>$page,
            'prev'=>$prev,
            'next'=>$next,
            'data'=>$data,

        ];
    }
    public function actionWeek($page = 1)
    {
        $_7 = date('Y-m-d',strtotime('-7 days'));
        $model = Call::find()
            ->where(['>=','created',$_7])
            ->andWhere(['user_id'=>Yii::$app->user->id])
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
            $data[] = [
                'id'=>$item->id,
                'address'=>$item->address,
                'map'=>'https://www.google.com/maps/search/?api=1&query='.$adr->lat.','.$adr->long,
                'code'=>$item->code,
                'name'=>$item->name,
                'phone'=>$item->phone,
                'type'=>$item->type->name,
                'detail'=>$item->detail,
                'created'=>$item->created,
            ];
        }
        return [
            'success'=>true,
            'totalcount'=>$count,
            'page'=>$page,
            'prev'=>$prev,
            'next'=>$next,
            'data'=>$data,

        ];
    }
    public function actionMonth($page = 1)
    {
        $model = Call::find()
            ->filterWhere(['like','created',date('Y-m')])
            ->andWhere(['user_id'=>Yii::$app->user->id])
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
            $data[] = [
                'id'=>$item->id,
                'address'=>$item->address,
                'map'=>'https://www.google.com/maps/search/?api=1&query='.$adr->lat.','.$adr->long,
                'code'=>$item->code,
                'name'=>$item->name,
                'phone'=>$item->phone,
                'type'=>$item->type->name,
                'detail'=>$item->detail,
                'created'=>$item->created,
            ];
        }
        return [
            'success'=>true,
            'totalcount'=>$count,
            'page'=>$page,
            'prev'=>$prev,
            'next'=>$next,
            'data'=>$data,

        ];
    }

    public function actionReport($id)
    {
        if($model = Call::findOne($id)){
            if($model->status < 3){
                $c = new CallResult();
                $c->user_id = Yii::$app->user->id;
                $c->id = CallResult::find()->where(['call_id'=>$model->id])->max('id');
                if(!$c->id){
                    $c->id = 0;
                }
                $c->id ++;
                $c->call_id = $model->id;

                if($post = $this->request->post()){
                    $c->result = $post['result'];
                    $c->lat = $post['lat'];
                    $c->long = $post['long'];
                    $c->save(false);
                    $gender = [
                        0=>'Ayol',
                        1=>'Erkak',
                    ];
                    $res = CallResult::find()->where(['call_id'=>$model->id])->orderBy(['id'=>SORT_DESC])->all();
                    $result = [];
                    foreach ($res as $item){
                        $result [] = [
                            'id'=>$item->id,
                            'result'=>$item->result,
                        ];
                    }
                    $u = false;
                    if(count($res) > 0){
                        $u = true;
                    }

                    $report_yuborish = true;
                    if($model->status < 3){
                        $report_yuborish = false;
                    }

                    return [
                        'success'=>true,
                        'message'=>'Ushbu murojaatga javob yuborildi',
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
                            'map'=>'https://www.google.com/maps/search/?api=1&query='.$model->address0->lat.','.$model->address0->long,
                            'has_result'=>$u,
                            'send_result'=>$report_yuborish,
                            'result'=>$result
                        ]
                    ];
                }
            }else{
                $txt = "Ushbu chaqiruv bajarilgan";
                if($model->status == 3){
                    $txt = "Uchbu chaqiruvga javob berilgan va tasdiqlanishu kutilmoqda";
                }
                return [
                    'success'=>false,
                    'message'=>$txt
                ];
            }

        }else{
            return [
                'success'=>false,
                'message'=>'Bunday chaqiruv topilmadi'
            ];
        }
    }


}