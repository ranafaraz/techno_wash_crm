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
    //     'attribute'=>'customer_vehicle_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'customer_id',
    //     'value'=>'customer.customer_name',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Customer Name',
        'attribute'=>'customer_id',
        'width' => '170px',
        'headerOptions' => [
            // this should be on a CSS file as class instead of a inline style attribute...
            'style' => ''
        ],
        'format' => 'raw',
        'value' => function($model, $key, $index, $column) {
            $CustmName  = Yii::$app->db->createCommand("
            SELECT customer_name
            FROM customer
            WHERE customer_id = '$model->customer_id'
            ")->queryAll();

                        if (empty($model->customer_id) || empty($model->customer_id)) {
                            return;
                        }
                        return Html::a($CustmName[0]['customer_name'], [ './sale-invoice-view','customer_id' => $model->customer_id ], ['id' => $model->customer_id, 'target' => '_blank','style'=>'color:white;', 'data' => ['pjax' => 0]] 
                    );
        },
        'contentOptions' => function ($model, $key, $index, $column) {
        return ['class' => '','style' => 'background-color:' 
            . (!empty($model->customer_id) && $model->customer_id / $model->customer_id < 2
                ? '#72B6DE' : 'black')];
        },
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'vehicle_typ_sub_id',
    //     'value'=>'vehicleTypSub.name',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'registration_no',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'color',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'image',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
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
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>'Are you sure?',
    //                       'data-confirm-message'=>'Are you sure want to delete this item'], 
    // ],

];   