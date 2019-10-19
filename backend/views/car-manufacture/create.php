<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CarManufacture */

?>
<div class="car-manufacture-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelCar' => $modelCar,
    ]) ?>
</div>
