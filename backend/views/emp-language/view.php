<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpLanguage */
?>
<div class="emp-language-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_lang_id',
            'emp_id',
            'emp_language',
            'lang_read',
            'lang_wirte',
            'lang_speak',
            'lang_remarks',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
