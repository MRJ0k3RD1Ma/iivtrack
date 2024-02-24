<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Call[] $calls
 */
class CallType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Calls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCalls()
    {
        return $this->hasMany(Call::class, ['type_id' => 'id']);
    }
}
