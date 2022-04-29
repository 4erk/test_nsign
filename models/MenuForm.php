<?php

namespace app\models;

use yii\base\Model;

class MenuForm extends Model
{
    public $ingredients = [];

    public function rules()
    {
        return [
            [['ingredients'], 'each', 'rule' => ['integer']],
        ];
    }
}