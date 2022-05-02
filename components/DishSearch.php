<?php

namespace app\components;

use app\models\Dish;
use app\models\Ingredient;
use yii\db\Query;

class DishSearch
{
    public static function getDishesByFullIngredientsQuery($ingredients)
    {
        $query = static::getBaseDishesQuery($ingredients);
        /** Query for check full coincidence */
        $queryIngredientCount = new Query();
        $queryIngredientCount->select('count(*)')->from('dish_ingredient di2')
            ->where('di2.dish_id = dish.id');

        $query->having(['cnt' => $queryIngredientCount])
            ->andHaving(['cnt' => count($ingredients)]);
        return $query;
    }

    private static function getBaseDishesQuery($ingredients)
    {
        $query = Dish::find()->select(['dish.*', 'cnt' => 'count(*)'])
            ->innerJoin(['di' => 'dish_ingredient'], 'di.dish_id = dish.id')
            ->where(['in', 'di.ingredient_id', $ingredients])->groupBy('dish.id');

        /** Query for exclude dish with inactive ingredients  */
        $queryExcludeInactive = Ingredient::find()->innerJoin(['di' => 'dish_ingredient'], 'di.ingredient_id = ingredient.id')
            ->where(['ingredient.active' => 0])->select('di.dish_id');

        $query->andWhere(['not in', 'dish.id', $queryExcludeInactive]);

        return $query;
    }

    public static function getDishesByPartIngredientsQuery($ingredients)
    {
        $query = static::getBaseDishesQuery($ingredients);
        $query->having('cnt > 1')->orderBy(['cnt' => SORT_DESC]);
        return $query;
    }

}