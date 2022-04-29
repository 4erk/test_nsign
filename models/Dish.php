<?php

namespace app\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dish".
 *
 * @property int $id
 * @property string $name
 *
 * @property Ingredient[] $ingredients
 */
class Dish extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dish';
    }

    public function behaviors() {
        return [
            'relations' => [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'ingredients'
                ],
            ]
        ];
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
            [['ingredients'], 'safe']
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
     * Gets query for [[Ingredients]].
     *
     * @return ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::class, ['id' => 'ingredient_id'])->viaTable('dish_ingredient', ['dish_id' => 'id']);
    }
}
