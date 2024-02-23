<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "region_view".
 *
 * @property int $id
 * @property int|null $region_id
 * @property int|null $district_id
 * @property string|null $name_lot
 * @property string|null $center_lot
 * @property string|null $name_cyr
 * @property string|null $center_cyr
 * @property string|null $name_ru
 * @property string|null $center_ru
 * @property int $sector
 */
class RegionView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'region_id', 'district_id', 'sector'], 'integer'],
            [['name_lot', 'name_cyr', 'name_ru'], 'string', 'max' => 100],
            [['center_lot', 'center_cyr', 'center_ru'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'district_id' => 'District ID',
            'name_lot' => 'Name Lot',
            'center_lot' => 'Center Lot',
            'name_cyr' => 'Name Cyr',
            'center_cyr' => 'Center Cyr',
            'name_ru' => 'Name Ru',
            'center_ru' => 'Center Ru',
            'sector' => 'Sector',
        ];
    }
}
