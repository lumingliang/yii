<?php

namespace app\testModule;


class Module extends \yii\base\Module {
	public function init() {
		parent::init();
		//$this->params['foo'] = 'bar'; //貌似有了下面的配置会覆盖这个配置
		\Yii::configure($this, require(__DIR__.'/config.php'));

	}
}
