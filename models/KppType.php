<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%kpp_type}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int $mark_id
 * @property int $model_id
 */
class KppType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%kpp_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark_id', 'model_id'], 'required'],
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
