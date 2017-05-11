<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use app\models\Location;
use app\models\Category;
use app\models\Supplier;
use app\models\Stock;

class SearchStockForm extends Model {

    public $location;
    public $category;
    public $supplier;
    public $search;
    public $pagesize;
    public $product;

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
            'product' => 'Product',
        ];
    }

    public function rules() {
        return [
            [['location', 'category', 'supplier'], 'required'],
            [['search'], 'default', 'value' => ''],
            [['product'], 'default', 'value' => 0],
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
            return ""; //-- All --";
        } else {
            $item = Supplier::findOne($this->supplier);
            if ($item) {
                return "Supplier: " . $item->SupplierName;
            } else {
                return "Supplier: " . $this->supplier;
            }
        }
    }

    /*
     * Use this model valid data to make the stock search and the Product
     * Name and counts. For the views to iterate over an array is returned. 
     * Create links now for the views
     */

    public function getProductLinks() {
        $productlinks = array();
        $totalCount = 0;
        $query = new Query();
        $query->select(['Pr.ProductID', 'Pr.ProductName', 'count(St.StockID) As StockCount'])
                ->from('istock.stock St')
                ->join('LEFT JOIN', 'istock.product Pr', 'Pr.ProductID = St.ProductID')
                ->join('LEFT JOIN', 'istock.supplier Su', 'Su.SupplierID = St.SupplierID');
        $this->searchCondition($query, true);
        $query->groupBy("Pr.ProductName");
        $query->orderBy("Pr.ProductName");
        $result = $query->all();
        
        $params = $this->getAttributes(["location", "category", "supplier", "search", "pagesize"]);
        foreach ($result as $productitem) {
            $urllink = Url::to(array_merge(["stock/search", 'product' => $productitem["ProductID"]], $params));
            $productlinks[] = array(
                "Link" => $urllink,
                "LinkText" => htmlspecialchars($productitem["ProductName"]) . " (" . $productitem["StockCount"] . ')'
            );
            $totalCount = $totalCount + $productitem["StockCount"];
        }
        // Add the All products link
        $urllink = Url::to(array_merge(["stock/search", 'product' => '0'], $params));
        $productlinks[] = array(
            "Link" => $urllink,
            "LinkText" => 'All Product (' . $totalCount . ')'
        );
        return $productlinks;
    }

    public function getDataProvider() {
        $query = Stock::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pagesize, 
            ]
        ]);

        // load the search form data and validate
        if (!($this->validate())) {
            return $dataProvider;
        }

        $query->select(['St.StockID', 'St.SupplierID', 'St.CostType', 'St.StockCost',
            'St.Options', 'St.Description',
            'St.ProductID', 'St.TradingName', 'Su.LocationID', 'Su.SupplierName', 'Pr.ProductName'])
                ->from('istock.stock St')
                ->join('LEFT JOIN', 'istock.product Pr', 'Pr.ProductID = St.ProductID')
                ->join('LEFT JOIN', 'istock.supplier Su', 'Su.SupplierID = St.SupplierID');
        $this->searchCondition($query, false); 
        $query->orderBy("St.TradingName ASC, Su.SupplierName ASC");
//                'OptionAndCost' => $current->St->getOptionAndCost(),
//                'Options' => $current->St->getItemOptions(),
        return $dataProvider;
    }

    private function searchCondition($query, $allProduct) {
        $andNeeded = false;
        if ($this->location != 0) {
            $query->where('Su.LocationID = :location')
                    ->addParams([':location' => $this->location]);
            $andNeeded = true;
        }
        if ($this->category != 0) {
            $where = 'Pr.CategoryID = :category';
            $params = [':category' => $this->category];
            if ($andNeeded) {
                $query->andWhere($where);
            } else {
                $query->where($where);
            }
            $query->addParams($params);
            $andNeeded = true;
        }
        if ($this->supplier != 0) {
            $where = 'Su.SupplierID = :supplier';
            $params = [':supplier' => $this->supplier];
            if ($andNeeded) {
                $query->andWhere($where);
            } else {
                $query->where($where);
            }
            $query->addParams($params);
            $andNeeded = true;
        }
        if (!$allProduct && $this->product != 0) {
            $where = 'St.ProductID = :product';
            $params = [':product' => $this->product];
            if ($andNeeded) {
                $query->andWhere($where);
            } else {
                $query->where($where);
            }
            $query->addParams($params);
            $andNeeded = true;
        }
        if ($this->search != '') {
            $where = 'St.TradingName like :search';
            $params = [':search' => '%' . Html::encode($this->search) . '%'];
            if ($andNeeded) {
                $query->andWhere($where);
            } else {
                $query->where($where);
            }
            $query->addParams($params);
            $andNeeded = true;
        }
        $where = 'St.Purged IS NULL';
        if ($andNeeded) {
            $query->andWhere($where);
        } else {
            $query->where($where);
        }
    }
}
