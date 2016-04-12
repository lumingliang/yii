<?php

use yii\db\Migration;

class m160408_032446_add_timestamp_to_article extends Migration
{
    public function up()
    {
        $this->dropColumn('articles_table', 'created_at');
        $this->addColumn('articles_table','created_at', $this->TIMESTAMP());
    }

    public function down()
    {
    }
}
