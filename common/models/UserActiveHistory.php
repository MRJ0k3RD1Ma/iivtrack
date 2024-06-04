<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_active_history".
 *
 * @property int $user_id
 * @property string $active
 * @property int $type
 * @property int|null $status
 * @property string|null $lat
 * @property string|null $long
 */
class UserActiveHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_active_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'active', 'type'], 'required'],
            [['user_id', 'type', 'status'], 'integer'],
            [['active'], 'safe'],
            [['lat', 'long'], 'string', 'max' => 255],
            [['user_id', 'active'], 'unique', 'targetAttribute' => ['user_id', 'active']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'active' => 'Active',
            'type' => 'Type',
            'status' => 'Status',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }
}
