<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $date_start
 * @property string|null $date_end
 * @property string|null $radius
 * @property string|null $detail
 * @property int $type_id
 * @property string|null $address
 * @property string|null $lat
 * @property string|null $long
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $status
 *
 * @property EventDot[] $eventDots
 * @property EventType $type
 * @property User $user
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id','date_start', 'date_end','detail','radius', 'lat', 'long'], 'required'],
            [['id', 'user_id', 'type_id', 'status'], 'integer'],
            [['date_start', 'date_end', 'created', 'updated'], 'safe'],
            [['detail'], 'string'],
            [['radius', 'address', 'lat', 'long'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::class, 'targetAttribute' => ['type_id' => 'id']],
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
            'user_id' => 'Registrator',
            'date_start' => 'Tadbir boshlash sanasi',
            'date_end' => 'Tadbir tugash sanasi',
            'radius' => 'Radius',
            'detail' => 'Batafsil',
            'type_id' => 'Tadbir turi',
            'address' => 'Manzil',
            'lat' => 'Lat',
            'long' => 'Long',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[EventDots]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventDots()
    {
        return $this->hasMany(EventDot::class, ['event_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(EventType::class, ['id' => 'type_id']);
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
