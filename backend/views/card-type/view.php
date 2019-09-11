<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CardType */
?>
<div class="card-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'card_type_id',
            'card_name',
            'card_description:ntext',
            'card_price',
            'card_services',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
