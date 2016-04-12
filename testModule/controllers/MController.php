<?php
namespace app\testModule\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;

class MController extends Controller {
	public $layout = 'mai';

	public function actionM() {
		//echo 'this is the test for a module!';
		$this->render('index');
		// $module = \Yii::$app->controller->module;
		// var_dump($module->params);
	}

	// public function behaviors() {
		// return [
			// [
				// 'class' => 'app\components\myFilter',
				// // some config for this filter
			// ],
			// 'verbs' => [
				// 'class' => VerbFilter::className(),
				// 'actions' => [
					// 'm' => ['get'], //这里可以限定请求时post,默认都是get
				// ],
			// ],
		// ];
	// }
}
