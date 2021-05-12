<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mark_model}}".
 *
 * @property int $id
 * @property int $mark_id
 * @property string $name
 */
class MarkModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mark_model}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark_id', 'name'], 'required'],
            [['mark_id'], 'integer'],
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
            'mark_id' => Yii::t('app', 'Mark ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
