<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Location;
use app\models\Category;
use app\models\Supplier;

$this->title = 'Stock Index';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-index">
    <?php
    $locations = Location::find()->all(); 
    $categories = Category::find()->all(); 
    $suppliers = Supplier::find()->all(); 

    $form = ActiveForm::begin([
                'id' => 'searchstock-form',
                'method' => 'post',
                'action' => Url::to(['stock/index']),
                'options' => [
                    'class' => 'form form-search',
                ]
    ]);
    //echo $form->errorSummary($model);
    ?>
    <div class="container-fluid">          
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <p class="info">Search for a list of products by selecting in the drop down lists below the location, category and supplier for the products.</p> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-lg-4">
                <?=
                        $form->
                        field($model, 'location')->
                        dropdownList(array_merge(['0' => '--All--'], ArrayHelper::map($locations, 'ID', 'Name')), [
                                //  'options' => ['1' => ['selected' => true], ]
                        ])->label(true);
                ?>
                <?php
//                    foreach ($locationlist as $row) {
//                        <option value="//<?php echo $row["Location"]; >"><?php echo $row["Location"]; ></option>
                ?>
            </div>
            <div class="col-sm-4 col-lg-4">
                <?=
                Html::activeLabel($model, 'category', [
                        //            'for' => 'searchstock-category',
                        //            'class' => 'label label-default '
                ]);
                ?>
                <?=
                        $form->
                        field($model, 'category', ['enableLabel' => false])->
                        dropdownList(array_merge(['0' => '--All--'], ArrayHelper::map($categories, 'CategoryID', 'CategoryName')), [
                                //             'id' => 'searchstock-category',
                                //             'class' => 'form-control'
                ]);
                ?>
            </div>
            <div class="col-sm-4 col-lg-4">
                <?= Html::activeLabel($model, 'supplier'); ?>
                <?=
                        $form->
                        field($model, 'supplier', ['enableLabel' => false])->
                        dropdownList(array_merge(['0' => '--All--'], ArrayHelper::map($suppliers, 'SupplierID', 'SupplierName')));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-9">
                <?= Html::activeLabel($model, 'search'); ?>
                <?=
                $form->field($model, 'search')->textInput([
                    'autofocus' => true,
                ])->label(false);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-12 form-group">
                <p class="center">
                    <?=
                    Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary controls form-inline',
                        'name' => 'searchstock-form-button']);
                    ?>
                </p>
            </div>
        </div>
    </div>
    <input type="hidden" name="Page" value="1">
    <input type="hidden" name="pagesize" value="<?=$model->pagesize?>">
    <?php //echo Html::endForm();    ?>
    <?php
    ActiveForm::end();
    ?>

</div>

