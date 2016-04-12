<?php

use yii\db\Migration;

class m160407_114241_create_articles_table extends Migration
{
    public function up()
    {
        $this->createTable('articles_table', [
            'id' => $this->primaryKey(),
            'title' => $this->string(20)->notNull(),
            'content' => $this->string(1000)->notNull(),
            'user_id' => $this->integer(10),
        ]);
    }

    public function down()
    {
        $this->dropTable('articles_table');
    }
}
