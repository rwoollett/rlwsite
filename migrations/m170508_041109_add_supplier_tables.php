<?php

use yii\db\Schema;
use yii\db\Migration;

class m170508_041109_add_supplier_tables extends Migration {

    public function safeUp() {

        $this->createTable("supplier", [
            "SupplierID" => Schema::TYPE_PK,
            "SupplierName" => "VARCHAR(40) NULL default ''",
            "Email" => Schema::TYPE_STRING,
            "Hash" => Schema::TYPE_STRING,
            "Member" => "VARCHAR(20) NOT NULL default 'Member'",
            "MembershipDate" => Schema::TYPE_DATETIME,
            "LocationID" => Schema::TYPE_INTEGER,
            "Address1" => Schema::TYPE_STRING,
            "Address2" => Schema::TYPE_STRING,
            "Picture" => "VARCHAR(40) default NULL",
            "Width" => Schema::TYPE_SMALLINT,
            "Height" => Schema::TYPE_SMALLINT,
            "MoreInfo" => "VARCHAR(40) default NULL",
            "TaxName" => "VARCHAR(40) default NULL",
            "TaxRate" => Schema::TYPE_DECIMAL,
            "TaxInclude" => Schema::TYPE_BOOLEAN,
            "AddFreight" => Schema::TYPE_BOOLEAN,
            "FreightCost" => Schema::TYPE_MONEY,
            "OrdersOther" => Schema::TYPE_BOOLEAN,
            "TopStock" => Schema::TYPE_BOOLEAN,
            "NumberTop" => Schema::TYPE_INTEGER,
            "OnlyOurs" => Schema::TYPE_BOOLEAN,
        ]);

        $this->createIndex("supplier_ind", "stock", "SupplierID");
        $this->addForeignKey("stock_isfk_1", "stock", "SupplierID", "supplier", "SupplierID", 'RESTRICT', 'RESTRICT');

        $this->createTable("location", [
            "ID" => Schema::TYPE_PK,
            "Name" => "VARCHAR(40) NULL default ''",
        ]);

        $this->createIndex("location_ind", "supplier", "LocationID");
        $this->addForeignKey("supplier_ilfk_1", "supplier", "LocationID", "location", "ID", 'RESTRICT', 'RESTRICT');

        // Test data -- Locations
        $this->batchInsert("location", ["Name"], [
            ['Marlborough'],
            ['Nelson'],
            ['Christchurch'],
            ['Greymouth'],
        ]);
        
        $this->batchInsert("supplier", ["SupplierName","LocationID", "Member"], [
            ['RLW Holdings', 1, "Member"],
            ['Substance Holdings', 1, "Memeber"],
            ['Ambieran Ltd.', 2, "Member"],
        ]);
        
        $this->update("stock", ["SupplierID" => 1]);
        
        /*
         * CREATE TABLE `banners` (
          `BannerID` INTEGER NOT NULL CONSTRAINT [PK_Banner] PRIMARY KEY ASC AUTOINCREMENT,
          `Name` char(40) NOT NULL default '',
          `SupplierID` int(10) NOT NULL default '0',
          `StockID` int(10) NOT NULL default '0',
          `SourceRemote` TEXT NOT NULL default 'off',
          `SourceUpload` TEXT NOT NULL default 'off',
          `SourceFile` char(100) NOT NULL default '0',
          `Width` smallint(3) default NULL,
          `Height` smallint(3) default NULL,
          `Keywords` char(100) default NULL,
          `Activate` TEXT default NULL,
          `Expire` TEXT default NULL,
          `ImpCnt` mediumint(8) default NULL,
          `HitCnt` mediumint(8) default NULL
          )
         * CREATE TABLE paymentplan (  
          Plan varchar(10) NOT NULL default NULL,
          Description varchar(50) NOT NULL default NULL,
          `PlanCost` decimal(10,2) NOT NULL default '0.00',
          CONSTRAINT [PK_PaymentPlan] PRIMARY KEY  (Plan ASC)
          )
         * CREATE TABLE `stockhistory` (
          `StockID` INTEGER NOT NULL default '0',
          `OtherStockID`INTEGER NOT NULL default '0',
          `SupplierID` INTEGER NOT NULL default '0',
          `OtherSupplierID`INTEGER NOT NULL default '0',
          `NumberOrders` mediumint(8) NOT NULL default '0',
          CONSTRAINT [PK_StockHistory] PRIMARY KEY (StockID ASC, OtherStockID ASC )
          )
         */
    }

    public function safeDown() {

        $this->update("stock", ["SupplierID" => '']);

        $this->dropForeignKey("stock_isfk_1", "stock");
        $this->dropIndex("supplier_ind", "stock");
        $this->dropTable("supplier");

        $this->dropTable("location");
}

}
