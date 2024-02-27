<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_dot".
 *
 * @property int $id
 * @property int $event_id
 * @property string|null $lat
 * @property string|null $long
 *
 * @property Event $event
 */
class EventDot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_dot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'event_id'], 'required'],
            [['id', 'event_id'], 'integer'],
            [['lat', 'long'], 'string', 'max' => 255],
            [['id', 'event_id'], 'unique', 'targetAttribute' => ['id', 'event_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }
}
