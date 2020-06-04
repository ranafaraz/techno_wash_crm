<?php

namespace backend\controllers;

use Yii;
use common\models\Customer;
use common\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use common\models\CustomerVehicles;
use backend\models\Model;
use yii\filters\AccessControl;


/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete', 'bulk-delete','sale-invoice-view','fetch-info','branch-details','customer-detail-view','paid-sale-invoice','collect-sale-invoice','update-sale-invoice','credit-sale-invoice','sale-invoice-transaction','customer-profile','update-sih-add-items'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
     * Lists all Customer models.
     * @return mixed
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionUpdateSihAddItems(){
        return $this->render('update-sih-add-items');
    }
    public function actionCustomerProfile(){
        return $this->render('customer-profile');
    }
    public function actionCollectSaleInvoice(){
        return $this->render('collect-sale-invoice');
    }
    public function actionUpdateSaleInvoice(){
        return $this->render('update-sale-invoice');
    }
    public function actionCreditSaleInvoice(){
        return $this->render('credit-sale-invoice');
    }
    public function actionSaleInvoiceView(){
        return $this->render('sale-invoice-view');
    }
    public function actionPaidSaleInvoice(){
        return $this->render('paid-sale-invoice');
    }
    public function actionFetchInfo(){
        return $this->render('fetch-info');
    }
    public function actionSaleInvoiceTransaction(){
        return $this->render('sale-invoice-transaction');
    }
    public function actionIndex()
    {    
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        return $this->render('customer-detail-view');
        // $request = Yii::$app->request;
        // if($request->isAjax){
        //     Yii::$app->response->format = Response::FORMAT_JSON;
        //     return [
        //             'title'=> "",
        //             'content'=>$this->renderAjax('view', [
        //                 'model' => $this->findModel($id),
        //             ]),
        //             'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
        //                     Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
        //         ];    
        // }else{
        //     return $this->render('view', [
        //         'model' => $this->findModel($id),
        //     ]);
        // }
    }

    /**
     * Creates a new Customer model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Customer();
         $modelCustomerVehicles = [new CustomerVehicles];  

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
                         'modelCustomerVehicles'=>(empty($modelCustomerVehicles)) ? [new CustomerVehicles] : $modelCustomerVehicles,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit", 'id'=>'create_cust_btn'])
        
                ];         
            }else if($model->load($request->post())){

                    $model->customer_image = UploadedFile::getInstance($model,'customer_image');

                // checking the field 
                if(!empty($model->customer_image)){
                    // making the name of the image file
                    $imageName = $model->customer_name.'_photo';
                    // getting extension of the image file
                    $imageExtension = $model->customer_image->extension;
                    // save the path of the image in backend/web/uploads 
                    $model->customer_image->saveAs('uploads/'.$imageName.'.'.$model->customer_image->extension);
                    //save the path in the db column
                    $model->customer_image = 'uploads/'.$imageName.'.'.$model->customer_image->extension;
                    }
                    else if (($model->customer_gender) == "Female"){
                        $model->customer_image = 'uploads/default-image-female.png'; 
                    }
                    else {
                        $model->customer_image = 'uploads/default-image-name.png'; 
                    }
                    $model->customer_registration_date   = new \yii\db\Expression('NOW()');
                    $model->branch_id = Yii::$app->user->identity->branch_id; 
                    $model->created_by = Yii::$app->user->identity->id; 
                    $model->created_at = new \yii\db\Expression('NOW()');
                    $model->updated_by = '0';
                    $model->updated_at = '0';

                    $modelCustomerVehicles = Model::createMultiple(CustomerVehicles::classname()); 
                    Model::loadMultiple($modelCustomerVehicles, Yii::$app->request->post());                    

                    // validate all models
                    $valid = $model->validate();
                    $valid = Model::validateMultiple($modelCustomerVehicles) && $valid;
                    
                    if ($valid) {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            if ($flag = $model->save(false)) {
                                foreach ($modelCustomerVehicles as $value) {
                                    $value->image = 'uploads/default-car-image.png';
                                    $value->customer_id = $model->customer_id;
                                    $value->created_at = new \yii\db\Expression('NOW()');
                                    $value->created_by = Yii::$app->user->identity->id; 
                                    $value->updated_by = '0';
                                    $value->updated_at = '0';    
                                    if (! ($flag = $value->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                } // modelCustomerVehicles foreach end
                            } // closing of if model
                            if ($flag) {
                                $transaction->commit();
                                return $this->redirect(['./customer-vehicles?sort=-customer_id']);
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                            echo $e;
                        }
                  
                    }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create New Customer",
                    'content'=>'<span class="text-success">Create Customer success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                    // .
                    //         Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            } // closing of else if
            else{           
                return [
                    'title'=> "Create New Customer",
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->customer_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Customer model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);  
        $customer_image = Yii::$app->db->createCommand("SELECT customer_image FROM customer where customer_id = $id")->queryAll();
        $customerImage=$customer_image[0]["customer_image"];     

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
            }else if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','customer_id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
                $model->customer_image = UploadedFile::getInstance($model,'customer_image');

                // checking the field
                if(!empty($model->customer_image)){
                    // making the name of the image file
                    $imageName = $model->customer_name.'_photo';
                    // getting extension of the image file
                    $imageExtension = $model->customer_image->extension;
                    // save the path of the image in backend/web/uploads 
                    $model->customer_image->saveAs('uploads/'.$imageName.'.'.$model->customer_image->extension);
                    //save the path in the db column
                    $model->customer_image = 'uploads/'.$imageName.'.'.$model->customer_image->extension;
                }
                else {
                   $model->customer_image = $customerImage;
                }
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = new \yii\db\Expression('NOW()');
                $model->created_by = $model->created_by;
                $model->created_at = $model->created_at;
                $model->update();
                return $this->redirect(['./customer-profile', 'customer_id' => $model->customer_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Customer model.
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
     * Delete multiple existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
