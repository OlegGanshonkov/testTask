<?php

use yii\db\Migration;

/**
 * Class m241014_084219_create_author_subscribers
 */
class m241014_084219_create_author_subscribers extends Migration
{
    public function up()
    {
        $this->createTable('author_subscribers', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null()
        ]);

        $this->createIndex(
            'index_sub_author_id',
            'author_subscribers',
            'author_id'
        );

        $this->createIndex(
            'index_sub_user_id',
            'author_subscribers',
            'user_id'
        );
    }

    public function down()
    {
        $this->dropTable('book_authors');
    }
}
