<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_history".
 *
 * @property int $user_id
 * @property int $year
 * @property int $month
 * @property int $day
 * @property int $hour
 * @property int $minute
 * @property int $second
 * @property string|null $lat
 * @property string|null $long
 * @property string|null $created
 * @property string|null $updated
 */
class UserHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'month', 'day', 'hour', 'minute', 'second'], 'required'],
            [['user_id', 'year', 'month', 'day', 'hour', 'minute', 'second'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['lat', 'long'], 'string', 'max' => 255],
            [['user_id', 'year', 'month', 'day', 'hour', 'minute', 'second'], 'unique', 'targetAttribute' => ['user_id', 'year', 'month', 'day', 'hour', 'minute', 'second']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'year' => 'Yil',
            'month' => 'Oy',
            'day' => 'Kun',
            'hour' => 'Soat',
            'minute' => 'Minut',
            'second' => 'Sekund',
            'lat' => 'Lat',
            'long' => 'Long',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
