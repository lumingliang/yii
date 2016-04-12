<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = '注册新用户';
$this->params['breadcrumbs'][0] = $this->title;
?>
    <?php if (Yii::$app->session->hasFlash('registerEmailHadSend')): ?>

    <?php 
    $this->title = '验证邮箱发送成功！';
    $this->params['breadcrumbs'][0] = $this->title;
    ?>


    <p> 验证码已经发送到您的邮箱，请前往激活！</p>

    <?php elseif (Yii::$app->session->hasFlash('registerEmailSendError')): ?>

    <?php 
    $this->title = '验证邮箱发送失败！'; 
    $this->params['breadcrumbs'][0] = $this->title;
    ?>

    <p> 服务器错误，请刷新后操作！</p>

    <?php else: ?>


<div class="row">
    <div class="col-lg-5">

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'password2')->passwordInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => '/site/captcha',
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

    <?php endif; ?>

<p>已有账号？ <?= Html::a('登录', ['login']) ?> </p>

    </div>
</div>
