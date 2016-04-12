<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if(Yii::$app->session->hasFlash('createNewUserSuccess')): ?>

<?php
$this->title = '激活成功!';
$this->params['breadcrumbs'][0] = $this->title;
?>

<p> 您的账户已经激活！请登录! </p>

<?php endif; ?>

<div class="row">
    <div class="col-lg-5">

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => '/site/captcha',
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<p>还没有账号？ <?= Html::a('注册一个', ['register']) ?> </p>

    </div>
</div>
