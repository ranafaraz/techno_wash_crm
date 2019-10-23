    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Employee Computer Course</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items3', // required: css class selector
                'widgetItem' => '.item3', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item3', // css class
                'deleteButton' => '.remove-item3', // css class
                'model' => $modelEmpComputerCourse[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'comp_course_from',  
                    'comp_course_to',
                    'comp_course_detail',
                    'comp_institute',
                ],
            ]); ?>

            <div class="container-items3"><!-- widgetContainer -->
            <?php foreach ($modelEmpComputerCourse as $k => $comp): ?>
                <div class="item3 panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Computer Course Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item3 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item3 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-3">
                                <?= $form->field($comp, "[{$k}]comp_course_from")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($comp, "[{$k}]comp_course_to")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($comp, "[{$k}]comp_course_detail")->textInput() ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($comp, "[{$k}]comp_institute")->textInput() ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>








        <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Employee Training</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items4', // required: css class selector
                'widgetItem' => '.item4', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item4', // css class
                'deleteButton' => '.remove-item4', // css class
                'model' => $modelEmpTraining[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'train_from_date',  
                    'train_to_date',
                    'training_course',
                    'training_institute',
                    'training_certificate',
                ],
            ]); ?>

            <div class="container-items4"><!-- widgetContainer -->
            <?php foreach ($modelEmpTraining as $l => $train): ?>
                <div class="item4 panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Training Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item4 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item4 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($train, "[{$l}]train_from_date")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($train, "[{$l}]train_to_date")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($train, "[{$l}]training_course")->textInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($train, "[{$l}]training_institute")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($train, "[{$l}]training_certificate")->textInput() ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>







        <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Employee Language</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items5', // required: css class selector
                'widgetItem' => '.item5', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item5', // css class
                'deleteButton' => '.remove-item5', // css class
                'model' => $modelEmpLanguage[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'emp_language',  
                    'lang_read',
                    'lang_wirte',
                    'lang_speak',
                    'lang_remarks',
                ],
            ]); ?>

            <div class="container-items5"><!-- widgetContainer -->
            <?php foreach ($modelEmpLanguage as $m => $lang): ?>
                <div class="item5 panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Language Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item5 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item5 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($lang, "[{$m}]emp_language")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($lang, "[{$m}]lang_read")->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($lang, "[{$m}]lang_wirte")->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($lang, "[{$m}]lang_speak")->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, "[{$m}]lang_remarks")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>






        <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Employee Work History</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items6', // required: css class selector
                'widgetItem' => '.item6', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item6', // css class
                'deleteButton' => '.remove-item6', // css class
                'model' => $modelEmpWorkHistory[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'work_from',  
                    'work_to',
                    'name_of_employeer',
                    'position_held',
                    'monthly_gross_salary',
                    'reason_for_leaving',
                ],
            ]); ?>

            <div class="container-items6"><!-- widgetContainer -->
            <?php foreach ($modelEmpWorkHistory as $n => $work): ?>
                <div class="item6 panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Work History Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item6 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item6 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($work, "[{$n}]work_from")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($work, "[{$n}]work_to")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($work, "[{$n}]name_of_employeer")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($work, "[{$n}]position_held")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($work, "[{$n}]monthly_gross_salary")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($work, "[{$n}]reason_for_leaving")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>





        <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Employee Gross Salary</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items7', // required: css class selector
                'widgetItem' => '.item7', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item7', // css class
                'deleteButton' => '.remove-item7', // css class
                'model' => $modelEmpGrossSalary[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'gross_salary',  
                    'bonus',  
                    'car',  
                    'car_fuel',  
                    'car_maintenance',  
                    'retirement_benefits',
                    'others',
                ],
            ]); ?>

            <div class="container-items7"><!-- widgetContainer -->
            <?php foreach ($modelEmpGrossSalary as $o => $sal): ?>
                <div class="item7 panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Gross Salary Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item7 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item7 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-3">
                                 <?= $form->field($sal, "[{$o}]gross_salary")->textInput() ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($sal, "[{$o}]bonus")->textInput() ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($sal, "[{$o}]car")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($sal, "[{$o}]car_fuel")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-sm-3">
                                 <?= $form->field($sal, "[{$o}]car_maintenance")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($sal, "[{$o}]retirement_benefits")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($sal, "[{$o}]others")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>











        <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Employee Refrences</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items8', // required: css class selector
                'widgetItem' => '.item8', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item8', // css class
                'deleteButton' => '.remove-item8', // css class
                'model' => $modelEmpRefrences[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'ref_name',  
                    'ref_address',
                    'ref_occupation',
                    'ref_contact',
                ],
            ]); ?>
ref
            <div class="container-items8"><!-- widgetContainer -->
            <?php foreach ($modelEmpRefrences as $r => $ref): ?>
                <div class="item8 panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Refrence Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item8 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item8 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                         <div class="row">
                            <div class="col-sm-3">
                                 <?= $form->field($ref, "[{$r}]ref_name")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($ref, "[{$r}]ref_address")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($ref, "[{$r}]ref_occupation")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($ref, "[{$r}]ref_contact")->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>

