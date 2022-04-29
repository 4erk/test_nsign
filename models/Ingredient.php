<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ingredient".
 *
 * @property int              $id
 * @property string           $name
 * @property int              $active
 *
 * @property DishIngredient[] $dishIngredients
 * @property Dish[]           $dishes
 */
class Ingredient extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['active'], 'integer'],
            [['active'], 'default', 'value' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[DishIngredients]].
     *
     * @return ActiveQuery
     */
    public function getDishIngredients()
    {
        return $this->hasMany(DishIngredient::className(), ['ingredient_id' => 'id']);
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dish::className(), ['id' => 'dish_id'])->viaTable('dish_ingredient', ['ingredient_id' => 'id']);
    }
}
