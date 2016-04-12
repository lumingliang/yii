<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\admin\models\User;
use yii\helpers\Url;

class TestAabController extends Controller {
	public function actionTestGo() {

		echo 'i am the test of an action';
	}

    public function actionRd() {

        // 测试重定向
        //return $this->redirect('http://example.com/new', 301);
        return $this->redirect('jjj/kkk', 301);
    }

    public function actionP() {

        $password = Yii::$app->getSecurity()->generatePasswordHash('1');
        $flag = Yii::$app->getSecurity()->validatePassword('1', $password);
        echo $flag;
         
    }

    // test for the active record relations
    public function actionRe() {

        // test one to many
        $model = new User();
        $user = $model::findOne(39);
        $role = $user->role;
        var_dump($role->name);

    }

    // test get role and redirect
    public function actionRo() {

        $role = ['name' => 'user']; 
        $url = Url::to(['/'.$role['name'].'/index']);
        return $this->redirect($url);
    }
}
