<?php

use yii\helpers\Html;
//use yii\helpers\HtmlPurifier;
?>
<div class = "stock">
    <div class="row">
        <div class="col-md-6">
            <div class="desc"><b><?= Html::encode($model->TradingName); ?>&nbsp;&mdash;&nbsp;<i><?= $model->StockID; ?> (SupplierName)</i></b></div>
            <?php
            //$search['Options']['Cost'] !== ''
            if ($model->StockCode != '') {
                ?>
                <div class="info">Cost: $<u>Options][Cost</u></div>
                <div class="info">Options:
                    <select class="smallfieldvalue" name="<?php echo 'ID' . $model->StockID . '_optionlist'; ?>" size="1" 
                            onchange="changeOption(document.searchlist.ID<?php echo $model->StockID; ?>_option, this)">
                                <?php
                                //$first = true;
                                //foreach ($search["Options"]["Options"] as $option) {
                                ?>
                        <option value="option" <?php
                        //if ($first) {
                        //   echo 'selected="selected"';
                        //  $first = false;
                        //}
                        ?> >trim($option)</option>
                                <?php
                                //}
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
//                                        $first = true;
//                                        foreach ($search["Options"]["Options"] as $option) {
//                                            $arrFields = explode(",", trim($option));
//                                            $strName = $arrFields [0];
//                                            $strCost = sprintf("%01.2f", $arrFields [1]);
                                ?>
                        <option value="option" <?php
//                                    if ($first) {
//                                        echo 'selected="selected"';
//                                        $first = false;
//                                    }
                        ?> >strName - strCost</option>
                                <?php
                                //}
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
                <div><b>Quantity</b><input name="<?php echo 'ID' . $model->StockID . '_id'; ?>" type="hidden" value="<?<?= $model->StockID; ?> ?>">
                    <input name="<?php echo 'ID' . $model->StockID . '_name'; ?>" type="hidden" value="<?= Html::encode($model->TradingName); ?>">
                    <input name="<?php echo 'ID' . $model->StockID . '_option'; ?>" type="hidden" value=OptionAndCost][Option">
                    <input name="<?php echo 'ID' . $model->StockID . '_cost'; ?>" type="hidden" value="OptionAndCost][Cost">
                </div>
                <div>
                    <input type="value" name="<?php echo 'ID' . $model->StockID . '_quantity'; ?>" value="1" size="2">
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