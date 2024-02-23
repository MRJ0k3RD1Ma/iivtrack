<?php

namespace frontend\modules\cc;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * cp module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\cc\controllers';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback'=>function($rule, $action){
                            if(Yii::$app->user->identity->role_id != 30){
                                $url = Yii::$app->user->identity->role->url;
                                header('Location:'.$url);
                                exit;
                            }else{
                                return true;
                            }
                        }
                    ],

                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::$app->layoutPath = "@frontend/modules/cc/views/layouts";

        // custom initialization code goes here
    }
}
