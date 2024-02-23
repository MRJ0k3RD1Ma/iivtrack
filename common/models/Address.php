<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property string $address
 * @property string $lat
 * @property string $long
 * @property string|null $created
 * @property string|null $updated
 * @property int $user_id
 * @property int|null $soato_id
 *
 * @property User $user
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'lat', 'long', ], 'required'],
            [['created', 'updated'], 'safe'],
            [['user_id', 'soato_id'], 'integer'],
            [['address'], 'string', 'max' => 500],
            [['lat', 'long'], 'string', 'max' => 255],
            [['address'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'address' => 'Manzil',
            'lat' => 'Lat',
            'long' => 'Long',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'user_id' => 'User ID',
            'soato_id' => 'Soato ID',
        ];
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
