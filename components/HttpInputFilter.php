<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;
use yii\base\ActionFilter;

class HttpInputFilter extends ActionFilter {

    private $filteredGetArray;
    private $filteredPostArray;

    public function filteredGet($name = null, $defaultValue = null) {
        if ($name === null) {
            return $this->filteredGetArray;
        } else {
            return $this->getFilteredParam($name, $defaultValue);
        }
    }

    public function filteredPost($name = null, $defaultValue = null) {
        if ($name === null) {
            return $this->filteredPostArray;
        } else {
            return $this->postFilteredParam($name, $defaultValue);
        }
    }

    public function getFilteredParam($name, $defaultValue = null) {
        $params = $this->filteredGetArray;
        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    public function postFilteredParam($name, $defaultValue = null) {
        $params = $this->filteredPostArray;
        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    public function beforeAction($action) {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $paramNames = array_keys($request->get());
            $this->filteredGetArray = $this->filter_request_string(INPUT_GET, $paramNames);
        }
        if ($request->isPost) {
            $paramNames = array_keys($request->post());
            $this->filteredPostArray = $this->filter_request_string(INPUT_POST, $paramNames);
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result) {
        return parent::afterAction($action, $result);
    }

    private function filter_request_string($type, $args) {
        $filterArgs = array();
        foreach ($args as $arg) {
            $filterArgs[$arg] = array(
                'filter' => FILTER_SANITIZE_STRING,
               // 'flags' => FILTER_REQUIRE_SCALAR
            );
        }
        return filter_input_array($type, $filterArgs);
    }

}
