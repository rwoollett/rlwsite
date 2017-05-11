<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<?php
$cartitem = new \app\models\CartItem();
$cartitem->stockid = $model->StockID;
$listform = ActiveForm::begin([
            'id' => 'searchstocklist'.$cartitem->stockid,
            'enableAjaxValidation' => true,
            'method' => 'post',
            'action' => Url::to(['stock/cart-add']),
            'validationUrl' => Url::to(['stock/cart-add-validate']),
//            'options' => [
//                'class' => 'form form-searchlist',
//                'name' => 'searchlist',
//            ]
        ]);
?>

<div class = "stock">
    <div class="row">
        <div class="col-md-6">
            <div class="desc"><b><?= Html::encode($model->TradingName); ?>&nbsp;&mdash;&nbsp;<i><?= $model->StockID; ?> (SupplierName)</i></b></div>
            <?php
            if ($model->itemOptions['Cost'] != '') {
                ?>
                <div class="info">Cost: $<u><?= Html::encode($model->itemOptions['Cost']); ?></u></div>
                <div class="info">Options:
                    <select class="smallfieldvalue" name="<?php echo 'ID' . $model->StockID . '_optionlist'; ?>" size="1" 
                            onchange="changeOption(document.searchlist.ID<?php echo $model->StockID; ?>_option, this)">
                                <?php
                                $first = true;
                                foreach ($model->itemOptions["Options"] as $option) {
                                    ?>
                            <option value="<?php echo trim($option); ?>" <?php
                            if ($first) {
                                echo 'selected="selected"';
                                $first = false;
                            }
                            ?> ><?php echo trim($option); ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </div>

                <?php
            } else {
                ?>
                <div class="info">Options:
                    <select class="smallfieldvalue" name="<?php echo 'ID' . $model->StockID . '_optionlist'; ?>" size="1" 
                            onchange="changeOptionCost(document.searchlist.ID<?php echo $model->StockID; ?>_option, document.searchlist.ID<?php echo $model->StockID; ?>_cost, this)">
                                <?php
                                $first = true;
                                foreach ($model->itemOptions["Options"] as $option) {
                                    $arrFields = explode(",", trim($option));
                                    $strName = $arrFields [0];
                                    $strCost = sprintf("%01.2f", $arrFields [1]);
                                    ?>
                            <option value="<?php echo $option; ?>" <?php
                            if ($first) {
                                echo 'selected="selected"';
                                $first = false;
                            }
                            ?> ><?php echo $strName, ' - ', $strCost; ?></option>
                                    <?php
                                }
                                ?>

                    </select>
                </div>
                <?php
            }
            ?>			
        </div>
        <div class="col-md-4">
            <div class="info"><?= Html::encode($model->Description); ?></div>
            <div class="smallnote">
                <a href="moreinfo/StockID=StockID&Action=init">more info ...</a>
            </div>
        </div>
        <div class="col-md-2">
            <div class="smallnote">
                <div><b>Quantity</b>
                    <input name="<?php echo 'ID' . $model->StockID . '_id'; ?>" type="hidden" value="<?= $model->StockID; ?>">
                    <input name="<?php echo 'ID' . $model->StockID . '_name'; ?>" type="hidden" value="<?= Html::encode($model->TradingName); ?>">
                    <input name="<?php echo 'ID' . $model->StockID . '_option'; ?>" type="hidden" value="<?= Html::encode($model->OptionAndCost["Option"]); ?>">
                    <input name="<?php echo 'ID' . $model->StockID . '_cost'; ?>" type="hidden" value="<?= Html::encode($model->OptionAndCost["Cost"]); ?>">
                </div>
                <div>
                    <!--<input type="value" name="?php echo 'ID' . $model->StockID . '_quantity'; ?>" value="1" size="2">
                    -->
                    <?php
                    echo $listform->field($cartitem, 'quantity', ['options' => [
                            'name' => 'ID' . $model->StockID . '_quantity', ]])->textInput([
                        'autocomplete' => "off"
                            //   'autofocus' => true,
                    ])->label(false);

                    echo $listform->field($cartitem, 'stockid', ['options' => [
                            'name' => 'ID' . $model->StockID . '_id',
                ]])->hiddenInput([
                            //   'autofocus' => true,
                    ])->label(false);
                    ?>
                </div>
                <div>
                    <input name="<?php echo 'ID' . $model->StockID; ?>" type="submit" value="Buy">
                </div>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-md-12">
            <hr class="line"></hr>
        </div>
    </div>

</div>
<?php
ActiveForm::end();
?>
