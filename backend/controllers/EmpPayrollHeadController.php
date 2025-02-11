<?php

namespace backend\controllers;

use Yii;
use common\models\EmpPayrollHead;
use common\models\EmpPayrollDetail;
use common\models\EmpPayrollHeadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\helpers\Json;
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
use common\models\Employee;

/**
 * EmpPayrollHeadController implements the CRUD actions for EmpPayrollHead model.
 */
class EmpPayrollHeadController extends Controller
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
                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete', 'bulk-delete','calculate-pay','calculate-advance-pay','advance-payroll'],
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
     * Lists all EmpPayrollHead models.
     * @return mixed
     */
      public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {    
        $searchModel = new EmpPayrollHeadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAdvancePayroll()
    {
        return $this->render('advance-payroll');
    }
    public function actionCalculateAdvancePay($emp_id)
    {
        $empData = Yii::$app->db->createCommand("
        SELECT *
        FROM employee
        WHERE emp_id = $emp_id
        ")->queryAll();
        $monthlySalary   = $empData[0]['monthly_salary'];

        return Json::encode($monthlySalary);

    }
     public function actionCalculatePay($pay_month, $emp_id)
    {  

       $empData = Yii::$app->db->createCommand("
        SELECT *
        FROM employee
        WHERE emp_id = $emp_id
        ")->queryAll();
       $monthlySalary   = $empData[0]['monthly_salary'];
       $dutyTimeStart   = $empData[0]['duty_time_start'];
       $dutyTimeEnd     = $empData[0]['duty_time_end'];
       $workingHours    = $empData[0]['working_hours'];

       $monthArr = explode('-', $pay_month);

       $days_in_month = cal_days_in_month(CAL_GREGORIAN,$monthArr[0],$monthArr[1]);
       $workdays=0;
       for ($i = 1; $i <= $days_in_month; $i++) {

            $date = $monthArr[1].'/'.$monthArr[0].'/'.$i; //format date
            $get_name = date('l', strtotime($date)); //get week day
            $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

            //if not a weekend add day to array
            if($day_name != 'Sun'){
                $workdays++;
            }

        }

       $salaryPerDay    = $monthlySalary/$workdays;
       $salaryPerHour   = $salaryPerDay/$workingHours;
       $salaryPerMinute = $salaryPerHour/60;


       $empAttendance = Yii::$app->db->createCommand("
        SELECT *
        FROM emp_attendance
        WHERE emp_id = $emp_id
        AND MONTH(att_date)= '$monthArr[0]'
        AND YEAR(att_date)='$monthArr[1]'
        AND (attendance = 'P'
        OR attendance = 'L'
        OR attendance = 'H')
        ")->queryAll();

       $workingMints =0;
       $add = 0;
       $overTime = 0;
       foreach ($empAttendance as $key => $value) {
            $checkIn  = strtotime($value['check_in']);
            $checkOut = strtotime($value['check_out']);

            $hours = round(abs($checkOut - $checkIn) / 3600);
            $mints = round(abs($checkOut - $checkIn) / 60,2);
            $workingMints += $mints;
            if( $hours != 0){
                $overTime += $hours - $workingHours;  
            }
        }
        $overTimePay = round($overTime * $salaryPerHour);
        
        $totalCalculatedPay = round($salaryPerMinute * $workingMints);
        $paymentArray =  array();
        $empData = Yii::$app->db->createCommand("
        SELECT *
        FROM emp_payroll_head
        WHERE emp_id = $emp_id
        AND payment_month = '$monthArr[0]'
        AND payment_year = '$monthArr[1]'
        ")->queryAll();
        if (!empty($empData)){
            $paidAmount = $empData[0]['paid_amount'];
            $paidStatus = $empData[0]['status'];
            $paymentArray[0] = $totalCalculatedPay;
            $paymentArray[1] = $paidAmount;
            $paymentArray[2] = $paidStatus;
            $paymentArray[3] = $empData[0]['net_total'];
            $paymentArray[4] = $overTime;
            $paymentArray[5] = $overTimePay;
        }
        else
        {
            $paymentArray[0] = $totalCalculatedPay;
            $paymentArray[1] = $overTime;
            $paymentArray[2] = $overTimePay;
        }
        

        return Json::encode($paymentArray);
        
    }


    /**
     * Displays a single EmpPayrollHead model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "EmpPayrollHead #".$id,
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
     * Creates a new EmpPayrollHead model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new EmpPayrollHead();
        $payrollDetail = new EmpPayrollDetail();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new EmpPayrollHead",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','id'=>'insert' ,'type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())){
                $emp_id = $model->emp_id;
                $payment_date = $model->payment_month;
                $payment_explode = explode('-',$payment_date,2);
                $payment_month = $payment_explode[0];
                $payment_year = $payment_explode[1];

                $empData = Yii::$app->db->createCommand("
                SELECT *
                FROM emp_payroll_head
                WHERE emp_id = $emp_id
                AND payment_month = '$payment_month'
                ")->queryAll();

                if(empty($empData)){
                    //$model->customer_registration_date   = new \yii\db\Expression('NOW()');
                    $model->payment_month = $payment_month; 
                    $model->payment_year = $payment_year; 
                    $model->branch_id = Yii::$app->user->identity->branch_id; 
                    $model->created_by = Yii::$app->user->identity->id; 
                    $model->created_at = new \yii\db\Expression('NOW()');
                    $model->updated_by = '0';
                    $model->updated_at = '0';
                    $model->save();

                    $payrollDetail->payroll_head_id = $model->payroll_head_id;
                    $payrollDetail->transaction_date = new \yii\db\Expression('NOW()');
                    $payrollDetail->paid_amount = $model->paid_amount;
                    $payrollDetail->status = $model->status;
                    $payrollDetail->save();

                } else {
                    $payroll_head_id = $empData[0]['payroll_head_id'];
                    $prev_paid_amount = $empData[0]['paid_amount'];
                    $net_total = $empData[0]['net_total'];
                    $paid = $prev_paid_amount + $model->paid_amount;
                    $remaining = $net_total-$paid;

                    $payrollHeadUpdate = Yii::$app->db->createCommand()->update('emp_payroll_head',[

                     'paid_amount'  => $paid,
                     'remaining'   => $remaining,
                     'status'       => $model->status,
                    ],
                       ['payroll_head_id' => $payroll_head_id,'emp_id' => $emp_id ]

                    )->execute();

                    $payrollDetail->payroll_head_id = $payroll_head_id;
                    $payrollDetail->transaction_date = new \yii\db\Expression('NOW()');
                    $payrollDetail->paid_amount = $model->paid_amount;
                    $payrollDetail->status = $model->status;
                    $payrollDetail->save();
                }
      
            // getting current asset from Account Nature and cash debit account from account head;
            $nature = AccountNature::find()->where(['name' => 'Asset'])->One();
            $nature1 = AccountNature::find()->where(['name' => 'Expense'])->One();
            $cred = AccountHead::find()->where(['nature_id' => $nature->id])->andwhere(['account_name' => 'Cash'])->One();
            $head = AccountHead::find()->where(['nature_id' => $nature1->id])->andwhere(['account_name' => 'Salaries'])->One();
            $emplo = Employee::find()->where(['emp_id' => $model->emp_id])->One();
            Yii::$app->db->createCommand()->insert('transactions',
            [
              'branch_id' => Yii::$app->user->identity->branch_id,
              'type' => 'Cash Payment',
              'narration' => 'Employee Salary Paid to <b>'.$emplo->emp_name.'</b> Rs <b>'.$model->paid_amount.'</b> for the month <b>'. $payment_month .'-'.$payment_year.'</b> ',
              'debit_account' => $head->id,
              'credit_account' => $cred->id,
              'amount' => $model->paid_amount,
              'transactions_date' => date('Y-m-d'),
              'ref_no' => $model->emp_id,
              'ref_name' => "Employee",
              'created_by' => \Yii::$app->user->identity->id,
              
            ])->execute();
                    
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new EmpPayrollHead",
                    'content'=>'<span class="text-success">Create EmpPayrollHead success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new EmpPayrollHead",
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
                return $this->redirect(['view', 'id' => $model->payroll_head_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing EmpPayrollHead model.
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
                    'title'=> "Update EmpPayrollHead #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','id'=>'insert','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "EmpPayrollHead #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update EmpPayrollHead #".$id,
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
                return $this->redirect(['view', 'id' => $model->payroll_head_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing EmpPayrollHead model.
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
     * Delete multiple existing EmpPayrollHead model.
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
     * Finds the EmpPayrollHead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpPayrollHead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpPayrollHead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
