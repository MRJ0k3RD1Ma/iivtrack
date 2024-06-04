<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "balans".
 *
 * @property int $id
 * @property string $date
 * @property int $type
 * @property float $summa
 * @property string|null $comment
 * @property string $date_end
 * @property int $status
 */
class Balans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type', 'summa', 'date_end'], 'required'],
            [['date', 'date_end'], 'safe'],
            [['type', 'status'], 'integer'],
            [['summa'], 'number'],
            [['comment'], 'string', 'max' => 345],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'type' => 'Type',
            'summa' => 'Summa',
            'comment' => 'Comment',
            'date_end' => 'Date End',
            'status' => 'Status',
        ];
    }
}
