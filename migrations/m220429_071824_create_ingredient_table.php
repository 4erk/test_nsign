<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ingredient}}`.
 */
class m220429_071824_create_ingredient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ingredient}}', [
            'id'     => $this->primaryKey(),
            'name'   => $this->string()->notNull()->unique(),
            'active' => $this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ingredient}}');
    }
}
