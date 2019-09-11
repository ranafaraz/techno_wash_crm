<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WageType */
?>
<div class="wage-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'wage_type_id',
            'branch_id',
            'wage_name',
            'basic_pay',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
