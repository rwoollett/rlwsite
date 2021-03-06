<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Cookie;
use app\models\SearchStockForm;
use app\models\CartItem;
use yii\widgets\ActiveForm;
use yii\web\Response;

/*
 * The Controllers should −
  Be very thin. Each action should contain only a few lines of code.
  Use Views for responses.
  Not embed HTML.
  Access the request data.
  Call methods of models.
  Not process the request data. These should be processed in the model.
 */

class StockController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'more-info' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $mSearchStock = new SearchStockForm();
        $session = Yii::$app->session;
        if ($session->has("search.stock")) {
            $mSearchStock->setAttributes($session["search.stock"]);
        } else {
            $cookies = Yii::$app->request->cookies;
            if ($cookies->has('searchstock')) {
                $mSearchStock->setAttributes(json_decode($cookies["searchstock"]->value, true));
            }
        }
        if (Yii::$app->request->isPost) {
            // Do read new values from the form (overwrite any session values retrieval) and re-validate
            if ($mSearchStock->load(Yii::$app->request->post()) && $mSearchStock->validate()) {
                // valid data received in $mSearchStock
                $params = $mSearchStock->getAttributes(["location", "category", "supplier", "search", "pagesize"]);
                return $this->redirect(array_merge(["stock/search"], $params));
            }
        }
        // either the page is initially displayed or there is some validation error
        return $this->render('index', [
                    'model' => $mSearchStock,
        ]);
    }

    public function actionSearch() {
        $mSearchStock = new SearchStockForm();
        if (Yii::$app->request->isPost) {
            // Can post this action when changing a search or page size
            $session = Yii::$app->session;
            if ($session->has("search.stock")) {
                $mSearchStock->setAttributes($session["search.stock"]);
            }
            if ($mSearchStock->load(Yii::$app->request->post()) && $mSearchStock->validate()) {
                // valid data received in $mSearchStock now redeirect to complete this post
                $params = $mSearchStock->getAttributes(["location", "category", "supplier", "search", "product", "pagesize"]);
                return $this->redirect(array_merge(["stock/search"], $params));
            }
        } else {
            // Want a get url with params made here - why a redirect is made to build the parama on url
            $location = Yii::$app->request->get('location');
            $category = Yii::$app->request->get('category');
            $supplier = Yii::$app->request->get('supplier');
            $search = Yii::$app->request->get('search');
            $product = Yii::$app->request->get('product');
            $pagesize = Yii::$app->request->get('pagesize');
            $data = compact('location', 'category', 'supplier', 'search', 'product', 'pagesize');
            $mSearchStock->setAttributes($data);
            if ($mSearchStock->validate()) {
                Yii::$app->session["search.stock"] = $data;
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'searchstock',
                    'value' => json_encode($data),
                    'expire' => time() + 86400 * 365]));

                return $this->render('search', [
                            'model' => $mSearchStock,
                ]);
            }
        }
        // the page is has some validation error with url get 
        // information, now goto to index
        return $this->render('index', [
                    'model' => $mSearchStock,
        ]);
    }

    public function actionCartAddValidate() {
        $model = new CartItem();
        $request = Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = $model->getAttributes(["stockid", "quantity"]);
            return ActiveForm::validate($model);
        }
    }

    public function actionCartAdd() {
        $model = new CartItem();
        $request = Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = $model->getAttributes(["stockid", "quantity"]);
            return ['success' => true];
        }

        $message = "Cart Add ";
        $backlink = ((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : Url::to(['stock/index'])));
        return $this->renderAjax('feedback', [
                    'message' => $message,
                    'backlink' => $backlink
        ]);
//        return $this->renderAjax('registration', [
//                    'model' => $model,
//        ]);
    }

    public function actionMoreInfo() {
        //$stockid = $this->filteredGet('stockid');
        $stockid = Yii::$app->request->get('stockid');

        $stockIdCount = Stock::find()
                ->where(["StockID" => $stockid])
                ->count();

        if ($stockIdCount == 0) {
            // If no found stock show feedback page then offer a link to the 
            // referred page to this action beforehand
            $backlink = ((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : Url::to(['stock/index'])));
            $message = "No stock items";
            return $this->render('feedback', [
                        'message' => $message,
                        'backlink' => $backlink
            ]);
        }
        $stockitem = Stock::find()
                ->where(["StockID" => $stockid])
                ->one();
        return $this->render('more-info', [
                    'stock' => $stockitem
        ]);
    }

//    public function actionFeedback() {
//        //$message = "param found stockid no stock items";
//        return $this->render('feedback', [
//                    'message' => $message,
//        ]);
//    }
}
