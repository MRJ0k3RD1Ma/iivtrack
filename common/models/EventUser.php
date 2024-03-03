<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_user".
 *
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property string|null $created
 * @property string|null $updated
 * @property string $time_start
 * @property string $time_end
 */
class EventUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'event_id', 'user_id', 'time_start', 'time_end'], 'required'],
            [['id', 'event_id', 'user_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['time_start', 'time_end'], 'string', 'max' => 255],
            [['id', 'event_id'], 'unique', 'targetAttribute' => ['id', 'event_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Tarbit',
            'user_id' => 'Hodim',
            'created' => 'Created',
            'updated' => 'Updated',
            'time_start' => 'Boshlashi',
            'time_end' => 'Tugatishi',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::class,['id'=>'user_id']);
    }

    public function getEvent()
    {
        return $this->hasOne(Event::class,['id'=>'event_id']);
    }
}
