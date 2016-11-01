<?php

use yii\db\Migration;

class m161022_182110_add_meta extends Migration
{
    protected $tables = ['page', 'article', 'article_category'];

    public function up()
    {
        foreach ($this->tables as $table) {
            $this->addColumn('{{%'.$table.'}}', 'meta_description', $this->string());
            $this->addColumn('{{%'.$table.'}}', 'meta_keywords', $this->string());
        }

        Yii::$app->keyStorage->set('frontend.meta_description', 'Meta description');
        Yii::$app->keyStorage->set('frontend.meta_keywords', 'Meta keywords');
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            $this->dropColumn('{{%'.$table.'}}', 'meta_description');
            $this->dropColumn('{{%'.$table.'}}', 'meta_keywords');
        }
    }
}
