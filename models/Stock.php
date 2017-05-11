<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property integer $StockID
 * @property string $StockCode
 * @property string $CostType
 * @property integer $ProductID
 * @property integer $SupplierID
 * @property string $TradingName
 * @property string $StockCost
 * @property string $Options
 * @property string $Picture
 * @property integer $Width
 * @property integer $Height
 * @property string $Description
 * @property integer $Purged
 * @property integer $NumberOrders
 * @property integer $NumberOrdersOther
 */
class Stock extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'stock';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ProductID', 'SupplierID', 'Width', 'Height', 'Purged', 'NumberOrders', 'NumberOrdersOther'], 'integer'],
            [['StockCost'], 'number'],
            [['Options', 'Description'], 'string'],
            [['StockCode'], 'string', 'max' => 20],
            [['CostType'], 'string', 'max' => 10],
            [['TradingName', 'Picture'], 'string', 'max' => 40],
            [['ProductID'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['ProductID' => 'ProductID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'StockID' => 'Stock ID',
            'StockCode' => 'Stock Code',
            'CostType' => 'Cost Type',
            'ProductID' => 'Product ID',
            'SupplierID' => 'Supplier ID',
            'TradingName' => 'Trading Name',
            'StockCost' => 'Stock Cost',
            'Options' => 'Options',
            'Picture' => 'Picture',
            'Width' => 'Width',
            'Height' => 'Height',
            'Description' => 'Description',
            'Purged' => 'Purged',
            'NumberOrders' => 'Number Orders',
            'NumberOrdersOther' => 'Number Orders Other',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['ProductID' => 'ProductID']);
    }

    public function getOptionAndCost() {
        //$arrRow ['CostType'], $arrRow ['StockCost'], $arrRow ['Options']
        $strSelectedCost = '';
        $strSelectedOption = '';
        if ($this->Options != '') {
            $arrOptions = explode("\n", preg_replace("'(\r)?\n'", "\n", $this->Options));
            if ($this->CostType == 'OneCost') {
                $strSelectedCost = sprintf("%01.2f", $this->StockCost);
                $strSelectedOption = $arrOptions[0];
            }
            if ($this->CostType == 'SelectCost') {
                $arrFields = explode(",", trim($arrOptions[0]));
                $strSelectedOption = $arrFields [0];
                $strSelectedCost = sprintf("%01.2f", $arrFields [1]);
            }
        }
        return array(
            'Cost' => $strSelectedCost,
            'Option' => $strSelectedOption
        );
    }

    public function getItemOptions() {
        $stockCost = '';
        $options = array();
        if ($this->Options != '') {
            if ($this->CostType == 'OneCost') {
                $stockCost = sprintf("%01.2f", $this->StockCost);
                $options = explode("\n", preg_replace("'(\r)?\n'", "\n", $this->Options));
            }
            if ($this->CostType == 'SelectCost') {
                $options = explode("\n", preg_replace("'(\r)?\n'", "\n", $this->Options));
            }
            // One Cost, or Select Cost - Both have a list of options
            // SelectCost will have no Cost value, as cost is part of the options
        }
        return array(
            'Cost' => $stockCost,
            'Options' => $options
        );
    }

}
