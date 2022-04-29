<?php
/* @var $this yii\web\View */
/* @var $model MenuForm */
/* @var $error string */

/* @var $dishes Dish[] */

use app\models\Dish;
use app\models\Ingredient;
use app\models\MenuForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$ingredientList = ArrayHelper::map(Ingredient::find()->all(), 'id', 'name');
?>
<?php $form = ActiveForm::begin(); ?>
<h3>
    Choose ingredients to search for dishes
</h3>
<?= $form->field($model, 'ingredients')->checkboxList($ingredientList, ['itemOptions' => ['labelOptions' => ['class' => 'col-md-3']]]) ?>
<?= Html::submitButton('Search', ['class' => 'btn-search btn btn-primary']) ?>
<?php $form::end() ?>
<ul class="list-group mt-3">
    <?php if ($error) { ?>
        <li class="list-group-item">
            <?= $error ?>
        </li>
    <?php } else { ?>
        <?php foreach ($dishes as $dish) { ?>
            <li class="list-group-item">
                <?= $dish->name ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul>

