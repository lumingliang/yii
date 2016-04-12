<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '邮箱验证';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4> <?= Yii::$app->session['newUser']['model']['name'] ?> 欢迎您注册我们的网站！<a href=<?= Url::toRoute(['/admin/auth/register-email-check/', 'code' => Yii::$app->session['newUser']['code']], 'http'); ?> > 点击这里激活邮箱 </a> </h4>
