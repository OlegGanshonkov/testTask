<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m241013_221307_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('book_authors', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null()
        ]);

        $this->createIndex(
            'index_book_id',
            'book_authors',
            'book_id'
        );

        $this->createIndex(
            'index_author_id',
            'book_authors',
            'author_id'
        );
    }

    public function down()
    {
        $this->dropTable('book_authors');
    }
}
