<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','premium-version','user-profile', 'request-password-reset','car-wash-details','credit-sale-invoices','under-construction','payroll-month-report', 'expense-report', 'income-report', 'income-expense-report'],
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
        //throw new NotFoundHttpException("Something unexpected happened");
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
     public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionCreditSaleInvoices()
    {
        return $this->render('credit-sale-invoices');
    } 
    public function actionCarWashDetails()
    {
        return $this->render('car-wash-details');
    }
    public function actionExpenseReport()
    {
        return $this->render('expense-report');
    }
    public function actionIncomeReport()
    {
        return $this->render('income-report');
    }
    public function actionIncomeExpenseReport()
    {
        return $this->render('income-expense-report');
    }
    public function actionUnderConstruction()
    {
        return $this->render('under-construction');
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
     public function actionUserProfile()
    {
        return $this->render('user-profile');
    }
    // Rounte for Payroll report
    public function actionPayrollMonthReport(){
        return $this->render('payroll-month-report');
    }
    /**
     * Login action.
     *
     * @return string
     */

    public function actionLogin()
    {
        // if (!Yii::$app->user->isGuest) {
        // return $this->goHome();
        // }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (\Yii::$app->user->can('login')){
                // yes he is Admin, so redirect page 
                Yii::$app->session->setFlash('success', 'Dear '.$model->username.', Welcome to Admin Panel.');
                return $this->goBack();
            }
            else { // if he is not an Admin then what :P
                   // put him out :P Automatically logout. 
                //Yii::$app->user->logout();
                // set error on login page. 
                Yii::$app->session->setFlash('error', 'You are not authorized to login Admin\'s penal.<br /> Please use valid Username & Password.<br />Please contact Administrator for details.');
                //redirect again page to login form.
                return $this->redirect(['login']);
                }  
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
    // actionSendSms.....
    public function actionSendSms()
    {
        return $this->render('send-sms');
    }
    public function actionPremiumVersion()
    {
        return $this->render('premium-version');
    } 

}