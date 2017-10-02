<?php

use profitcode\blocks\migrations\Migration;

class m170430_152107_init_blocks_module extends Migration
{

    public function up()
    {
        $this->createTable('{{%block}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'format' => $this->smallInteger()->notNull(),
            'active' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%block}}');
    }

}
