<?php
namespace app\components;

use Yii;
use yii\base\ActionFilter;

class myFilter extends ActionFilter {

	private $_startTime;

	public function beforeAction($action)
	{
		echo 'i am before action';
		$this->_startTime = microtime(true);
		return parent::beforeAction($action);
	}

	public function afterAction($action, $result)
	{
		echo 'i am after action';
		$time = microtime(true) - $this->_startTime;
		Yii::trace("Action '{$action->uniqueId}' spent $time second.");
		return parent::afterAction($action, $result);
	}
}
