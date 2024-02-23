<?php

namespace frontend\modules\cp\controllers;

use common\models\Company;
use common\models\CompanyDay;
use common\models\CompanySocial;
use common\models\search\CompanySearch;
use common\models\User;
use common\models\UserCompany;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;
/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Lists all Company models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Company();
        $model->region_id = 33;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if($model->logo = UploadedFile::getInstance($model,'logo')){
                    $name = "logo/".microtime(true).'.'.$model->logo->extension;
                    $model->logo->saveAs(\Yii::$app->basePath.'/web/upload/'.$name);
                    $model->logo = $name;
                }else{
                    $model->logo = "default/company.png";
                }
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $logo = $model->logo;
        $model->region_id = $model->soato ? $model->soato->region_id : 33;
        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->logo = UploadedFile::getInstance($model,'logo')){
                $name = "logo/".microtime(true).'.'.$model->logo->extension;
                $model->logo->saveAs(\Yii::$app->basePath.'/web/upload/'.$name);
                $model->logo = $name;
                if(file_exists(\Yii::$app->basePath.'/web/upload/'.$name) and $name != "default/company.png"){
                    unlink(\Yii::$app->basePath.'/web/upload/'.$name);
                }
            }else{
                $model->logo = $logo;
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionAdduser($id){
        $model = new User();
        $model->scenario = 'insert';
        if($model->load($this->request->post())){
            $model->setPassword($model->password);
            $model->image = "default/avatar.png";

            if($model->save()){
                $user = new UserCompany();
                $user->company_id = $id;
                $user->user_id = $model->id;
                if($user->save()){
                    return $this->redirect(['view','id'=>$id]);
                }else{
                    Yii::$app->session->setFlash('error','Foydalanuvchini tashkilotga biriktirishda xatolik');
                }
            }else{
                Yii::$app->session->setFlash('error','Foydalanuvchi ma`lumotlari yetarli emas yoki ushbu telefon raqami avval foydalanilgan!');
            }
        }
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionDeleteuser($id){
        $model = User::findOne($id);
        $user = UserCompany::findOne(['user_id'=>$id]);
        $model->status = -1;
        $model->username = Yii::$app->security->generateRandomString(40);
        while (User::findOne(['username'=>$model->username])){
            $model->username = Yii::$app->security->generateRandomString(40);
        }
        if($model->save(false)){
            Yii::$app->session->setFlash('success','Foydalanuvchi muvoffaqiyatli o`chirildi!');
        }else{
            Yii::$app->session->setFlash('error','Foydalanuvchini o`chirishda xatolik');
        }
        return $this->redirect(['view','id'=>$user->company_id]);
    }

    public function actionUpdateuser($id){
        $model = User::findOne($id);
        $pas = $model->password;
        if($model->load($this->request->post())){
            if($model->password){
                $model->setPassword($model->password);
            }else{
                $model->password = $pas;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success','Foydalanuvchi ma`lumotlari muvoffaqiyatli saqlandi');
            }else{
                Yii::$app->session->setFlash('error','Foydalanuvchi ma`lumotlarini saqlashda xatolik!');
            }
            return $this->redirect(['view','id'=>UserCompany::findOne(['user_id'=>$model->id])->company_id]);
        }
        $model->password = "";
        return $this->renderAjax('_updateuser',['model'=>$model]);
    }

    /**
     * Deletes an existing Company model.
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
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCreatesocial($id,$company_id){
        $model = CompanySocial::findOne(['social_id'=>$id,'company_id'=>$company_id]);
        if(!$model){
            $model = new CompanySocial();
            $model->company_id = $company_id;
            $model->social_id = $id;
        }
        if($model->load($this->request->post())){
            if($model->save()){
                Yii::$app->session->setFlash('success','Ma`lumot muvoffaqiyatli saqlandi!');
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
            }
            return $this->redirect(['view','id'=>$company_id]);
        }

        return $this->renderAjax('_social',[
            'model'=>$model
        ]);
    }

    public function actionDeletesocial($id,$company_id){
        $model = CompanySocial::findOne(['social_id'=>$id,'company_id'=>$company_id]);
        if($model and $model->delete()){
            Yii::$app->session->setFlash('success','Muvoffaqiyatli o`chirildi!');
        }else{
            Yii::$app->session->setFlash('error','Ushbu ijtimoiy tarmoqni o`chirishda xatolik.');
        }
        return $this->redirect(['view','id'=>$company_id]);

    }

    public function actionWorkdaychange($id,$company_id,$code){
        if($code == 'create'){
            $model = new CompanyDay();
            $model->company_id = $company_id;
            $model->day_id = $id;
            $model->save(false);

        }elseif($code == 'delete'){
            $model = CompanyDay::findOne(['day_id'=>$id,'company_id'=>$company_id]);
            $model->delete();

        }
        return $id;
    }
    public function actionWorkstatus($id,$code){
        $model = $this->findModel($id);
        if($code == 'close'){
            $model->work_status = 0;
        }else{
            $model->work_status = 1;
        }
        $model->save(false);
        return 1;
    }
}

