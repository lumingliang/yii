<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Entryform;
use app\models\User;



class SiteController extends Controller
{
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
                    'logout' => ['post'], // 过滤http方法
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
            // 统一用的方法
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			'page' => [
				'class' => 'yii\web\ViewAction',
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

    public function actionLogin()
    {
        // $r = Yii::$app->request->post();
        // var_dump($r);
        // exit;
//        return $this->goHome();
/*         echo Yii::$app->user->isGuest.'jj'; */
        // return;
        // 如果不是游客 
        if (!\Yii::$app->user->isGuest) {
            // echo 'no login';
            // return;
            return $this->goHome(); //主页自带判断用户代码
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        // var_dump($model->load(Yii::$app->request->post()));
        // var_dump($model->attributes());
        // exit;
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout($mes = 'hi')
    {
		echo 'jjj';
        //return $this->render('about');
		return $this->render('say', ['mes' => $mes]);
    }

	public function actionBa() {
		echo 'ba';
	}

	public function actionSay($mes = 'hi') 
	{
		echo 'jjjj';
		return $this->render('say', ['mes' => $mes]);
	}

    public function actionEmail() {
        // $t = Yii::$app->mailer->htmlLayout;
        // echo $t;
        echo 'test email';
        Yii::$app->mailer->compose('email') //a view
            ->setFrom('18186493126@163.com')
            ->setTo('156448398@qq.com')
            ->setSubject('测试')
            ->send();
        echo 'email had send';
    }


	public function actionEntry() {

		$model = new Entryform();

		if($model->load(Yii::$app->request->post()) && $model->validate()) { // Yii是一个全局类的对象，里面包含了许多初始化后得到的必要功能，如获取请求数据，获取数据库连接等
            // var_dump($model->attributes);
			return $this->render('entry-confirm', ['model' => $model]);
		} else {
			return $this->render('entry', ['model' => $model]);
		}
	}

    public function actionAuth() {

        var_dump(Yii::$app->request->get());
        //$_user = User::findByUsername($this->username);
        $identity = Yii::$app->user->identity;
        var_dump( $identity );
    }

    public function actionSession() {

        Yii::$app->session->setFlash('love');
        //echo Yii::$app->session->hasFlash('love');
    }

    public function actionTs() {

        // 尽可以取出一次
        echo Yii::$app->session->hasFlash('love');
    }

    public function actionSetCookie() {

        $key = Yii::$app->getSecurity()->generateRandomString();
        echo $key;
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'remember_token',
            // value自动加密
            'value' => $key,
        ]));
    }

    public function actionReadCookie() {

        if(isset(Yii::$app->request->cookies['remember_token'])) {
            // value 自动解密
            echo Yii::$app->request->cookies->get('remember_token');
        }
    }

    public function actionTestStatic() {

        $sta = 'lumin';
        var_dump(new static($sta)); // 会报错
    }

}
