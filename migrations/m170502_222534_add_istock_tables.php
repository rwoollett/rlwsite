<?php

use yii\db\Schema;
use yii\db\Migration;

class m170502_222534_add_istock_tables extends Migration {

    public function safeUp() {
        $this->createTable("stock", [
            "StockID" => Schema::TYPE_PK,
            "StockCode" => "VARCHAR(20) NOT NULL default ''",
            "CostType" => "VARCHAR(10) NOT NULL default 'OneCost'",
            "ProductID" => Schema::TYPE_INTEGER,
            "SupplierID" => Schema::TYPE_INTEGER,
            "TradingName" => "VARCHAR(40) NOT NULL default ''",
            "StockCost" => Schema::TYPE_MONEY,
            "Options" => Schema::TYPE_TEXT,
            "Picture" => "VARCHAR(40) default NULL",
            "Width" => Schema::TYPE_SMALLINT,
            "Height" => Schema::TYPE_SMALLINT,
            "Description" => Schema::TYPE_TEXT,
            "Purged" => Schema::TYPE_BOOLEAN,
            "NumberOrders" => Schema::TYPE_INTEGER,
            "NumberOrdersOther" => Schema::TYPE_INTEGER,
        ]);
        $this->createTable("category", [
            "CategoryID" => Schema::TYPE_PK,
            "CategoryName" => "VARCHAR(40) NOT NULL default ''",
        ]);

        $this->createTable("product", [
            "ProductID" => Schema::TYPE_PK,
            "ProductName" => "VARCHAR(40) NULL default ''",
            "CategoryID" => Schema::TYPE_INTEGER,
        ]);

        $this->createIndex("category_ind", "product", "CategoryID");
        $this->addForeignKey("product_ibfk_1", "product", "CategoryID", "category", "CategoryID", 'RESTRICT', 'RESTRICT');

        $this->createIndex("product_ind", "stock", "ProductID");
        $this->addForeignKey("stock_ipfk_1", "stock", "ProductID", "product", "ProductID", 'RESTRICT', 'RESTRICT');

        // Test data -- Categories
        $this->batchInsert("category", ["CategoryName"], [
            ['Books for the Artist'],
            ['Music Instruments'],
        ]);
        // Test data -- Categories
        $this->batchInsert("product", ["ProductName", "CategoryID"], [
            ['WritBooks', 1],
            ['MusicXmags', 1],
            ['ABCFSounds', 2],
        ]);
    }

    public function safeDown() {
        $this->dropTable("stock");
        $this->dropTable("product");
        $this->dropTable("category");
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
