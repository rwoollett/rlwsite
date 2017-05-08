<?php
/* @var $this yii\web\View */

use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Stock Search';
$this->params['breadcrumbs'][] = ['label' => 'Stock Index', 'url' => ['stock/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-search">
    <?php
//    var_dump($model);
    $form = ActiveForm::begin([
                'id' => 'searchstocklist-form',
                'method' => 'post',
                'action' => Url::to(['stock/search']),
                'options' => [
                    'class' => 'form form-searchlist',
                    'name' => 'searchform',
                ]
    ]);
    ?>
    <div class="container-fluid">          
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <p class="title center">Browse&nbsp;Products</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-lg-4">
                <p class="info">Location: <u><b><?=$model->locationName; ?></b></u>
            </div>
            <div class="col-sm-4 col-lg-4">
                <p class="info">Category: <u><b><?=$model->categoryName; ?></b></u>
            </div>
            <div class="col-sm-4 col-lg-4">
                <p class="info"><u><b><?=$model->supplierName; ?></b></u>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <p>Select a product type with one of the following links below.</p>
                <p>
                    <?php
                    $totalCount = 0;
//            foreach ($productlinks as $link) {
//                <a href="//<?php echo $url->get("stock/search") . "/?" . $link["Link"] . "&Page=1&PageSize=$pagesize"; >"><?php
//                    echo $link["LinkText"];
//                    ></a>&nbsp;|&nbsp;
                    ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7 col-sm-8  col-md-9 col-lg-10">
                <?= Html::activeLabel($model, 'search'); ?>
                <?=
                $form->field($model, 'search')->textInput([
                    'autofocus' => true,
                ])->label(false);
                ?>
            </div>
            <div class="small col-xs-5 col-sm-4 col-md-3 col-lg-2">
                <?= Html::activeLabel($model, 'pagesize'); ?>
                <?=
                        $form->
                        field($model, 'pagesize')->
                        dropdownList([5 => '5', 10 => '10', 15 => '15', 20 => '20', 25 => '25', 30 => '30'], [
                            'onchange' => "changePageSize()",
                        ])->label(false);
                ?>
                <?php // ?>
                <script type="text/javascript">
                    function changePageSize() {
                        document.searchform.submit();
                    }
                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-12 form-group">
                <p class="center">
                    <?=
                    Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary controls form-inline',
                        'name' => 'searchstocklist-form-button']);
                    ?>
                    <a href="<?php echo Url::to(["stock/more-info", "stockid" => 1]); ?>/?Action=View" class="btn btn-sm btn-primary">Basket</a>
                </p>
            </div>
        </div>
    </div>
    <input type="hidden" name="SearchStockForm[location]" value="<?= $model->location; ?>">
    <input type="hidden" name="SearchStockForm[category]" value="<?= $model->category; ?>">
    <input type="hidden" name="SearchStockForm[supplier]" value="<?= $model->supplier; ?>">
    <?php
    ActiveForm::end();
    ?>
</div>

<div id="List" class="container-fluid form-searchlist">
    <form class="form-list" name="searchlist" action="<?php echo Url::to(["stock/cart", "stockid" => 1]) . "/cart&Action=View"; ?>" method="post">
    </form>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{pager}{summary}',
    ]);
    ?>
    <div class="row">
        <div class="col-md-12">
            <hr class="line"></hr>
        </div>
    </div>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_stock',
        'layout' => '{items}{pager}',
    ]);
    ?>
</div>


