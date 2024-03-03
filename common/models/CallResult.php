<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_result".
 *
 * @property int $id
 * @property int $call_id
 * @property int $user_id
 * @property string|null $result
 * @property string|null $image
 * @property string|null $image1
 * @property string|null $image2
 * @property string|null $image4
 * @property int|null $consept_id
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $status
 * @property string|null $lat
 * @property string|null $long
 *
 * @property Call $call
 * @property User $consept
 * @property User $user
 */
class CallResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'call_id', 'user_id'], 'required'],
            [['id', 'call_id', 'user_id', 'consept_id', 'status'], 'integer'],
            [['result'], 'string'],
            [['created', 'updated'], 'safe'],
            [['image', 'image1', 'image2', 'image4', 'lat', 'long'], 'string', 'max' => 255],
            [['id', 'call_id', 'user_id'], 'unique', 'targetAttribute' => ['id', 'call_id', 'user_id']],
            [['call_id'], 'exist', 'skipOnError' => true, 'targetClass' => Call::class, 'targetAttribute' => ['call_id' => 'id']],
            [['consept_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['consept_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_id' => 'Chaqiruv',
            'user_id' => 'Ijrochi',
            'result' => 'Natija',
            'image' => 'Rasm',
            'image1' => 'Rasm',
            'image2' => 'Rasm',
            'image4' => 'Rasm',
            'consept_id' => 'Tasdiqladi',
            'created' => 'Kiritildi',
            'updated' => 'Tasdiqlandi',
            'status' => 'Status',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    /**
     * Gets query for [[Call]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCall()
    {
        return $this->hasOne(Call::class, ['id' => 'call_id']);
    }

    /**
     * Gets query for [[Consept]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsept()
    {
        return $this->hasOne(User::class, ['id' => 'consept_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
