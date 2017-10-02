<?php

use profitcode\blocks\migrations\Migration;

class m170501_114538_change_format_filed_type extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%block}}', 'format', $this->string()->notNull()->defaultValue('raw'));
    }

    public function down()
    {
        $this->alterColumn('{{%block}}', 'format', $this->smallInteger()->notNull());
    }
}
