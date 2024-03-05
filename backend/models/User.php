<?php

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\base\ExitException;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;
use backend\components\JwtCom;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string|null $password
 * @property string|null $auth_key
 * @property string|null $token
 * @property string|null $code
 * @property string|null $access_token
 * @property string|null $created
 * @property string|null $updated
 * @property string|null $image
 * @property int|null $status
 * @property int|null $role_id
 *
 * @property UserRole $role
 * @property integer $companyid
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_NOT_ACTIVE = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 3;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created', 'updated','active_date'], 'safe'],
            [['status', 'role_id','active'], 'integer'],
            [['image'],'file','extensions'=>['jpg','png','jpeg']],
            [['name', 'auth_key', 'token', 'code','image','lat','long'], 'string', 'max' => 255],
            [['password', 'access_token'], 'string', 'max' => 500],
            [['username'],'string','length'=>12],
            [['username','name'],'required'],
            ['username','unique','message'=>'Bunday telefon raqamidan foydalanilgan'],
            [['password'],'required','on'=>'insert'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'FIO',
            'username' => 'Telefon',
            'password' => 'Parol',
            'auth_key' => 'Auth Key',
            'image' => 'Rasm',
            'token' => 'Token',
            'code' => 'SMS Kod',
            'access_token' => 'Access Token',
            'created' => 'Yaratildi',
            'updated' => 'O`zgartirildi',
            'status' => 'Status',
            'role_id' => 'Role',
            'lat'=>'Kenglik',
            'long'=>'Uzunlik',
            'active'=>'Aktiv',
            'active_date'=>'So`ngi aktivlik'
        ];
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRole::class, ['id' => 'role_id']);
    }


/*    public function getCompanyid(){
        $com = UserCompany::findOne(['user_id'=>$this->id]);
        if($com){
            return $com->company_id;
        }else{
            throw new ExitException("404",'Bunday Restoran/kafe topilmadi');
        }
    }*/

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {


        return static::find()
            ->where(['access_token' => $token ])
            ->one();


        JWT::$leeway = 86400;
        $isValid = Yii::$app->jwt->validateToken($token);
        if($isValid){
            return static::find()
                ->where(['access_token' => $token ])
                ->one();
            $decode = Yii::$app->jwt->decodeToken($token);
            if(intval($decode->nbf) >= time()){
                return static::find()
                    ->where(['access_token' => $token ])
                    ->one();
            }else{
                return null;
            }
        }else{
            return null;
        }
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}