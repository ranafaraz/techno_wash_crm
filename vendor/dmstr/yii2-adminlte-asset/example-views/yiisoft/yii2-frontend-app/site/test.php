<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Users;
use common\models\Branches;


//$this->title = 'Signup';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2 class="well well-sm" style="font-family: georgia;text-align: center;background-color:#367FA9;color:white;border-radius:5px;">
                Signup Form
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-primary" style="box-shadow:0px 10px 10px 0px #367FA9;">
                <div class="box-body">
                    <h3 style="color:#367FA9;margin-top:0px;margin-bottom:0px;text-align: center;">Please fill out the following fields to signup</h3><hr style="border:1px dashed #367FA9;">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'last_name')->textInput() ?>
                                    </div>
                                    <div class="col-md-4">
                                         <?= $form->field($model, 'username')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '99999-9999999-9', ]) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'email') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'password')->passwordInput() ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'user_photo')->fileInput(['maxlength' => true, 'class' => 'btn btn-default btn-block paperclip']) ?>
                                    </div> 
                                </div>

                                <div class="form-group">
                                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary glyphicon glyphicon-save', 'name' => 'signup-button']) ?>
                                
                                <a href="./login" class="btn btn-info">
                                   <i class="glyphicon glyphicon-backward"></i> Back
                                </a>
                                </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div> 
             <!-- box close -->
         </div>
     </div>
</div>
