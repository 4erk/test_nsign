<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dish_ingredient}}`.
 */
class m220429_072454_create_dish_ingredient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dish_ingredient}}', [
            'dish_id' => $this->integer()->notNull(),
            'ingredient_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-dish-ingredient','{{%dish_ingredient}}',['dish_id','ingredient_id'], true);
        $this->addForeignKey('fk-dish-ingredient-dish', '{{%dish_ingredient}}', 'dish_id', '{{%dish}}','id');
        $this->addForeignKey('fk-dish-ingredient-ingredient', '{{%dish_ingredient}}', 'ingredient_id', '{{%ingredient}}','id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-dish-ingredient-dish', '{{%dish_ingredient}}');
        $this->dropForeignKey('fk-dish-ingredient-ingredient', '{{%dish_ingredient}}');
        $this->dropTable('{{%dish_ingredient}}');
    }
}
