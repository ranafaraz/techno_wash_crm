<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserType */
?>
<div class="user-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_type_id',
            'name',
            'description',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
