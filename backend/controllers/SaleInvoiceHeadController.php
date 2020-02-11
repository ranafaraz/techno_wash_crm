<?php

namespace backend\controllers;

use Yii;
use common\models\SaleInvoiceHead;
use common\models\SaleInvoiceHeadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * SaleInvoiceHeadController implements the CRUD actions for SaleInvoiceHead model.
 */
class SaleInvoiceHeadController extends Controller
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

                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete', 'bulk-delete','branch-details','sale-invoice-view','add-sale-invoice-service','add-sale-invoice-stock','fetch-info','create-sale-invoice','customer-invoice-lists', 'insert-services-invoice', 'insert-invoice'],
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
     * Lists all SaleInvoiceHead models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new SaleInvoiceHeadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single SaleInvoiceHead model.
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
     * Creates a new SaleInvoiceHead model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    // public function actionInsertInvoice($user_id, $branch_id, $invoice_date, $customer_id, $regno, $vehicleArray, $paid, $remaining, $cash_return, $status, $serviceArray, $amountArray, $ItemTypeArray, $total_amount, $quantityArray, $net_total){
    //     // data inserted from customer/sale-invoice-view page

    //     $disc_amount = $total_amount - $net_total;
    //     $countItemArray = count($vehicleArray);

    //     //starting of transaction handling
    //     // $transaction = \Yii::$app->db->beginTransaction();
    //     // try {
    //     //     $insert_invoice_head = Yii::$app->db->createCommand()->insert('sale_invoice_head',[
    //     //         'branch_id' => $branch_id,
    //     //         'customer_id'       => $customer_id,
    //     //         'date'              => $invoice_date,
    //     //         'total_amount'      => $total_amount,
    //     //         'discount'          => $disc_amount,
    //     //         'net_total'         => $net_total,
    //     //         'paid_amount'       => $paid,
    //     //         'remaining_amount'  => $remaining,
    //     //         'cash_return'       => $cash_return,
    //     //         'status'            => $status,
    //     //         'created_by'        => $user_id,
    //     //     ])->execute();

    //     //     if ($insert_invoice_head) {
    //     //         $select_invoice = Yii::$app->db->createCommand("
    //     //             SELECT  sale_inv_head_id
    //     //             FROM sale_invoice_head
    //     //             WHERE customer_id       = '$customer_id'
    //     //             AND branch_id = '$branch_id'
    //     //             AND CAST(date as DATE)  = '$invoice_date'
    //     //             AND total_amount        = '$total_amount'
    //     //             AND discount            = '$disc_amount'
    //     //             AND net_total           = '$net_total'
    //     //             AND paid_amount         = '$paid'
    //     //             AND remaining_amount    = '$remaining'
    //     //             AND status              = '$status'
    //     //             ORDER BY sale_inv_head_id DESC
    //     //             ")->queryAll();
                
    //     //         $selectedInvHeadID = $select_invoice[0]['sale_inv_head_id'];

    //     //         $insert_invoice_amount = Yii::$app->db->createCommand()->insert('sale_invoice_amount_detail',[

    //     //                 'sale_inv_head_id' => $selectedInvHeadID,
    //     //                 'transaction_date'      => new \yii\db\Expression('NOW()'),
    //     //                 'paid_amount'           => $paid,
    //     //                 //'transaction_id'    => $transactionId,
    //     //                 'created_by'            => $user_id,
    //     //             ])->execute();

    //     //         if ($insert_invoice_amount) {
    //     //             $invoiceData = Yii::$app->db->createCommand("
    //     //                 SELECT  *
    //     //                 FROM sale_invoice_amount_detail
    //     //                 WHERE sale_inv_head_id  = '$selectedInvHeadID'
    //     //                 ORDER BY s_inv_amount_detail DESC
    //     //             ")->queryAll();
    //     //             $invoice_amount = $invoiceData[0]['s_inv_amount_detail'];

    //     //             // id 12 is reserved for Sale Account
    //     //             $transactions = Yii::$app->db->createCommand()->insert('transactions',
    //     //             [
    //     //                 'branch_id' => $branch_id,
    //     //                 'account_head' => 12,
    //     //                 'total_amount' => $net_total,
    //     //                 'amount' => $paid,
    //     //                 'remaining' => $remaining,
    //     //                 'head_id' => $selectedInvHeadID,
    //     //                 'ref_no' => $invoice_amount,
    //     //                 'ref_name' => "Sale",
    //     //                 'transactions_date' => $invoice_date,
    //     //                 'created_by' => \Yii::$app->user->identity->id,
    //     //             ])->execute();          

    //     //             for ($j=0; $j <$countItemArray ; $j++) {
    //     //                 $itemType = $ItemTypeArray[$j];
    //     //                 $quantity = $quantityArray[$j];

    //     //                 if($itemType == "Product"){
    //     //                     $product_id = $serviceArray[$j];

    //     //                     $selectProduct = Yii::$app->db->createCommand("
    //     //                         SELECT *
    //     //                         FROM stock
    //     //                         WHERE name = '$product_id'
    //     //                         AND status = 'In-stock'
    //     //                         LIMIT $quantity
    //     //                         ")->queryAll();
    //     //                     $count = count($selectProduct);

    //     //                     for ($i=0; $i<$count; $i++) { 
    //     //                         $stock_id = $selectProduct[$i]['stock_id'];

    //     //                         $insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

    //     //                         'sale_inv_head_id'      => $selectedInvHeadID,
    //     //                         'customer_vehicle_id'   => $vehicleArray[$j],
    //     //                         'item_id'               => $stock_id,
    //     //                         'item_type'             => "Stock",
    //     //                         'discount_per_service'  => $amountArray[$j],
    //     //                         'created_by'            => $user_id,
    //     //                         ])->execute();

    //     //                         $examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
    //     //                             'status'        => "Sold",  
    //     //                             'updated_by'    => $user_id
    //     //                             ],
    //     //                             ['stock_id' => $stock_id]
    //     //                         )->execute();
    //     //                     }
    //     //                 } //closing of quantity if 
    //     //                 else {
    //     //                     $insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

    //     //                         'sale_inv_head_id'      => $selectedInvHeadID,
    //     //                         'customer_vehicle_id'   => $vehicleArray[$j],
    //     //                         'item_id'               => $serviceArray[$j],
    //     //                         'item_type'             => $ItemTypeArray[$j],
    //     //                         'discount_per_service'  => $amountArray[$j],
    //     //                         'created_by'            => $user_id,
    //     //                         ])->execute();

    //     //                     if ($ItemTypeArray[$j] == "Stock") {

    //     //                         $examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
    //     //                                 'status'        => "Sold",  
    //     //                                 'updated_by'    => $user_id
    //     //                                 ],
    //     //                             ['stock_id' => $serviceArray[$j]]
    //     //                         )->execute();
    //     //                     }
    //     //                 } // closing of quantity else
    //     //             } // end of for loop itemarray
    //     //             // transaction commit
    //     //             $transaction->commit();
    //     //             return json_encode("[".$selectedInvHeadID."]");
    //     //         } //if ($insert_invoice_amount)
    //     //     } // end of if ($insert_invoice_head) 
    //     // } // closing of try block 
    //     // catch (Exception $e) {
    //     //     // transaction rollback
    //     //     $transaction->rollback();
    //     // } // closing of catch block

    //     return json_encode($branch_id);
    //     return json_encode($invoice_date);
    //     return json_encode($customer_id);
    //     return json_encode($regno);
    //     return json_encode($vehicleArray);
    //     return json_encode($paid);
    //     return json_encode($remaining);
    //     return json_encode($cash_return);
    //     return json_encode($status);
    //     return json_encode($serviceArray);
    //     return json_encode($amountArray);
    //     return json_encode($ItemTypeArray);
    //     return json_encode($total_amount);
    //     return json_encode($quantityArray);
    //     return json_encode($net_total);

    // }

    public function actionCreateSaleInvoice(){
        return $this->render('create-sale-invoice');
    }
    public function actionSaleInvoiceView(){
        return $this->render('sale-invoice-view');
    }
    public function actionAddSaleInvoiceService(){
        return $this->render('add-sale-invoice-service');
    }
    public function actionAddSaleInvoiceStock(){
        return $this->render('add-sale-invoice-stock');
    }
    public function actionFetchInfo(){
        return $this->render('fetch-info');
    }
    public function actionCustomerInvoiceLists(){
        return $this->render('customer-invoice-lists');
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new SaleInvoiceHead();  

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
            }else if($model->load($request->post())){
                // starting of transaction handling
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $model->created_by = Yii::$app->user->identity->id; 
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->updated_by = '0';
            $model->updated_at = '0'; 
            $model->save();
            // transaction commit
            $transaction->commit();
            return $this->redirect(['./sale-invoice-view', 'sale_invoice_id' => $model->sale_inv_head_id,'customer_id' => $model->customer_id] );
            } // closing of try block 
            catch (Exception $e) {
                // transaction rollback
                $transaction->rollback();
            } // closing of catch block
            // closing of transaction handling
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create New SaleInvoiceHead",
                    'content'=>'<span class="text-success">Create SaleInvoiceHead success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create New SaleInvoiceHead",
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
                return $this->redirect(['view', 'id' => $model->sale_inv_head_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }  
    }

    /**
     * Updates an existing SaleInvoiceHead model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->sale_inv_head_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing SaleInvoiceHead model.
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
     * Delete multiple existing SaleInvoiceHead model.
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
     * Finds the SaleInvoiceHead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SaleInvoiceHead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SaleInvoiceHead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
