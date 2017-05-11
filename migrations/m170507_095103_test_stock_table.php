<?php

use yii\db\Migration;

class m170507_095103_test_stock_table extends Migration {

    public function up() {
        /* @property integer $StockID
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
         * */

        $this->batchInsert("stock", ["StockCode", "TradingName", "Description", "ProductID",
            "StockCost", "Options"], [
            ["Stock1", "Stock1 Trade name", "Description details...", 2, 4.50, "One\nTwo\nThree"],
            ["Stock2", "Stock2 Trade name", "Description details...", 2, 4.50, "One\nTwo\nThree"],
            ["Stock3", "Stock3 Trade name", "Description details...", 2, 4.50, "One\nTwo\nThree"],
            ["Stock4", "Stock4 Trade name", "Description details...", 2, 4.50, "One\nTwo\nThree"],
            ["Stock5", "Stock5 Trade name", "Description details...", 2, 4.50, "One\nTwo\nThree"],
            ["Stock6", "Stock6 Trade name", "Description details...", 1, 4.50, "One\nTwo\nThree"],
            ["Stock7", "Stock7 Trade name", "Description details...", 1, 4.50, "One\nTwo\nThree"],
            ["Stock8", "Stock8 Trade name", "Description details...", 1, 4.50, "One\nTwo\nThree"],
            ["Stock9", "Stock9 Trade name", "Description details...", 1, 4.50, "One\nTwo\nThree"],
            ["Stock10", "Stock10 Trade name", "Description details...", 3, 4.50, "One\nTwo\nThree"],
            ["Stock11", "Stock11 Trade name", "Description details...", 3, 4.50, "One\nTwo\nThree"],
        ]);
    }

    public function down() {
        $this->delete("stock");
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
