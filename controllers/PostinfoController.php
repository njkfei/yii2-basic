<?php

namespace app\controllers;

use Yii;
use app\models\Postinfo;
use app\models\PostinfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBasicAuth;
use app\models\User;
use yii\filters\AccessControl;

/**
 * PostinfoController implements the CRUD actions for Postinfo model.
 */
class PostinfoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
/*                'basicAuth' => [
                    'class' => HttpBasicAuth::className(),
                    'auth' => [$this, 'auth']
                ],*/
            ],
        ];
    }

/*    public function auth($username, $password)
    {
        // username, password are mandatory fields
        if(empty($username) || empty($password))
            return null;

        // get user using requested email
        $user = \app\models\User::findByUsername( $username);

        // if no record matching the requested user
        if(empty($user))
            return null;

        // hashed password from user record
        $this->user_password = $user->user_password;

        // validate password
        $isPass = \app\models\User::validatePassword($password);

        // if password validation fails
        if(!$isPass)
            return null;

        // if user validates (both user_email, user_password are valid)
        return $user;
    }*/

    /**
     * Lists all Postinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostinfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Postinfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Postinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Postinfo();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->zip_source_file = UploadedFile::getInstances($model, 'zip_source_file');
            $model->themepic_file = UploadedFile::getInstances($model, 'themepic_file');


            var_dump($model);

            if ($model->upload()) {
                // file is uploaded successfully
                echo "upload controller ok";
            }else{
                echo "upload controller fail";
            }
/*
 *             'pacname' => 'Pacname',
            'version' => 'Version',
            'version_in' => 'Version In',
            'title' => 'Title',
            'zip_source' => 'Zip Source',
            'zip_name' => 'Zip Name',
            'themepic' => 'Themepic',
            'theme_url' => 'Theme Url',
            'status' => 'Status',
            'themepic_file' => "themepic_file",
            'zip_source_file' => 'zip_source_file'
 */
            var_dump($model);

            Yii::$app->db->createCommand()->insert('postinfo',$model->attributes)->execute();

            $searchModel = new PostinfoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Postinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->zip_source_file = UploadedFile::getInstances($model, 'zip_source_file');
            $model->themepic_file = UploadedFile::getInstances($model, 'themepic_file');
            if ($model->upload()) {
                // file is uploaded successfully
                echo "upload controller ok";
            }else{
                echo "upload controller fail";
            }

           echo "save to db";
          // $model->save();

           var_dump($model->attributes);
           var_dump($model->id);
           Yii::$app->db->createCommand()->update('postinfo', $model->attributes, 'id ='.$model->id)->execute();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Postinfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Postinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Postinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Postinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
