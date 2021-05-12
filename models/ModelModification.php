<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%model_modification}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int $mark_id
 * @property int $model_id
 * @property string $body
 * @property string $generation_name
 * @property string $fuel
 * @property string $tKppType
 */
class ModelModification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%model_modification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark_id', 'model_id', 'body', 'generation_name', 'fuel', 'tKppType'], 'required'],
            [['mark_id', 'model_id'], 'integer'],
            [['name', 'body', 'generation_name', 'fuel', 'tKppType'], 'string', 'max' => 255],
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
            'body' => Yii::t('app', 'Body'),
            'generation_name' => Yii::t('app', 'Generation Name'),
            'fuel' => Yii::t('app', 'Fuel'),
            'tKppType' => Yii::t('app', 'T Kpp Type'),
        ];
    }
}
