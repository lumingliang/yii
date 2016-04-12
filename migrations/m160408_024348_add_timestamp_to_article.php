<?php

use yii\db\Migration;

class m160408_024348_add_timestamp_to_article extends Migration
{
    public function up()
    {
        $this->addColumn('articles_table', 'created_at', $this->timestamp());
        $this->addColumn('articles_table','updated_at', $this->TIMESTAMP());
    }

    public function down()
    {
        return false;
        // $this->dropColumn('articles_table', 'created_at')
    }
}
