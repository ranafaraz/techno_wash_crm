<?php

namespace backend\controllers;

use Yii;
use common\models\EmpAttendance;
use common\models\EmpAttendanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * EmpAttendanceController implements the CRUD actions for EmpAttendance model.
 */
class EmpAttenController extends Controller
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
                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete', 'bulk-delete','emp-att-report','employess-att-report','final-attendance','fetch-cnic'],
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
    
     public function actionFetchCnic()
    { 
        return $this->render('fetch-cnic');
    }
      public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
     public function actionEmpAttReport()
    { 
        return $this->render('emp-att-report');
    }
     public function actionEmployessAttReport()
    { 
        return $this->render('employess-att-report');
    }
     public function actionFinalAttendance()
    { 
        return $this->render('final-attendance');
    }
    /**
     * Lists all EmpAttendance models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new EmpAttendanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single EmpAttendance model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "View Employee Attendance",
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
     * Creates a new EmpAttendance model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new EmpAttendance();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new EmpAttendance",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                    $branch_id = Yii::$app->user->identity->branch_id;
                    $cnic = $model->emp_cnic;
                    $check_in = $model->check_in;
                    $emp_id = Yii::$app->db->createCommand("SELECT emp_id FROM emp_info WHERE emp_cnic = '$cnic'")->queryAll();
                    $date = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
                    $empId = $emp_id[0]['emp_id'];

                    if($check_in == 0){

                        $emp_att = Yii::$app->db->createCommand("SELECT emp_id FROM emp_attendance WHERE emp_id = '$empId' AND att_date = '$date' AND branch_id = '$branch_id' ")->queryAll();
                        
                        if(!empty($emp_att)){
                            Yii::$app->session->setFlash('warning',"You have already checked in..!");
                        } else {
                            $model->branch_id = $branch_id;
                            $model->emp_id = $empId;
                            $model->att_date = $date;
                            $model->check_in = new \yii\db\Expression('NOW()');
                            $model->attendance = "P";
                            $model->created_by = Yii::$app->user->identity->id; 
                            $model->created_at = new \yii\db\Expression('NOW()');
                            $model->updated_by = '0';
                            $model->updated_at = '0';
                            $model->save();
                        }
                    }

                    if($check_in == 1){
                        $emp_att = Yii::$app->db->createCommand("SELECT check_in FROM emp_attendance WHERE emp_id = '$empId' AND att_date = '$date'  AND branch_id = '$branch_id' ")->queryAll();

                        if(empty($emp_att)){
                            Yii::$app->session->setFlash('warning',"You are not checked in yet..!");
                        } else {
                            $att = Yii::$app->db->createCommand()->update('emp_attendance', [
                                'check_out'=> new \yii\db\Expression('NOW()'),
                                'updated_at'    => new \yii\db\Expression('NOW()'),
                                'updated_by'    => Yii::$app->user->identity->id,
                                ],

                                ['emp_id' => $emp_id, 'att_date' => "$date", 'branch_id' => $branch_id]

                            )->execute();
                        }
                    }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new EmpAttendance",
                    'content'=>'<span class="text-success">Create EmpAttendance success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];         
            }else{           
                return [
                    'title'=> "Create new EmpAttendance",
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
            if($model->load($request->post())) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $branch_id = Yii::$app->user->identity->branch_id;
                    $cnic = $model->emp_cnic;
                    $check_in = $model->check_in;
                    $emp_id = Yii::$app->db->createCommand("SELECT emp_id, emp_name FROM emp_info WHERE emp_cnic = '$cnic'")->queryAll();

                    if(empty($emp_id)){
                        return $this->redirect(['emp-attendance/create', Yii::$app->session->setFlash('warning',"Sorry! Employee against CNIC: ".$cnic." is not exist...")]);
                    } else {
                        $date = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
                        $empId = $emp_id[0]['emp_id'];
                        $empName = $emp_id[0]['emp_name'];

                        if($check_in == 0){

                            $emp_att = Yii::$app->db->createCommand("SELECT emp_id FROM emp_attendance WHERE emp_id = '$empId' AND att_date = '$date' AND branch_id = '$branch_id' ")->queryAll();
                            
                            if(!empty($emp_att)){
                                return $this->redirect(['emp-attendance/create', Yii::$app->session->setFlash('warning', "Employee: ".$empName." | CNIC: ".$cnic." is Already Checked in...")]);
                            } else {
                                $model->branch_id = $branch_id;
                                $model->emp_id = $empId;
                                $model->att_date = $date;
                                $model->check_in = new \yii\db\Expression('NOW()');
                                $model->attendance = "P";
                                $model->created_by = Yii::$app->user->identity->id; 
                                $model->created_at = new \yii\db\Expression('NOW()');
                                $model->updated_by = '0';
                                $model->updated_at = '0';
                                $model->save();

                                $transaction->commit();
                                return $this->redirect(['emp-attendance/create', Yii::$app->session->setFlash('success', "Employee: ".$empName." | CNIC: ".$cnic." Successfully Checked in...")]);
                            } // closing of if(!empty($emp_att))
                        } // closing of if($check_in == 0)
                    } // closing of if(empty($emp_id))
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "Transaction Failed, Try Again...!");
                }

                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if($check_in == 1){
                        $emp_att = Yii::$app->db->createCommand("SELECT check_in FROM emp_attendance WHERE emp_id = '$empId' AND att_date = '$date'  AND branch_id = '$branch_id' ")->queryAll();

                        if(empty($emp_att)){
                            return $this->redirect(['emp-attendance/create', Yii::$app->session->setFlash('warning', "Employee: ".$empName." | CNIC: ".$cnic." is not Checked in yet...")]);
                        } else {
                             $emp_checkOut = Yii::$app->db->createCommand("SELECT check_out FROM emp_attendance WHERE emp_id = '$empId' AND att_date = '$date'  AND branch_id = '$branch_id' ")->queryAll();
                            if(!empty($emp_checkOut)){
                                return $this->redirect(['emp-attendance/create', Yii::$app->session->setFlash('warning', "Employee: ".$empName." | CNIC: ".$cnic." is Already Checked out...")]);
                            } else {
                                $att = Yii::$app->db->createCommand()->update('emp_attendance', [
                                    'check_out'=> new \yii\db\Expression('NOW()'),
                                    'updated_at'    => new \yii\db\Expression('NOW()'),
                                    'updated_by'    => Yii::$app->user->identity->id,
                                    ],

                                    ['emp_id' => $emp_id, 'att_date' => "$date", 'branch_id' => $branch_id]

                                )->execute();
                                if($att){
                                    $transaction->commit();
                                }
                                return $this->redirect(['emp-attendance/create', Yii::$app->session->setFlash('success', "Employee: ".$empName." | CNIC: ".$cnic." Successfully Checked out...")]);
                            } // closing of if(!empty($emp_checkOut))
                        } // closing of if(empty($emp_att))  
                    } // closing of if($check_in == 1)
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "Transaction Failed, Try Again...!");
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }   
    }

    /**
     * Updates an existing EmpAttendance model.
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
                    'title'=> "Update Employee Attendance",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->updated_at = new \yii\db\Expression('NOW()');
                    $model->created_by = $model->created_by;
                    $model->created_at = $model->created_at;
                    $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "EmpAttendance #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update EmpAttendance #".$id,
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
                return $this->redirect(['view', 'id' => $model->att_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing EmpAttendance model.
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
     * Delete multiple existing EmpAttendance model.
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
     * Finds the EmpAttendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpAttendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpAttendance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
