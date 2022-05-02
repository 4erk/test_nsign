<?php

namespace app\controllers;

use app\components\DishSearch;
use app\models\MenuForm;
use Yii;
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
            $query = DishSearch::getDishesByFullIngredientsQuery($model->ingredients);

            if ($query->count() > 0) {
                $dishes = $query->all();
            }
            else {
                /** Query for part coincidence */
                $query = DishSearch::getDishesByPartIngredientsQuery($model->ingredients);
                if ($query->count() > 0) {
                    $dishes = $query->all();
                }
                else {
                    $error = 'Dishes not found';
                }
            }
        }
        return $this->render('index', ['model' => $model, 'error' => $error, 'dishes' => $dishes]);
    }
}
