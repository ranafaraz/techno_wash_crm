<?php

namespace backend\controllers;

use Yii;
use common\models\CustomerVehicles;
use common\models\CustomerVehiclesSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;


/**
 * CustomerVehiclesController implements the CRUD actions for CustomerVehicles model.
 */
class CustomerVehiclesController extends Controller
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
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all CustomerVehicles models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new CustomerVehiclesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single CustomerVehicles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{ 
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new CustomerVehicles model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $request = Yii::$app->request;
        $model = new CustomerVehicles();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $model->image = UploadedFile::getInstance($model,'image');

                // checking the field
                if(!empty($model->image)){
                    // making the name of the image file
                    $imageName = $model->registration_no.'_photo';
                    // getting extension of the image file
                    $imageExtension = $model->image->extension;
                    // save the path of the image in backend/web/uploads 
                    $model->image->saveAs('uploads/'.$imageName.'.'.$model->image->extension);
                    //save the path in the db column
                    $model->image = 'uploads/'.$imageName.'.'.$model->image->extension;
                }
                else {
                   $model->image = 'uploads/'.'default-car-image.png'; 
                }
                $model->created_by = Yii::$app->user->identity->id; 
                $model->created_at = new \yii\db\Expression('NOW()');
                $model->updated_by = '0';
                $model->updated_at = '0';
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create New CustomerVehicles",
                    'content'=>'<span class="text-success">Create CustomerVehicles success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create New CustomerVehicles",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                $model->image = UploadedFile::getInstance($model,'image');

                // checking the field
                if(!empty($model->image)){
                    // making the name of the image file
                    $imageName = $model->registration_no.'_photo';
                    // getting extension of the image file
                    $imageExtension = $model->image->extension;
                    // save the path of the image in backend/web/uploads 
                    $model->image->saveAs('uploads/'.$imageName.'.'.$model->image->extension);
                    //save the path in the db column
                    $model->image = 'uploads/'.$imageName.'.'.$model->image->extension;
                }
                else {
                   $model->image = 'uploads/'.'default-car-image.png'; 
                }
                $model->customer_id = $id;
                $model->created_by = Yii::$app->user->identity->id; 
                $model->created_at = new \yii\db\Expression('NOW()');
                $model->updated_by = '0';
                $model->updated_at = '0';
                $model->save();
                $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    echo $e;
                }
                return $this->redirect(['./customer-detail-view', 'id' => $model->customer_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing CustomerVehicles model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);  
        $image = Yii::$app->db->createCommand("SELECT image FROM customer_vehicles where customer_vehicle_id = $id")->queryAll();
        $vehicleImage=$image[0]["image"];        

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $model->image = UploadedFile::getInstance($model,'image');

                // checking the field
                if(!empty($model->image)){
                    // making the name of the image file
                    $imageName = $model->registration_no.'_photo';
                    // getting extension of the image file
                    $imageExtension = $model->image->extension;
                    // save the path of the image in backend/web/uploads 
                    $model->image->saveAs('uploads/'.$imageName.'.'.$model->image->extension);
                    //save the path in the db column
                    $model->image = 'uploads/'.$imageName.'.'.$model->image->extension;
                }
                else {
                   $model->image = $vehicleImage; 
                }
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = new \yii\db\Expression('NOW()');
                $model->created_by = $model->created_by;
                $model->created_at = $model->created_at;
                $model->update();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->validate()) {
                $model->image = UploadedFile::getInstance($model,'image');

                // checking the field
                if(!empty($model->image)){
                    // making the name of the image file
                    $imageName = $model->registration_no.'_photo';
                    // getting extension of the image file
                    $imageExtension = $model->image->extension;
                    // save the path of the image in backend/web/uploads 
                    $model->image->saveAs('uploads/'.$imageName.'.'.$model->image->extension);
                    //save the path in the db column
                    $model->image = 'uploads/'.$imageName.'.'.$model->image->extension;
                }
                else {
                   $model->image = $vehicleImage; 
                }
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = new \yii\db\Expression('NOW()');
                $model->created_by = $model->created_by;
                $model->created_at = $model->created_at;
                $model->update();
                return $this->redirect(['./customer-detail-view', 'id' => $model->customer_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing CustomerVehicles model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing CustomerVehicles model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the CustomerVehicles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerVehicles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerVehicles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
