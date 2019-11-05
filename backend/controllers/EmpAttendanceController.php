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
class EmpAttendanceController extends Controller
{
    /**
     * {@inheritdoc}
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EmpAttendance models.
     * @return mixed
     */

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
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmpAttendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpAttendance();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $branch_id = Yii::$app->user->identity->branch_id;
                $cnic = $model->emp_cnic;
                $emp_id = Yii::$app->db->createCommand("SELECT emp_id, emp_name FROM employee WHERE emp_cnic = '$cnic'")->queryAll();

                if(empty($emp_id)){
                    return $this->redirect(['./emp-atten-create', Yii::$app->session->setFlash('error',"Sorry! Employee against CNIC: ".$cnic." not exist...")]);
                } else {
                    $date = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
                    $empId = $emp_id[0]['emp_id'];
                    $empName = $emp_id[0]['emp_name'];

                    $emp_att = Yii::$app->db->createCommand("SELECT emp_id 
                        FROM emp_attendance 
                        WHERE emp_id = '$empId' 
                        AND att_date = '$date' 
                        AND branch_id = '$branch_id' ")->queryAll();
                    
                    if(empty($emp_att)){
                        $model->branch_id = $branch_id;
                        $model->emp_id = $empId;
                        $model->att_date = new \yii\db\Expression('NOW()');
                        $model->check_in = new \yii\db\Expression('NOW()');
                        $model->attendance = "P";
                        $model->created_by = Yii::$app->user->identity->id; 
                        $model->created_at = new \yii\db\Expression('NOW()');
                        $model->updated_by = '0';
                        $model->updated_at = '0';
                        $model->save();

                        $transaction->commit();
                        return $this->redirect(['./emp-atten-create', Yii::$app->session->setFlash('success', "Employee: ".$empName." | CNIC: ".$cnic." Successfully Checked in...")]);
                    } // closing of if(empty($emp_att))
                    else {
                        $emp_checkOut = Yii::$app->db->createCommand("SELECT check_out FROM emp_attendance WHERE emp_id = '$empId' AND att_date = '$date'  AND branch_id = '$branch_id' ")->queryAll();
                        if($emp_checkOut[0]['check_out'] != NULL){
                            return $this->redirect(['./emp-atten-create', Yii::$app->session->setFlash('warning', "Employee: ".$empName." | CNIC: ".$cnic." is Already Checked out for today...")]);
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
                            return $this->redirect(['./emp-atten-create', Yii::$app->session->setFlash('success', "Employee: ".$empName." | CNIC: ".$cnic." Successfully Checked out...")]);
                        } // closing of if(!empty($emp_checkOut))
                    } // closing of else(empty($emp_att))
                } //else(empty($emp_id))
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "Transaction Failed, Try Again...!");
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmpAttendance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->att_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmpAttendance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
