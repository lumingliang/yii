<?php

namespace app\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\admin\models\LoginForm;
use app\admin\models\RegisterForm;
//use app\admin\models\Entryform;
use app\admin\models\User;
use yii\helpers\Url;



class AuthController extends Controller
{
    // private $session;

    public function behaviors() // 运行时开始，逐个历遍，并应用
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'], // 代表只允许认证过的user
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get', 'post'], // 过滤http方法
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            // 使用siteController中的captcha 服务? 删掉无效了
            'captcha' => [ 
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'lll' : null,
            ],
        ]; 
    }

    public function actionIndex()
    {
        //var_dump(Yii::$app->user);
		return $this->render('index');

        // $searchModel = new CountrySearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        // ]);
    }

    public function actionTest() {

        var_dump(Yii::$app->session);
    }

    public function actionLogin()
    {
        // $this->testExit();
        // echo 'test exit';
        // exit;
        // $r = Yii::$app->request->post();
        // var_dump($r);
        // exit;
//        return $this->goHome();
/*         echo Yii::$app->user->isGuest.'jj'; */
        // return;
        // 如果不是游客 
        if (!\Yii::$app->user->isGuest) {
            
            echo 'you had login';
            // $this->loginRedirect();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $role = $model->_user->role;
            // $this->session->set('role', $role);
            // $this->loginRedirect();
            // var_dump($role);
            // exit;
            // return $this->goBack();
            // echo 'login success!';
            // exit;
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function loginRedirect() {

        $role = $this->session['role'];
        $url = Url::to(['/'.$role['name'].'/index']);
        return $this->redirect($url);
         
    }

    public function testExit() {

        echo 'iiii';
        exit;
    }

    public function actionRegister() {

        $model = new RegisterForm();
        if( $model->load(Yii::$app->request->post()) ) {
            $session = Yii::$app->session;
            $code = Yii::$app->getSecurity()->generateRandomString();
            $session->set('newUser', ['model' => $model, 'code' => $code]);
            // 发送邮件验证
            $isSend = Yii::$app->mailer->compose('registerEmailCheck') //view
                ->setFrom('18186493126@163.com')
                ->setTo($model->email)
                ->setSubject('验证邮箱')
                ->send();

                if ($isSend) {
                    $session->setFlash('registerEmailHadSend');
                    // 刷新
                    return $this->refresh();
                } else {
                    $session->remove('newUser');
                    $session->setFlash('registerEmailSendError');
                    //echo '服务器错误！';
                    return $this->refresh();
                }
            // var_dump($session['newUser']);
            // echo 'register post has submit please go to ';
        } else {
            return $this->render('register', ['model' => $model]);
        }
    }

    public function actionRegisterEmailCheck($code) {

        $session = Yii::$app->session;
        //var_dump($session['newUser']);
        if ( $session['newUser']['code'] == $code ) {

            $model = $session['newUser']['model'];
            //var_dump($model);

            if ( $model->createNewUser() ) {

                $session->remove('newUser');
                $session->setFlash('createNewUserSuccess');
                return $this->redirect(Url::to(['login']));
            } else {

                echo '服务器错误！请重新操作';
            }
            //echo 'check sucess!.'.$code;
        } else {

            throw new \yii\web\HttpException(403);
        }
        //var_dump();
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        echo '退出成功！';
        return 0;
        exit;

//        return $this->goHome();
    }

    // public function __construct() {

        // $this->session = Yii::$app->session;
    // }

}
