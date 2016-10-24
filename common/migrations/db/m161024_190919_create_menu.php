<?php

use yii\db\Migration;

class m161024_190919_create_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(32)->notNull(),
            'title' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer(),
            'parent_id' => $this->integer(),
            'title' => $this->string(255)->notNull(),
            'url' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_menu_item', '{{%menu_item}}', 'menu_id', '{{%menu}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_menu_item_parent', '{{%menu_item}}', 'parent_id', '{{%menu_item}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%menu_item}}');
        $this->dropTable('{{%menu}}');
    }
}
