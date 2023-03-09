<?php

use yii\db\Migration;

/**
 * Class m230308_182026_CLINIC_TABLES
 */
class m230308_182026_CLINIC_TABLES extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('clinic_date', [
            'id' => $this->primaryKey()->unsigned(),
            'datetime' => $this->dateTime()->notNull(),
            'type_id' => $this->integer()->notNull()->unsigned(),
            'patient_id' => $this->integer()->notNull()->unsigned() 
        ]);
        
        $this->createTable('patient', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'NID' => $this->string()->notNull(),
            'phone' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            
        ]);

        $this->createTable('type', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull()
        ]);

        $this->addForeignKey(
            'fk-clinic_date-type_id',
            'clinic_date',
            'type_id',
            'type',
            'id'
        );

        $this->addForeignKey(
            'fk-clinic_date-user_id',
            'clinic_date',
            'patient_id',
            'patient',
            'id'
        );

        Yii::$app->db->createCommand()->batchInsert(
            'type',
            ['id', 'name'],
            [
                ['1', 'EN REVISIÓN'],
                ['2', 'PRIMERA CONSULTA'],
            ]
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230308_182026_CLINIC_TABLES cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230308_182026_CLINIC_TABLES cannot be reverted.\n";

        return false;
    }
    */
}
