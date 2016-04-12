<?php

namespace app\admin;


class Module extends \yii\base\Module {
	public function init() {
		parent::init();
        // echo $this->id;
        // exit;
        //if( Yii::$app->user->identity->role_class ==  )
		//$this->params['foo'] = 'bar'; //貌似有了下面的配置会覆盖这个配置
		//\Yii::configure($this, require(__DIR__.'/config.php'));

	}
    // 原来filters应该这样写，下次看到东西时，一定要认真阅读文档，因为它明确说明了怎么用，而且在仿用时一定要看清方法
    public function behaviors() // 运行时开始，逐个历遍，并应用
    {
        return [
            'myFilter' => [
                'class' => 'app\components\myFilter',
            ],
        ];
    }
}


