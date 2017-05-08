<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Location;
use app\models\Category;
use app\models\Supplier;

class SearchStockForm extends Model {

    public $location;
    public $category;
    public $supplier;
    public $search;
    public $pagesize;

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'location' => 'Location',
            'category' => 'Category',
            'supplier' => 'Supplier',
            'search' => 'Search (Leave blank for all)',
            'pagesize' => 'Page Size',
        ];
    }

    public function rules() {
        return [
            //required
            [['location', 'category', 'supplier'], 'required'],
            // search can be emptry
            [['search'], 'default', 'value' => ''],
            //[['search'], 'string', 'length' => [0,40]]
            [['pagesize'], 'default', 'value' => 5],
            [['pagesize'], 'in', 'range' => [5, 10, 15, 20, 25, 30]],
        ];
    }

    public function getLocationName() {
        if ($this->location == 0) {
            return "-- All --";
        } else {
            $item = Location::findOne($this->location);
            if ($item) {
                return $item->Name;
            } else {
                return $this->location;
            }
        }
    }

    public function getCategoryName() {
        if ($this->category == 0) {
            return "-- All --";
        } else {
            $item = Category::findOne($this->category);
            if ($item) {
                return $item->CategoryName;
            } else {
                return $this->category;
            }
        }
    }

    public function getSupplierName() {
        if ($this->supplier == 0) {
            return "";//-- All --";
        } else {
            $item = Supplier::findOne($this->supplier);
            if ($item) {
                return "Supplier: ".$item->SupplierName;
            } else {
                return "Supplier: ".$this->supplier;
            }
        }
    }

}
