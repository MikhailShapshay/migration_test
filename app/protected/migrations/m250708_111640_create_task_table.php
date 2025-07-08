<?php

class m250708_111640_create_task_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('task', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'is_done' => 'boolean NOT NULL DEFAULT 0',
        ), 'ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        $this->dropTable('task');
    }
}