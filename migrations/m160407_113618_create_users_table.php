<?php

use yii\db\Migration;

class m160407_113618_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('users_table', [
            'id' => $this->primaryKey(),
            'email' => $this->string(20)->notNull()->unique(),
            'name' => $this->string(20),
            'password' => $this->string(100)->notNull(),
            'rememberToken' => $this->string(100),
            'role_id' => $this->integer()->notNull(),
            // created_at,updated_at

        ]);
    }

    public function down()
    {
        $this->dropTable('users_table');
    }
}
