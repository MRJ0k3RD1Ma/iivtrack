<?php

namespace frontend\components;

use yii\base\Component;
use Yii;

class Sms extends Component{
    public static function getphone($phone){
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

        return $phone_new;
    }
    public static function send($phone, $text){
        $token = static::getToken();

        $url = Yii::$app->params['sms']['url']['send']['url'];
        $authorization = "Authorization: Bearer ".$token;

        $post = [
            'mobile_phone'=>'998'.static::getphone($phone),
            'message'=>$text,
            'from'=>'4546',
            'callback_url'=>"http://bestit.uz/sms/status"
        ];

        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_POSTFIELDS => json_encode($post),
            CURLOPT_HTTPHEADER     => array('Content-Type: application/json' , $authorization ),
            CURLOPT_USERAGENT      => "bestit.uz", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
            CURLOPT_SSL_VERIFYHOST=>0,
            CURLOPT_SSL_VERIFYPEER=>0,
            CURLOPT_CUSTOMREQUEST  => Yii::$app->params['sms']['url']['send']['method'],
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        $content = json_decode($content,true);
        if(isset($content['id'])){
            return $content['id'];
        }else{
            return false;
        }
        echo "<pre>";
        var_dump($content);
        exit;
    }


    public static function getToken(){

        $url = Yii::$app->params['sms']['url']['auth']['url'].'?email='.Yii::$app->params['sms']['email'].'&password='.Yii::$app->params['sms']['password'];

        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "bestit.uz", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
            CURLOPT_CUSTOMREQUEST  => Yii::$app->params['sms']['url']['auth']['method'],
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        $content = json_decode($content,true);

        if($content){
            return $content['data']['token'];
        }
        return -1;
    }




}