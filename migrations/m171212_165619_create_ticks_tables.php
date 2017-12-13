<?php

use yii\db\Migration;

/**
 * Class m171212_165619_create_ticks_tables
 */
class m171212_165619_create_ticks_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ticks', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ticks');
    }
}
