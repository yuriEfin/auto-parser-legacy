<?php

use yii\db\Migration;

/**
 * Class m210330_214126_createTable_mark
 */
class m210330_214126_createTable_mark extends Migration
{
    private $tMark = 'mark';
    private $tModel = 'mark_model';
    private $tModelModif = 'model_modification';
    private $tKppType = 'kpp_type';
    private $tCarBody = 'car_body';
    private $tGeneration = 'car_generation';
    private $tFuel = 'car_fuel';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tMark,
            [
                'id'   => $this->primaryKey(),
                'name' => $this->string()->notNull(),
            ]
        );
        $this->createTable(
            $this->tModel,
            [
                'id'      => $this->primaryKey(),
                'mark_id' => $this->integer()->notNull(),
                'name'    => $this->string()->notNull(),
            ]
        );
        $this->createTable(
            $this->tModelModif,
            [
                'id'       => $this->primaryKey(),
                'name'     => $this->string(),
                'mark_id'  => $this->integer()->notNull(),
                'model_id' => $this->integer()->notNull(),
                'body' => $this->string()->notNull(),
                'generation_name' => $this->string()->notNull(),
                'fuel' => $this->string()->notNull(),
                'tKppType' => $this->string()->notNull(),
            ]
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(
            $this->tMark
        );
        $this->dropTable(
            $this->tModel
        );
        $this->dropTable(
            $this->tModelModif
        );
        $this->dropTable(
            $this->tKppType
        );
        $this->dropTable(
            $this->tCarBody
        );
        $this->dropTable(
            $this->tGeneration
        );
        $this->dropTable(
            $this->tFuel
        );
    }
}
