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
<style type="text/css">
    .imgee{
        background-image:url('images/background.jpeg');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<div class="imgee">
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default"  style="margin-top:10px;margin-left:10px;">
            <div class="panel-heading">
                Login Credential
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr.#</th>
                            <th>User Name</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>98776-7888887-6</td>
                            <td>123456</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="login-box" style="margin-top: 30px; background-color: #183663; margin: 10px auto; color: white;">
    <div class="login-logo" style="padding-top: 20px">
        <a href="#" style="color: white; border-bottom: 2px solid #28C0CE;"><b>DEXDEVS</b><small> - IC</small></a>
        <p style="font-size: 20px;">INSTITUTE ON CLOUD</p>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style=" border-top: 3px solid #1A3562;">
        <img src="images/cloudlogo1.png" width="320px" height="200px" style="border: 1px solid #28C0CE; border-radius: 5px 25px 5px 25px; padding:10px"><br>
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
            <div class="col-xs-4">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="col-xs-4">
                <span >
                    <?= Html::a(' Reset Password', ['site/request-password-reset'],
                        ['title'=> 'Click here to reset password','class'=>'btn btn-warning btn-sm fa fa-key'])
                    ?>
                </span>
            </div>
            <div class="col-md-4">
                <span>
                    <a href="./" class="btn btn-primary btn-sm">
                        Sign-up
                    </a>
                </span>
            </div>
        </div>

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-success btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <!-- <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div> -->
        <!-- /.social-auth-links -->

<!--         <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> -->

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
    </div>
</div>

</div>