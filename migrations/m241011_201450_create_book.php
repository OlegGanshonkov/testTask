<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m241011_201450_create_book
 */
class m241011_201450_create_book extends Migration
{
    public function up()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'year' => 'year NOT NULL',
            'description' => $this->text()->null(),
            'isbn' => $this->char(17)->notNull(),
            'photo' => $this->string()->null(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null()
        ]);

        $this->createIndex(
            'index_year',
            'book',
            'year'
        );
    }

    public function down()
    {
        $this->dropTable('book');
    }

}
