<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VehicleTypeSubCategory */

?>
<div class="vehicle-type-sub-category-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelVTSCH' => $modelVTSCH,
    ]) ?>
</div>
