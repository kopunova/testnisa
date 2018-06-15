<?php

use yii\db\Migration;

/**
 * Handles the creation of table `log`.
 */
class m180614_190911_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log', [
            'id' => $this->primaryKey(),
			'news_id' => $this->integer(),
			'action' => $this->string(), // click, unique_click
			'country_code' => $this->string(),
			'date' => $this->date(),
        ]);
		
		$this->createIndex(
            'idx-log-news_id',
            'log',
            'news_id'
        );
		
        $this->addForeignKey(
            'fk-log-news_id',
            'log',
            'news_id',
            'news',
            'id',
            'CASCADE',
			'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropForeignKey(
            'fk-log-news_id',
            'log'
        );
		
		$this->dropIndex(
            'idx-log-news_id',
            'log'
        );
		
        $this->dropTable('log');
    }
}
