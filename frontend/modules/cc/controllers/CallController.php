<?php

namespace frontend\modules\cc\controllers;

use common\models\Call;
use common\models\CallResult;
use common\models\search\CallSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * CallController implements the CRUD actions for Call model.
 */
class CallController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Call models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CallSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Call model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $result = new CallResult();
        $results = CallResult::find()->where(['call_id'=>$id])->orderBy(['id'=>SORT_DESC])->all();

        if($result->load($this->request->post())){
            $result->status = 4;
            $result->call_id = $model->id;
            $result->user_id = Yii::$app->user->id;
            $rid = CallResult::find()->where(['user_id'=>$result->user_id,'call_id'=>$result->call_id])->max('id');
            if(!$rid){
                $rid  =0;
            }
            $rid ++;
            $result->id = $rid;
            $result->consept_id = $result->user_id;
            if($result->save()){
                $model->status = 4;
                $model->save(false);
                Yii::$app->session->setFlash('success','Chaqiruv muvoffaqiyatli tugallandi');
            }else{
                Yii::$app->session->setFlash('error','Chaqiruv tugallashda xatolik');
            }
        }


        return $this->render('view', [
            'model' => $model,
            'result'=>$result,
            'results'=>$results
        ]);
    }

    /**
     * Creates a new Call model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Call();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Call model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Call model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Call model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Call the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Call::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
