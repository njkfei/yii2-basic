<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        Yii::$app->cache->set('test', 'hehe..');
        echo Yii::$app->cache->get('test'), "\n";

        Yii::$app->cache->set('test1', 'haha..', 5);
        echo '1 ', Yii::$app->cache->get('test1'), "\n";
        sleep(6);
        echo '2 ', Yii::$app->cache->get('test1'), "\n";
        return 'hello,world';
        //return $this->render('index');
    }

    public function actionDb(){
        $posts = Yii::$app->db->createCommand('SELECT * FROM ysyy_user')
            ->queryAll();

        echo json_encode($posts);
    }

    public function  actionThemes(){
        $posts = Yii::$app->db->createCommand('SELECT * FROM themes')
            ->queryAll();

        echo json_encode($posts);
    }

    public function actionTt(){
        $id=1;
        $theme = Yii::$app->cache->get("theme".$id);

        if($theme==false){
            $theme = Yii::$app->db->createCommand('SELECT * FROM themes ')->queryOne();

            echo json_encode($theme);

            Yii::$app->cache->set("theme".$id,json_encode($theme));
        }

        return $theme;
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
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
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
