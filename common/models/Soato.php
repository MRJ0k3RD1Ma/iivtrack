<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "soato".
 *
 * @property int $id
 * @property int|null $res_id
 * @property int|null $region_id
 * @property int|null $district_id
 * @property int|null $qfi_id
 * @property int|null $mahalla_id
 * @property string|null $name_lot
 * @property string|null $center_lot
 * @property string|null $name_cyr
 * @property string|null $center_cyr
 * @property string|null $name_ru
 * @property string|null $center_ru
 * @property int $sector
 *
 * @property Company[] $companies
 */
class Soato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'soato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'res_id', 'region_id', 'district_id', 'qfi_id', 'mahalla_id', 'sector'], 'integer'],
            [['name_lot', 'name_cyr', 'name_ru'], 'string', 'max' => 100],
            [['center_lot', 'center_cyr', 'center_ru'], 'string', 'max' => 50],
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
            'res_id' => 'Res ID',
            'region_id' => 'Region ID',
            'district_id' => 'District ID',
            'qfi_id' => 'Qfi ID',
            'mahalla_id' => 'Mahalla ID',
            'name_lot' => 'Name Lot',
            'center_lot' => 'Center Lot',
            'name_cyr' => 'Name Cyr',
            'center_cyr' => 'Center Cyr',
            'name_ru' => 'Name Ru',
            'center_ru' => 'Center Ru',
            'sector' => 'Sector',
        ];
    }

    /**
     * Gets query for [[Companies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::class, ['soato_id' => 'id']);
    }
}
