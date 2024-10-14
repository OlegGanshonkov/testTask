<?php

use yii\db\Migration;

/**
 * Class m241011_215537_create_author
 */
class m241011_215537_create_author extends Migration
{
    public function up()
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'first' => $this->string()->notNull(),
            'last' => $this->string()->notNull(),
            'middle' => $this->string()->null(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null()
        ]);

    }

    public function down()
    {
        $this->dropTable('author');
    }

}
