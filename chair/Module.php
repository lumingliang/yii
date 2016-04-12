<?php

namespace app\admin;


class Module extends \yii\base\Module {
	public function init() {
		parent::init();
        // 先获取role
        $session = Yii::$app->session;
        // role 必须已经在登录时完成
        if( !$session['role'] ) {

            throw new \yii\web\HttpException(403);
        }

        // 检查role是否一致
        if($session['role'] == $this->id ) {
            return;
        } else {
            echo 'asses deny!';
            exit;
        }

        // echo $this->id;
        // exit;
        //if( Yii::$app->user->identity->role_class ==  )
		//$this->params['foo' = 'bar'; //貌似有了下面的配置会覆盖这个配置
		//\Yii::configure($this, require(__DIR__.'/config.php'));

	}
}


