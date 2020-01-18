<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CustomerVehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sale Invoice';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="customer-vehicles-index">
    <div id="ajaxCrudDatatable">
        <!-- <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['./customer/create'],
                    ['role'=>'modal-remote','title'=> 'Create new Customer Vehicles','class'=>'btn btn-success']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-warning', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Sale Invoice listing',
                'before'=>'<em><b  style="color:red;font-size:16px;font-family:georgia;">* Click On Customer Name To Initiate Sale Invoice.</b></em>',
                // 'after'=>BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'Are you sure?',
                //                     'data-confirm-message'=>'Are you sure want to delete this item'
                //                 ]),
                //         ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?> -->

        <!-- <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'pjax' => true,
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add Customer', ['./customer/create'],
                    ['role'=>'modal-remote','title'=> 'Create new Customer Vehicles','class'=>'btn btn-success']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-warning', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],  
            'striped' => true,
            'hover' => true,
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-stats"></i> Sales Invoice', 
                'before'=>'<em><b  style="color:red;font-size:16px;font-family:georgia;">* Click On Registration No. To Initiate Sale Invoice.</b></em>',
            ],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                
                [
                    'attribute' => 'Customer Name', 
                    'value' => 'customer.customer_name',
                    'width' => '50px',
                    'headerOptions' => [
                        // this should be on a CSS file as class instead of a inline style attribute...
                        'style' => 'text-align: center !important;vertical-align: middle !important; color: #337AB7'
                    ],
                    'group' => true,  // enable grouping
                    'subGroupOf' => 1 // supplier column index is the parent group
                ],
                [
                     'attribute' => 'customer_id', 
                    'value' => 'customer.customer_contact_no',
                ],
                [
                    'attribute' => 'registration_no',
                    'width' => '750px',
                    'format' => 'raw',
                    'value' => function($model, $key, $index, $column) {
                        if (empty($model->registration_no) || empty($model->registration_no)) {
                            return;
                        }
                        return Html::a($model->registration_no, [ './sale-invoice-view','customer_id' => $model->customer_id , 'regno' => $model->customer_vehicle_id], ['id' => $model->customer_id , 'target' => '_blank','style'=>'color:white;', 'data' => ['pjax' => 0]] 
                        );
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                    return ['class' => '','style' => 'background-color:' 
                        . (!empty($model->customer_id) && $model->customer_id / $model->customer_id < 2
                            ? '#3C8DBC' : 'black')];
                    },
                ],
            ],
        ]);

        ?> -->
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showPageSummary' => true,
                'pjax' => true,
                'toolbar'=> [
                            ['content'=>
                                Html::a('<i class="glyphicon glyphicon-plus"></i> Add Customer', ['./customer/create'],
                                ['role'=>'modal-remote','title'=> 'Create new Customer Vehicles','class'=>'btn btn-success']).
                                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                                ['data-pjax'=>1, 'class'=>'btn btn-warning', 'title'=>'Reset Grid']).
                                '{toggleData}'.
                                '{export}'
                            ],
                        ],
                'striped' => true,
                'hover' => true,
                'panel' => [
                            'type' => 'default', 
                            'heading' => '<i class="glyphicon glyphicon-stats"></i> Sales Invoice', 
                            'before'=>'<em><b  style="color:red;font-size:16px;font-family:georgia;">* Click On Registration No. To Initiate Sale Invoice.</b></em>',
                        ],
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'Customer Name', 
                                'value' => 'customer.customer_name',
                                'width' => '50px',
                                'headerOptions' => [
                                    // this should be on a CSS file as class instead of a inline style attribute...
                                    'style' => 'text-align: center !important;vertical-align: middle !important; color: #337AB7'
                                ],
                        // 'value' => function ($model, $key, $index, $widget) { 
                        //     return $model->supplier->company_name;
                        // },
                        // 'filterType' => GridView::FILTER_SELECT2,
                        // 'filter' => ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
                        // 'filterWidgetOptions' => [
                        //     'pluginOptions' => ['allowClear' => true],
                        // ],
                        //'filterInputOptions' => ['placeholder' => 'Any supplier'],
                        'group' => true,  // enable grouping
                    ],
                    [
                        'attribute' => 'customer_id', 
                        'value' => 'customer.customer_contact_no', 
                        'width' => '250px',
                        // 'value' => function ($model, $key, $index, $widget) { 
                        //     return $model->category->category_name;
                        // },
                        // 'filterType' => GridView::FILTER_SELECT2,
                        // 'filter' => ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
                        // 'filterWidgetOptions' => [
                        //     'pluginOptions' => ['allowClear' => true],
                        // ],
                        // 'filterInputOptions' => ['placeholder' => 'Any category'],
                        'group' => true,  // enable grouping
                        'subGroupOf' => 1 // supplier column index is the parent group
                    ],
                    [
                        'attribute' => 'registration_no',
                        'width' => '750px',
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $column) {
                            if (empty($model->registration_no) || empty($model->registration_no)) {
                                return;
                            }
                            return Html::a($model->registration_no, [ './sale-invoice-view','customer_id' => $model->customer_id , 'regno' => $model->customer_vehicle_id], ['id' => $model->customer_id , 'target' => '_blank','style'=>'color:white;', 'data' => ['pjax' => 0]] 
                            );
                        },
                        'contentOptions' => function ($model, $key, $index, $column) {
                        return ['class' => '','style' => 'background-color:' 
                            . (!empty($model->customer_id) && $model->customer_id / $model->customer_id < 2
                                ? '#3C8DBC' : 'black')];
                        },
                    ],
                ],
            ]);
        ?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "size"=>"modal-lg",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
