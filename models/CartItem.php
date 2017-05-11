<?php

namespace app\models;

//use Yii;
use yii\base\Model;

/**
 *
 */
class CartItem extends Model {

    public $stockid;
    public $quantity;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['stockid', 'quantity'], 'required'],
            ['quantity', 'default', 'value' => 1],
            ['quantity', 'compare', 'compareValue' => 40, 'operator' => '<=', 'type' => 'number'],
        ];
    }

}
