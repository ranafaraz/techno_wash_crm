<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Employee */

?>
<div class="employee-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelEmpAcademy'=>(empty($modelEmpAcademy)) ? [new EmpAcademic] : $modelEmpAcademy,
        'modelEmpCertificate'=>(empty($modelEmpCertificate)) ? [new EmpCertification] : $modelEmpCertificate,
    ]) ?>
</div>
