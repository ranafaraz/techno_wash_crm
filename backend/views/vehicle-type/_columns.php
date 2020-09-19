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
    //     'attribute'=>'vehical_type_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'name',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'width' => '170px',
        'headerOptions' => [
            // this should be on a CSS file as class instead of a inline style attribute...
            'style' => 'text-align: center !important;vertical-align: middle !important'
        ],
        'format' => 'raw',
        'value' => function($model, $key, $index, $column) {
                        if (empty($model->vehical_type_id) || empty($model->vehical_type_id)) {
                            return;
                        }
                        return Html::a($model->name, [ './vehicle-type-view','id' => $model->vehical_type_id ], ['id' => $model->vehical_type_id , 'target' => '_self','style'=>'color:white;', 'data' => ['pjax' => 0]] );
                    },
        'contentOptions' => function ($model, $key, $index, $column) {
        return ['class' => 'text-center','style' => 'background-color:' 
            . (!empty($model->vehical_type_id) && $model->vehical_type_id / $model->vehical_type_id < 2
                ? '#72B6DE' : 'black')];
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'created_by',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'updated_by',
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