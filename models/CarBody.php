<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%car_body}}".
 *
 * @property int $id
 * @property string $name
 * @property int $mark_id
 * @property int $model_id
 */
class CarBody extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_body}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mark_id', 'model_id'], 'required'],
            [['mark_id', 'model_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'mark_id' => Yii::t('app', 'Mark ID'),
            'model_id' => Yii::t('app', 'Model ID'),
        ];
    }
}
