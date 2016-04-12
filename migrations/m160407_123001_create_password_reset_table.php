<?php

use yii\db\Migration;

class m160407_123001_create_password_reset_table extends Migration
{
    public function up()
    {
        $this->createTable('password_reset_table', [
            'id' => $this->primaryKey(),
            'email' => $this->string(10)->notNull(),
            'token' => $this->string(100)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('password_reset_table');
    }
}
