<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<?php Yii::$app->session->getFlash('key', 'message'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8" style="padding:0px;margin-top:45px;">
            <img src="images/dexdevs2_photo.png" style="border-radius: 5px;display:block;margin-left:auto;margin-right:auto;width:40%;margin-top:100px;"><br>
            <p style="text-align: center;font-size:20px"><b>Dexterous Developers</b></p>
            <p style="text-align: center;">Next Big Thing in Software Development</p>
        </div>
        <div class="col-md-4" style="border-left:3px solid #FAB61C;margin-top:35px;">
            <div class="login-box" style="padding:2px; background-color:black;color: white;border-top:3px solid #FAB61C;">
        <div class="login-logo" style="padding-top: 10px;">
            <a href="#" style="color: #FAB61C; border-bottom: 2px solid #28C0CE;font-size:20px;"><b>TECHNO<span style="color:white;">WASH</span></b><b> - TW</b></a>
            <p style="font-size: 20px;color:white;">Powered By: DEXDEVS</p>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" style=" border-top: 3px solid #1A3562;">
            <div class="row">
                <div class="col-md-12">
                    <img src="images/dexdevs2_photo.png" style="border:2px solid #FAB61C; border-radius: 5px;box-shadow:0px 0px 20px 0px #FAB61C;display:block;margin-left:auto;margin-right:auto;width:40%;"><br>
                </div>
            </div>
            <p class="login-box-msg" style="color: #183663;"><b>Sign in to start your session</b></p>



            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

            <?= $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <div class="col-xs-6">
                    <span style="float: right;">
                        <?= Html::a(' Reset Password', ['../site/request-password-reset'],
                            ['title'=> 'Click here to reset password','class'=>'btn btn-warning btn-sm fa fa-key'])
                        ?>
                    </span>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-12" style="padding-bottom:10px;">
                    <a href="passwords" style="float: right;padding:5px;" class="label label-info">View Users</a>
                </div><br>
            </div> -->

            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12">
                    <?= Html::submitButton('Sign in', ['class' => 'btn btn-success btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>


            <?php ActiveForm::end(); ?>
            </div>
        <!-- /.login-box-body -->
            </div><!-- /.login-box -->
            </div>
    </div>
</div>
