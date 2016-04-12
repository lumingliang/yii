<?php

namespace app\controllers;

use app\models\EntryForm as EntryForm;
use Yii;
use app\models\Country;
use yii\helpers\Html;
use app\models\CountrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

class TestController extends Controller {
	// 使用特定布局
//	public $layout = 'testLayout';
	public $layout = 'testNested';

	public function actionTestGo() {
		// echo 'i am the test of an action';
		 $form = new EntryForm();
		// $form->name = 'lu';
		// echo $form->name;
		 $form['name'] = 'lumin';
		 var_dump($form->attributes);
		// echo $form['name'];
		//echo $form->getAttributeLabel('ame'); //把一个值的名转换为label友好形式
	}

    public function actionIndex()
    {
        // 首页调用search 方法得到全部信息
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider[0],
            'pagination' => $dataProvider[1],
        ]);
    }

    /**
     * Displays a single Country model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Country();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->touch('time');
        //echo $model->created_at;
        echo $model->time;
        // $model->touch('population');
        return;
        // exit;
		// echo $model->code;
		//exit;
		// $this->fields();
		// var_dump($model->toArray([]));
		// //var_dump($this->fields());
		// //echo Html::encode('<script>jjjjj</script>');
		// echo HtmlPurifier::process('<script>jjjjj</script>');
		// exit;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

	// 确定输出的属性是什么,但是为何无效
	public function fields() {
		return [
			'id',
			'email' => function() {
				return $this->code;
			},
		];
	}

    /**
     * Deletes an existing Country model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // 利用findModel方法简化后面的查询 
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionTest() {
        //echo Url::home();
		//echo 'yeah';
        echo Url::to(['product/view', 'id' => 42]);
        echo Url::toRoute('site/index', 'http');
        Url::remember();
	}

    public function actionG() {
        echo Url::previous();
        $password = 'i love you';
        echo $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

}
