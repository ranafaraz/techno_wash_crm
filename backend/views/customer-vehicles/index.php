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

        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'pjax' => true,
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
            // ['content'=>
            //         // Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
            //         // ['role'=>'modal-remote','title'=> 'Create new Std Academic Infos','class'=>'btn btn-success']).
            //         // Html::a('<i class="fa fa-money">  Generate Bulk Voucher</i>', ['bulk-voucher'],
            //         // ['role'=>'','title'=> '','class'=>'btn btn-success']).
            //         Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
            //         ['data-pjax'=>1, 'class'=>'btn btn-warning', 'title'=>'Reset Grid']).
            //         '{toggleData}'
            //         //'{export}'
            //     ],
            // ],  
            'striped' => true,
            'hover' => true,
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-stats"></i> Sales Invoice', 
                'before'=>'<em><b  style="color:red;font-size:16px;font-family:georgia;">* Click On Customer Name To Initiate Sale Invoice.</b></em>',
            ],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                // [
                //     'attribute' => 'merit_status', 
                //     'width' => '310px',
                //     // 'value' => function ($model, $key, $index, $widget) { 
                //     //     return $model->supplier->company_name;
                //     // },
                //     // 'filterType' => GridView::FILTER_SELECT2,
                //     // 'filter' => ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
                //     // 'filterWidgetOptions' => [
                //     //     'pluginOptions' => ['allowClear' => true],
                //     // ],
                //     // 'filterInputOptions' => ['placeholder' => 'Any supplier'],
                //     'group' => true,  // enable grouping,
                //     'groupedRow' => true,                    // move grouped column to a single grouped row
                //     'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                //     'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                // ],
                [
                    'attribute' => 'customer_id', 
                    //'value' => 'className.class_name',
                    'width' => '250px',
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
                                    return Html::a($CustmName[0]['customer_name'], [ './sale-invoice-view','customer_id' => $model->customer_id , 'regno' => $model->customer_vehicle_id], ['id' => $model->customer_id , 'target' => '_blank','style'=>'color:black;', 'data' => ['pjax' => 0]] 
                                );
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                    return ['class' => '','style' => 'background-color:' 
                        . (!empty($model->customer_id) && $model->customer_id / $model->customer_id < 2
                            ? '#3C8DBC' : 'black')];
                    },
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
                // [
                //     'attribute' => 'class_name_id',
                //     'pageSummary' => 'Page Summary',
                //     'pageSummaryOptions' => ['class' => 'text-right'],
                // ],
                [
                    'attribute' => 'registration_no',
                    // 'value' => 'std.std_name',
                    // 'width' => '150px',
                    // 'hAlign' => 'right',
                    // 'format' => ['decimal', 2],
                    // 'pageSummary' => true,
                    // 'pageSummaryFunc' => GridView::F_AVG
                ],
                // [
                //     'attribute' => 'obtained_marks',
                //     //'width' => '150px',
                //     //'hAlign' => 'right',
                //     //'format' => ['decimal', 0],z
                //     //'pageSummary' => true
                // ],
                // [
                //     'attribute' => 'total_marks',
                //     //'width' => '150px',
                //     //'hAlign' => 'right',
                //     //'format' => ['decimal', 0],
                //     //'pageSummary' => true
                // ],
                // [
                //     'attribute' => 'percentage',
                //     //'width' => '150px',
                //     //'hAlign' => 'right',
                //     //'format' => ['decimal', 0],
                //     //'pageSummary' => true
                // ],
                // [
                //     'attribute' => 'grades',
                //     //'width' => '150px',
                //     //'hAlign' => 'right',
                //     //'format' => ['decimal', 0],
                //     //'pageSummary' => true
                // ],
                // [
                //     'attribute' => 'std_quota',
                //     //'width' => '150px',
                //     //'hAlign' => 'right',
                //     //'format' => ['decimal', 0],
                //     //'pageSummary' => true
                // ],
                // [
                //     // 'class' => 'kartik\grid\FormulaColumn',
                //     // 'header' => 'Amount In Stock',
                //     // 'value' => function ($model, $key, $index, $widget) { 
                //     //     $p = compact('model', 'key', 'index');
                //     //     return $widget->col(4, $p) * $widget->col(5, $p);
                //     // },
                //     // 'mergeHeader' => true,
                //     // 'width' => '150px',
                //     // 'hAlign' => 'right',
                //     // 'format' => ['decimal', 2],
                //     // 'pageSummary' => true
                // ],
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
