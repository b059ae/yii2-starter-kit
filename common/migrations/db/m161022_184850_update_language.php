<?php

use yii\db\Migration;

class m161022_184850_update_language extends Migration
{
    public function up()
    {
        $this->update('{{%user_profile}}', [
            'locale' => 'ru-RU',
        ]);
    }

    public function down()
    {
    }
}
