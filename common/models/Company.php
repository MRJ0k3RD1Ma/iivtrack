<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property string|null $location
 * @property string|null $lat
 * @property string|null $long
 * @property string|null $phone
 * @property string|null $phone2
 * @property string|null $wifi
 * @property string|null $work_begin
 * @property string|null $work_end
 * @property int|null $status
 * @property int|null $work_status
 * @property int|null $theme_id
 * @property string|null $created
 * @property string|null $updated
 * @property string $address
 * @property string|null $target
 * @property string|null $alias url uchun qisqa nom
 * @property int|null $soato_id
 *
 * @property Soato $soato
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location'], 'string'],
            [['status', 'work_status', 'theme_id', 'soato_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name', 'address', 'target'], 'string', 'max' => 500],
            [['logo', 'lat', 'long', 'phone', 'phone2', 'wifi', 'work_begin', 'work_end', 'alias'], 'string', 'max' => 255],
            [['soato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Soato::class, 'targetAttribute' => ['soato_id' => 'id']],
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
            'logo' => 'Logo',
            'location' => 'Location',
            'lat' => 'Lat',
            'long' => 'Long',
            'phone' => 'Phone',
            'phone2' => 'Phone2',
            'wifi' => 'Wifi',
            'work_begin' => 'Work Begin',
            'work_end' => 'Work End',
            'status' => 'Status',
            'work_status' => 'Work Status',
            'theme_id' => 'Theme ID',
            'created' => 'Created',
            'updated' => 'Updated',
            'address' => 'Address',
            'target' => 'Target',
            'alias' => 'Alias',
            'soato_id' => 'Soato ID',
        ];
    }

    /**
     * Gets query for [[Soato]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSoato()
    {
        return $this->hasOne(Soato::class, ['id' => 'soato_id']);
    }
}
