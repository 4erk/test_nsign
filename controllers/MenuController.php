<?php

namespace app\controllers;

use app\models\Dish;
use app\models\MenuForm;
use Yii;
use yii\db\Query;
use yii\web\Controller;

class MenuController extends Controller
{
    public function actionIndex()
    {
        $model = new MenuForm();
        $model->load(Yii::$app->request->post());

        $error  = false;
        $dishes = [];
        if ($model->validate()) {
            $cntIngredients = count($model->ingredients);
            if ($cntIngredients < 2) {
                $error = 'Choose more ingredients';
            }
            if ($cntIngredients > 5) {
                $error = 'Choose fewer ingredients';
            }
        }

        if (!$error) {
            /** Base query */
            $query = Dish::find()->select(['dish.*', 'cnt' => 'count(*)'])
                ->innerJoin(['di' => 'dish_ingredient'], 'di.dish_id = dish.id')
                ->where(['in', 'di.ingredient_id', $model->ingredients])->groupBy('dish.id');

            /** Query for full coincidence ingredients */
            $queryFull = clone $query;

            /** Query for check full coincidence */
            $queryIngredientCount = new Query();
            $queryIngredientCount->select('count(*)')->from('dish_ingredient di2')
                ->where('di2.dish_id = dish.id');

            $queryFull->having(['cnt' => $queryIngredientCount])
                ->andHaving(['cnt' => count($model->ingredients)]);
            if ($queryFull->count() > 0) {
                $dishes = $queryFull->all();
            }
            else {
                $queryPart = clone $query;
                $queryPart->having('cnt > 1')->orderBy(['cnt' => SORT_DESC]);
                if ($queryPart->count() > 0) {
                    $dishes = $queryPart->all();
                }
                else {
                    $error = 'Dishes not found';
                }
            }
        }
        return $this->render('index', ['model' => $model, 'error' => $error, 'dishes' => $dishes]);
    }

}
