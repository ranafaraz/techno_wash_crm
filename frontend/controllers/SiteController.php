<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\StdGuardianInfo;
use common\models\StdIceInfo;
use common\models\StdAcademicInfo;
use common\models\StdRegistration;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout','login', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login','signup','test', 'error', 'request-password-reset','reset-password'],
                        'allow' => true,
                        //'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','signup','test','index','employe-dashboard','employee-portfolio','students-view','students-list','view-classes','view-datesheet','activity-view','list-of-classes','std-profile','std-fee','std-fee-details','std-exams','std-exam-schedule','std-exam-result','children', 'executive-portal', 'income-expense', 'balance-sheet', 'std-attendance-report', 'emp-attendance-report', 'premium-version','fee-details','reset-password','user-profile','update-profile','std-remarks','next','emp-attendance','online-admissions','edit-profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // public function actionTest()
    // { 
    //     //return $this->render('test');
    //     $request = Yii::$app->request;
    //     $model = new SignupForm();
    //     $StdRegistration = new StdRegistration();
    //     $stdGuardianInfo = new StdGuardianInfo();
    //     $stdIceInfo = new StdIceInfo();
    //     $stdAcademicInfo = new StdAcademicInfo();

    //     if ($model->load($request->post()) && $model->validate()) {
            
    //         $model->user_type = 'Inquiry';
    //         $model->branch_id = 5;
    //         $model->user_photo = UploadedFile::getInstance($model,'user_photo');
    //         if(!empty($model->user_photo)){
    //             $imageName = $model->username.'_photo'; 
    //             $model->user_photo->saveAs('userphotos/'.$imageName.'.'.$model->user_photo->extension);
    //             $model->user_photo->saveAs('./admin/userphotos/'.$imageName.'.'.$model->user_photo->extension);
    //             //save the path in the db column
    //             $model->user_photo = 'userphotos/'.$imageName.'.'.$model->user_photo->extension;
    //         } else {
    //            $model->user_photo = '0'; 
    //         }
    //         if ($user = $model->signup()) {
    //             // if (Yii::$app->getUser()->login($user)) {
    //             //     return $this->goHome();
    //             // }
    //             $user->save();

    //             $StdRegistration->std_name = $model->first_name;
    //             $StdRegistration->std_b_form = $model->username;
    //             $StdRegistration->std_photo = $model->user_photo;
    //             $StdRegistration->std_email = $model->email;
    //             $StdRegistration->admission_date = new \yii\db\Expression('NOW()');
    //             //$StdRegistration->created_by = Yii::$app->user->identity->id; 
    //             $StdRegistration->created_at = new \yii\db\Expression('NOW()');
    //             $StdRegistration->updated_by = '0'; 
    //             $StdRegistration->updated_at = '0';
    //             $StdRegistration->save();

    //             $stdGuardianInfo->std_id = $StdRegistration->std_id; 
    //             $stdGuardianInfo->created_at = new \yii\db\Expression('NOW()');
    //             $stdGuardianInfo->updated_by = '0'; 
    //             $stdGuardianInfo->updated_at = '0';
    //             $stdGuardianInfo->save();

    //             $stdIceInfo->std_id = $StdRegistration->std_id; 
    //             $stdIceInfo->created_at = new \yii\db\Expression('NOW()');
    //             $stdIceInfo->updated_by = '0'; 
    //             $stdIceInfo->updated_at = '0';
    //             $stdIceInfo->save();

    //             $stdAcademicInfo->std_id = $StdRegistration->std_id;
    //             $stdAcademicInfo->created_at = new \yii\db\Expression('NOW()');
    //             $stdAcademicInfo->updated_by = '0'; 
    //             $stdAcademicInfo->updated_at = '0';
    //             $stdAcademicInfo->save();

    //             $login = new LoginForm();

    //             $login->username=$model->username;

    //             $login->password=$model->password;

    //             Yii::$app->session->setFlash('success',"User created successfully");
    //             //Yii::$app->user->login($model);
    //             $login->login();

    //             return $this->redirect(['./employe-dashboard']);
    //         } // closing of signup if 
    //         else {
    //              Yii::$app->session->setFlash('warning',"User not created");
    //         } // closing of else

    //     } // closing of load #model if

    //     return $this->render('test', [
    //         'model' => $model,
    //     ]);
    // } // closing of signup function
    public function actionEditProfile()
    { 
        return $this->render('edit-profile');
    }

     public function actionOnlineAdmissions()
    { 
        return $this->render('online-admissions');
    }


    public function actionEmpAttendance()
    { 
        return $this->render('emp-attendance');
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionExecutivePortal()
    { 
        return $this->render('executive-portal');
    }

    public function actionIncomeExpense()
    { 
        return $this->render('income-expense');
    }

    public function actionBalanceSheet()
    { 
        return $this->render('balance-sheet');
    }

    public function actionStdAttendanceReport()
    { 
        return $this->render('std-attendance-report');
    }

    public function actionEmpAttendanceReport()
    { 
        return $this->render('emp-attendance-report');
    }
    
    public function actionDates()
    { 
        return $this->render('dates');
    }

    public function actionChildren()
    { 
        return $this->render('children');
    }

    public function actionPremiumVersion()
    { 
        return $this->render('premium-version');
    }

    public function actionActivityView()
    { 
        return $this->render('activity-view');
    }

    public function actionStdProfile()
    { 
        return $this->render('std-profile');
    }

    public function actionStdFee()
    { 
        return $this->render('std-fee');
    }

    public function actionFeeDetails()
    { 
        return $this->render('fee-details');
    }

     public function actionStdFeeDetails()
    { 
        return $this->render('std-fee-details');
    }

    public function actionStdExams()
    { 
        return $this->render('std-exams');
    }

    public function actionStdExamSchedule()
    { 
        return $this->render('std-exam-schedule');
    }

    public function actionStdExamResult()
    { 
        return $this->render('std-exam-result');
    }

    public function actionEmployeDashboard()
    {
        return $this->render('employe-dashboard');
    }

    public function actionStudentsView()
    {
        return $this->render('students-view');
    }

     public function actionStudentsList()
    {
        return $this->render('students-list');
    }

    public function actionViewClasses()
    {
        return $this->render('view-classes');
    }

    public function actionEmployeePortfolio()
    {
        return $this->render('employee-portfolio');
    }

    public function actionViewDatesheet()
    { 
        return $this->render('view-datesheet');
    }

    public function actionListOfClasses()
    { 
        return $this->render('list-of-classes');
    }

    public function actionUserProfile()
    { 
        return $this->render('user-profile');
    }

    public function actionUpdateProfile()
    { 
        return $this->render('update-profile');
    }
      public function actionStdRemarks()
    { 
        return $this->render('std-remarks');
    }
      public function actionNext()
    { 
        return $this->render('next');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('employe-dashboard');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_photo = UploadedFile::getInstance($model,'user_photo');
            if(!empty($model->user_photo)){
                $imageName = $model->username.'_photo'; 
                $model->user_photo->saveAs('userphotos/'.$imageName.'.'.$model->user_photo->extension);
                $model->user_photo->saveAs('./admin/userphotos/'.$imageName.'.'.$model->user_photo->extension);
                //save the path in the db column
                $model->user_photo = 'userphotos/'.$imageName.'.'.$model->user_photo->extension;
            } else {
               $model->user_photo = '0'; 
            }
            if ($user = $model->signup()) {
                // if (Yii::$app->getUser()->login($user)) {
                //     return $this->goHome();
                // }
                $user->save();
                Yii::$app->session->setFlash('success',"User created successfully");
                //return $this->redirect(['next', 'id'=> $user->id]);
            } else {
                 Yii::$app->session->setFlash('warning',"User not created");
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
