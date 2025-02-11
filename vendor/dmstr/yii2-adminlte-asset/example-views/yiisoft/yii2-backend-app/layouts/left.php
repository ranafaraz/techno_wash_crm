<?php 

    $userID = Yii::$app->user->id;
    $user = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = '$userID'")->queryAll();
    // Student Photo...
    $userPhoto = $user[0]['user_photo'];
?>
<style type="text/css">
    /*#fab61c*/
    .main-sidebar{
        font-family: arial;
        background-color: #fab61c !important;
        font-weight: bold;

    }
    .sidebar a{
        font-size: 13px;
        color: #000000 !important;
    }
    .sidebar a:hover{
        font-weight: bold;
        background-color: #000000 !important;
        color: #ffffff !important;
        border-radius: 2px !important;
    }
    #user-name{
        color:green;
    }
    #user-name:hover{
        color:red;
    }
</style>
<aside class="main-sidebar">

    <section class="sidebar" style="overflow-y: visible; ">

        <!-- Sidebar user panel -->
        <div class="user-panel" style="margin-bottom:10px;">
            <div class="pull-left image">
                <img src="<?php echo '../frontend/web/'.$userPhoto; ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p id="user-name">
                    <?= Yii::$app->user->identity->username ?>
                </p>
                <p id="user-name" ><i class="fa fa-circle text-success"></i> Online</p>
            </div>
        </div>
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->
        <?php if(Yii::$app->user->can('navigation')){ ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    // ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'dashboard', 'url' => "./home"],
                     // ['label' => 'Customer', 'icon' => 'users', 'url' => "./customer"],
                     // ['label' => 'Sale Invoice', 'icon' => 'file-pdf-o', 'url' => "./customer-vehicles?sort=-customer_id"],

                    ['label' => 'Customer', 'icon' => 'users', 'url' => "./customer-vehicles"],
                    ['label' => 'Sale Invoice', 'icon' => 'money', 'url' => "./sale-invoice-view"],
                    ['label' => 'Purchase Invoice', 'icon' => 'sign-out', 'url' => ["./vendor"],],
                    //['label' => 'Employees', 'icon' => 'user-plus', 'url' => "./under-construction"],
                     // PayRoll Start
                    [
                        'label' => 'Employee',
                        'icon' => 'user-plus',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Add', 'icon' => 'plus', 'url' => ["./employee"],],
                            // [
                            //     'label' => 'Attendance',
                            //     'icon' => 'users',
                            //     'url' => '#',
                            //     'items' => [
                            //         ['label' => 'Attendance', 'icon' => '', 'url' => ["./emp-atten"],],

                            //         ['label' => 'Absentees', 'icon' => '', 'url' => "./final-attendance"],
                                   
                            //         ['label' => 'Leave', 'icon' => '', 'url' => "./emp-leave"],
                                    
                            //         [
                            //             'label' => 'Reports',
                            //             'icon' => 'bar-chart',
                            //             'url' => '#',
                            //             'items' => [
                            //                 ['label' => 'Single Employee', 'icon' => '', 'url' => ["./emp-att-report"],],
                                           
                            //                 ['label' => 'Monthly Report', 'icon' => '', 'url' => "./employess-att-report"],   
                            //             ],
                            //         ],
                            //     ],
                            // ],
                            // ['label' => 'PayRoll', 'icon' => 'money', 'url' => './under-construction', ],
                            // ['label' => 'Stock Issues', 'icon' => 'exclamation-triangle', 'url' => './stock-issue',],
                            // ['label' => 'Report', 'icon' => 'bar-chart', 'url' => ["./under-construction"],],
                        ],
                    ],
                    // System Settings close...
                    // ------------------------------------------------

                    // ------------------------------------------------
                    // Multilevel Dropdown....!
                    // [
                    //     'label' => 'Some tools',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
              
                     // Pay Roll  End
                     // ['label' => 'PayRoll', 'icon' => 'money', 'url' => "./payroll-month-report"],
                     // ['label' => 'Employee Attendance', 'icon' => 'user-plus', 'url' => "./under-construction"],
                    //  [
                    //     'label' => 'Employee',
                    //     'icon' => 'user-o',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Add Employee', 'icon' => 'user-plus', 'url' => './employee',],
                    //         ['label' => 'Employee Salary', 'icon' => 'money', 'url' => './salary',],
                    //         ['label' => 'Employee Allowance', 'icon' => 'credit-card', 'url' => './employee-allowances',],
                    //         ['label' => 'Stock Issues', 'icon' => 'exclamation-triangle', 'url' => './stock-issue',],
                    //     ],
                    // ],
                     // ['label' => 'Membership', 'icon' => 'handshake-o', 'url' => "./under-construction"],

                    //  [
                    //     'label' => 'Stock',
                    //     'icon' => 'bar-chart',
                    //     'url' => '#',
                    //     'items' => [
                    //         // ['label' => 'Manage Stock', 'icon' => 'meetup', 'url' => './stock',],
                            
                    //     ],
                    // ],
                    // ['label' => 'Sale Invoice', 'icon' => 'file-text-o', 'url' => "./sale-invoice-head"],
                    // ['label' => 'Users', 'icon' => 'user', 'url' => "./home"],
                   // ['label' => 'Accounts', 'icon' => 'server', 'url' => ["./under-construction"]],
                   // ['label' => 'Reports', 'icon' => 'book', 'url' => ["./under-construction"]],
                    //['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    //['label' => 'Login', 'url' => ["../login"], 'visible' => Yii::$app->user->isGuest],

                    // ------------------------------------------------
                    
                    
                   
                     // ------------------------------------------------
                    
                    // System Settings start...
                    [
                        'label' => 'Accounts',
                        'icon' => 'money',
                        'url' => '#',
                        'items' => [
                            // ['label' => 'Account Nature', 'icon' => 'plus-circle', 'url' => ["./account-nature"],],
                            ['label' => 'Account Head', 'icon' => 'plus-circle', 'url' => ["./account-head"],],
                            ['label' => 'Add Expense', 'icon' => 'money', 'url' => ["./create-payment"],],
                            //['label' => '', 'icon' => 'university', 'url' => [""],],
                            // [
                            // 'label' => 'Vehicle',
                            //     'icon' => 'car',
                            //     'url' => './vehicle-type',
                            //     // 'items' => [
                            //     //     ['label' => 'Vehicle Type', 'icon' => 'taxi', 'url' => '',],
                            //     //     ['label' => 'Sub Category', 'icon' => 'bars', 'url' => './vehicle-type-sub-category',],
                            //     // ],
                            // ],
                            
                        ],
                    ],
                    [
                        'label' => 'Reports',
                        'icon' => 'bar-chart',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Todays Customers', 'icon' => 'users', 'url' => "./car-wash-details?customer"],
                            ['label' => 'Sales Report', 'icon' => 'money', 'url' => ["./income-report"],],
                            ['label' => 'Expense Report', 'icon' => 'calculator', 'url' => ["./expense-report"],],
                            ['label' => 'Credit Invoices', 'icon' => 'sign-in', 'url' => ["./credit-sale-invoices?creditInvoice"],], 
                            ['label' => 'Debit Invoices', 'icon' => 'sign-out', 'url' => ["./credit-sale-invoices?debitInvoice"],],              
                        ],
                    ],
                    // System Settings start...
                    [
                        'label' => 'System Settings',
                        'icon' => 'cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Organization', 'icon' => 'building-o', 'url' => ["./organization"],],
                            ['label' => 'Branches', 'icon' => 'university', 'url' => ["./branches"],],
                            [
                                'label' => 'Vehicle',
                                'icon' => 'car',
                                'url' => './vehicle-type',
                                // 'items' => [
                                //     ['label' => 'Vehicle Type', 'icon' => 'taxi', 'url' => '',],
                                //     ['label' => 'Sub Category', 'icon' => 'bars', 'url' => './vehicle-type-sub-category',],
                                // ],
                            ],
                            ['label' => 'Services', 'icon' => 'strikethrough', 'url' => "./services"],
                            [
                                'label' => 'Stock',
                                'icon' => 'bar-chart',
                                'url' => './stock-type',
                                
                            ],
                            // ['label' => 'Card Type', 'icon' => 'credit-card', 'url' => ["./under-construction"],],
                            // ['label' => 'User Types', 'icon' => 'user-circle-o', 'url' => ["./user-type"],],
                            // ['label' => 'Employee Types', 'icon' => 'user-secret', 'url' => ["./employee-types"],],
                            // [
                            //     'label' => 'Employee',
                            //     'icon' => 'users',
                            //     'url' => '#',
                            //     'items' => [
                            //         ['label' => 'Employee Type', 'icon' => 'user-secret', 'url' => './employee-types',],
                            //         ['label' => 'Wage Type', 'icon' => 'won', 'url' => './wage-type',],
                            //         ['label' => 'Allowance Type', 'icon' => 'credit-card-alt', 'url' => './under-construction',],
                            //     ],
                            // ],
                            
                            // [
                            //     'label' => 'Subjects',
                            //     'icon' => 'caret-right',
                            //     'url' => '#',
                            //     'items' => [
                            //         ['label' => 'Subjects List', 'icon' => 'chevron-right', 'url' => './subjects',],
                            //         ['label' => 'Subject Combination', 'icon' => 'chevron-right', 'url' => './std-subjects',],
                            //     ],
                            // ],
                            // [
                            //     'label' => 'Employees',
                            //     'icon' => 'caret-right',
                            //     'url' => '#',
                            //     'items' => [
                            //         ['label' => 'Employee Type', 'icon' => 'chevron-right', 'url' => './emp-type',],
                            //         ['label' => 'Employee Designation', 'icon' => 'chevron-right', 'url' => './designation',],
                            //     ],
                            // ],
                            // [
                            //     'label' => 'Fee',
                            //     'icon' => 'caret-right',
                            //     'url' => '#',
                            //     'items' => [
                            //         ['label' => 'Fee Types', 'icon' => 'chevron-right', 'url' => './fee-type',],
                            //         ['label' => 'Fee Packages', 'icon' => 'chevron-right', 'url' => './std-fee-pkg',],
                            //     ],
                            // ],
                        ],
                    ],
                ],
            ]
        ) ?>
        <?php } ?>
    </section>
</aside>