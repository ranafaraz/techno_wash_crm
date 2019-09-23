<?php
use yii\helpers\Url;

use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'customer_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'branch_id',
        'value'=>'branch.branch_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'customer_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'customer_name',
        'width' => '170px',
        'headerOptions' => [
            // this should be on a CSS file as class instead of a inline style attribute...
            'style' => 'text-align: center !important;vertical-align: middle !important'
        ],
        'format' => 'raw',
        'value' => function($model, $key, $index, $column) {
                        if (empty($model->customer_id) || empty($model->customer_id)) {
                            return;
                        }
                        return Html::a($model->customer_name, [ './customer-invoice-lists','customer_id' => $model->customer_id ], ['id' => $model->customer_id , 'target' => '_self', 'data' => ['pjax' => 0]] );
                    },
        'contentOptions' => function ($model, $key, $index, $column) {
        return ['class' => 'text-center','style' => 'background-color:' 
            . (!empty($model->customer_id) && $model->customer_id / $model->customer_id < 2
                ? '#c1efba' : 'black')];
        },
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'customer_gender',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'customer_cnic',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_address',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_contact_no',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_registration_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_age',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_email',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_image',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_occupation',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   