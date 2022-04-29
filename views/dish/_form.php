<?php

use app\models\Ingredient;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $form yii\widgets\ActiveForm */


$ingredientList = ArrayHelper::map(Ingredient::find()->all(), 'id', 'name');
?>

<div class="dish-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingredients')
        ->checkboxList($ingredientList, ['itemOptions' => ['labelOptions' => ['class' => 'col-md-3']]]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
