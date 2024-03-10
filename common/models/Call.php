<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call".
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $code_id
 * @property string|null $name
 * @property string|null $phone
 * @property int|null $gender
 * @property int|null $type_id
 * @property string|null $detail
 * @property string|null $address
 * @property int|null $user_id
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $status
 *
 * @property Address $address0
 * @property CallType $type
 */
class Call extends \yii\db\ActiveRecord
{
    public $to,$do;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code_id', 'gender', 'type_id', 'user_id', 'status'], 'integer'],
            [['created', 'updated','to','do'], 'safe'],
            [['code', 'name', 'phone', 'detail', 'address'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['address'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address' => 'address']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CallType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Kod',
            'code_id' => 'Code ID',
            'name' => 'FIO',
            'phone' => 'Telefon',
            'gender' => 'Jinsi',
            'type_id' => 'Murojaat turi',
            'detail' => 'Batafsil',
            'address' => 'Manzil',
            'user_id' => 'Ijrochi',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'status' => 'Status',
            'to' => 'Dan..',
            'do' => '..Gacha',
        ];
    }

    /**
     * Gets query for [[Address0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress0()
    {
        return $this->hasOne(Address::class, ['address' => 'address']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class,['id'=>'user_id']);
    }
    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CallType::class, ['id' => 'type_id']);
    }
}
