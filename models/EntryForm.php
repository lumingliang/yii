<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Entryform extends model {
	public $name;
	public $email;
    public $verifyCode;
    public $rememberMe;

	public function rules() {
		return [
			[ ['name', 'email'], 'required' ], // 如果是多个项目同时拥有验证器，就用双重数组
			['email', 'email'],
            ['verifyCode', 'captcha'],
		];
	}
}
