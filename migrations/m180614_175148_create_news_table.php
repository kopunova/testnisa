<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180614_175148_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
			'name' => $this->string(),
        ]);
		
		$this->batchInsert('news', ['name'], [
			['name 1'],
			['name 2'],
			['name 3'],
			['name 4'],
			['name 5'],
			['name 6'],
			['name 7'],
			['name 8'],
			['name 9'],
			['name 10'],
			['name 11'],
			['name 12'],
			['name 13'],
			['name 14'],
			['name 15'],
					
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}














