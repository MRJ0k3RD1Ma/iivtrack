<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shift".
 *
 * @property string $date
 * @property int $user_id
 * @property int $shift_id
 */
class Shift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'user_id', 'shift_id'], 'required'],
            [['date'], 'safe'],
            [['user_id', 'shift_id'], 'integer'],
            [['date', 'user_id', 'shift_id'], 'unique', 'targetAttribute' => ['date', 'user_id', 'shift_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Sana',
            'user_id' => 'Hodim',
            'shift_id' => 'Guruh',
        ];
    }
}
