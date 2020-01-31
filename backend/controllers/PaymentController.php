<?php

namespace backend\controllers;

use Yii;
use common\models\Payment;
use common\models\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\models\AccountPayable;
use yii\helpers\json;
use common\models\Transactions;
use common\models\AccountHead;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Payment #".$id,
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

    public function beforeAction($action) 
{ 
    $this->enableCsrfValidation = false; 
    return parent::beforeAction($action); 
}

public function actionGetPayment($debit_account,$title_id)
{

    $title = AccountPayable::find()->where(['account_payable' => $title_id])->andwhere(['title_id' => $debit_account])->One();
    if(isset($title))
    {
        echo Json::encode($title);
    }
}
    /**
     * Creates a new Payment model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Payment();
        $accountpayable = new AccountPayable();
        $transaction_model = new Transactions();

        ///////////////////////////////////////////////////////////

       $model->created_by = \Yii::$app->user->identity->username;
        // $model->updated_by = \Yii::$app->user->identity->username;
        // $model->updated_at = date('Y-m-d h:m:s');

        $model->transactions_date = date('Y-m-d h:m:s');
      //  $model->transaction_type='payment';
        $model1 = Payment::find('transaction_id')->orderBy(['transaction_id' => SORT_DESC])->One();
        if($model1 == "")
        {
            $model->transaction_id = '1';
        }
        else
        {
            (int)$trans = (int)$model1->transaction_id;
            $model->transaction_id = (int)$trans + 1;
        }
        // $model->organization_id = \Yii::$app->user->identity->organization_id;
        ////////////////////////////////////////////////////////////
            /*
            *   Process for non-ajax request
            */

            if ($model->load($request->post()) && $accountpayable->load($request->post())) 
            {
                $connection=yii::$app->db;
                $amount=0;
                $model_head = AccountHead::find()->where(['account_name' => 'Account Payable'])->One();

                if($model->prev_remaning == 0)
                {
                    if($model->debit_amount == $model->credit_amount){
                        $connection->createCommand()->insert('transactions',
                        [
                            'branch_id' => Yii::$app->user->identity->branch_id,
                            'type' => $model->type,
                            'narration' => $model->narration,
                            'debit_account' => $model->debit_account,
                            'amount' => $model->debit_amount,
                            'credit_account' => $model->credit_account,
                            'transactions_date' => $model->transactions_date,
                            'created_by' => \Yii::$app->user->identity->id,
                        ])->execute();
                    } else {
                        if($model->debit_amount > $model->credit_amount)
                        {
                            $remaning = $model->debit_amount - $model->credit_amount;

                            $connection->createCommand()->Insert('account_payable',
                            [   
                                'branch_id' => Yii::$app->user->identity->branch_id,
                                'amount'=>$remaning,
                                'account_payable'=>$model->debit_account,
                                'due_date'=>$accountpayable->due_date,
                                'narration' => $model->payable_narration,
                                'updated_at'=>date('Y-m-d'),
                                'created_at' => date('Y-m-d'),
                                'updated_by'=>\Yii::$app->user->identity->username,
                                'status' => 'Active',
                            ])->execute(); 
                       
                            $connection->createCommand()->insert('transactions',
                            [
                                'transaction_id' => $transaction_model->transaction_id,
                                'branch_id' => Yii::$app->user->identity->branch_id,
                                'type' => 'Cash Payment',
                                'narration' => $model->narration,
                                'debit_account' => $model->debit_account,
                                'amount' => $remaning,
                                'credit_account' => $model_head->id,
                                'transactions_date' => $model->transactions_date,
                                'created_by' => \Yii::$app->user->identity->id,
                            ])->execute();
                        }
                    }      
                }else{
                    $remaning = $model->debit_amount + $model->prev_remaning;
                    $amount = $remaning - $model->credit_amount;
                            
                    $connection->createCommand()->update('account_payable',
                    [
                        'branch_id' => Yii::$app->user->identity->branch_id,
                        'amount'=>$amount,
                        'narration' => $model->payable_narration,
                        'updated_at'=>date('Y-m-d h:m:s'),
                        'updated_by'=>\Yii::$app->user->identity->username,
                    ],
                    ['account_payable'=>$model->debit_account])->execute();
                            
                    $connection->createCommand()->insert('transactions',
                    [
                        'branch_id' => Yii::$app->user->identity->branch_id,
                        'type' => $model->type,
                        'narration' => $model->narration,
                        'debit_account' => $model->debit_account,
                        'amount' => $model->credit_amount,
                        'credit_account' => $model->credit_account,
                        'transactions_date' => $model->transactions_date,
                        'created_by' => \Yii::$app->user->identity->id,
                    ])->execute();     
                } 

                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'accountpayable' => $accountpayable,
                ]);
        }
    }


    public function actionDailyReport()
    {
        $model = new Transactions();
        return $this->render('daily-report',[
            'model' => $model,
        ]);
    }
    public function actionMonthlyReport()
    {
        $model = new Transactions();
        return $this->render('monthly-report',[
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Payment model.
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
                    'title'=> "Update Payment #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Payment #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Payment #".$id,
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Payment model.
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
     * Delete multiple existing Payment model.
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
