<?php

use yii\db\Migration;

class m160407_113705_create_roles_table extends Migration
{
    public function up()
    {
        $this->createTable('roles_table', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('roles_table');
    }
}
