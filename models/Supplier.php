<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $SupplierID
 * @property string $SupplierName
 * @property string $Email
 * @property string $Hash
 * @property string $Member
 * @property string $MembershipDate
 * @property integer $LocationID
 * @property string $Address1
 * @property string $Address2
 * @property string $Picture
 * @property integer $Width
 * @property integer $Height
 * @property string $MoreInfo
 * @property string $TaxName
 * @property string $TaxRate
 * @property integer $TaxInclude
 * @property integer $AddFreight
 * @property string $FreightCost
 * @property integer $OrdersOther
 * @property integer $TopStock
 * @property integer $NumberTop
 * @property integer $OnlyOurs
 *
 * @property Stock[] $stocks
 * @property Location $location
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MembershipDate'], 'safe'],
            [['LocationID', 'Width', 'Height', 'TaxInclude', 'AddFreight', 'OrdersOther', 'TopStock', 'NumberTop', 'OnlyOurs'], 'integer'],
            [['TaxRate', 'FreightCost'], 'number'],
            [['SupplierName', 'Picture', 'MoreInfo', 'TaxName'], 'string', 'max' => 40],
            [['Email', 'Hash', 'Address1', 'Address2'], 'string', 'max' => 255],
            [['Member'], 'string', 'max' => 20],
            [['LocationID'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['LocationID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SupplierID' => 'Supplier ID',
            'SupplierName' => 'Supplier Name',
            'Email' => 'Email',
            'Hash' => 'Hash',
            'Member' => 'Member',
            'MembershipDate' => 'Membership Date',
            'LocationID' => 'Location ID',
            'Address1' => 'Address1',
            'Address2' => 'Address2',
            'Picture' => 'Picture',
            'Width' => 'Width',
            'Height' => 'Height',
            'MoreInfo' => 'More Info',
            'TaxName' => 'Tax Name',
            'TaxRate' => 'Tax Rate',
            'TaxInclude' => 'Tax Include',
            'AddFreight' => 'Add Freight',
            'FreightCost' => 'Freight Cost',
            'OrdersOther' => 'Orders Other',
            'TopStock' => 'Top Stock',
            'NumberTop' => 'Number Top',
            'OnlyOurs' => 'Only Ours',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['SupplierID' => 'SupplierID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['ID' => 'LocationID']);
    }
}
