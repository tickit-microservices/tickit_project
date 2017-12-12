<?php

use yii\db\Migration;

/**
 * Handles the creation of table `projects`.
 */
class m171207_170922_create_projects_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('projects', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created' => $this->dateTime(),
            'modified' => $this->dateTime(),
            'created_by' => $this->dateTime(),
            'modified_by' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('projects');
    }
}
