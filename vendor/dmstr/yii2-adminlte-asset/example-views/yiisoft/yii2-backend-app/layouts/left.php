<?php 

    $userID = Yii::$app->user->id;
    $user = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = '$userID'")->queryAll();
    // Student Photo...
    $userPhoto = $user[0]['user_photo'];
?>
<style type="text/css">
    .main-sidebar{
        color: #ECF0F5;
        background-color: #FAB61C;
    }
    .main-sidebar a{
        color:  #000000;
    }
    .sidebar a:hover{
        font-weight: bold;
        background-color: #000000;
        color: #ffffff;
    }
</style>
<aside class="main-sidebar">

    <section class="sidebar" style="overflow-y: visible; ">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo '../backend/web/'.$userPhoto; ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p style="color:black;">
                    <?= Yii::$app->user->identity->username ?>
                    <!--  -->
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <!-- <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div> -->
        </form>
        <!-- /.search form -->
        <?php if(Yii::$app->user->can('navigation')){ ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    // ['label' => 'Menus', 'options' => ['class' => 'header center']],
                     ['label' => 'Home', 'icon' => 'dashboard', 'url' => "./home"],
                     ['label' => 'Customer', 'icon' => 'arrow-right', 'url' => "./customer"],
                     ['label' => 'Customer Vehicles', 'icon' => 'arrow-right', 'url' => "./customer-vehicles"],
                     [
                        'label' => 'Employee',
                        'icon' => 'arrow-right',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Add Employee', 'icon' => 'chevron-right', 'url' => './employee',],
                            ['label' => 'Employee Salary', 'icon' => 'chevron-right', 'url' => './salary',],
                            ['label' => 'Employee Allowance', 'icon' => 'chevron-right', 'url' => './employee-allowances',],
                        ],
                    ],
                     ['label' => 'Membership', 'icon' => 'arrow-right', 'url' => "./membership"],
                     ['label' => 'Services', 'icon' => 'arrow-right', 'url' => "./services"],
                     [
                        'label' => 'Stock',
                        'icon' => 'arrow-right',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Manage Stock', 'icon' => 'chevron-right', 'url' => './stock',],
                            ['label' => 'Issue to Employee', 'icon' => 'chevron-right', 'url' => './stock-issue',],
                        ],
                    ],
                    ['label' => 'Sale Invoice', 'icon' => 'arrow-right', 'url' => "./sale-invoice-head"],
                    ['label' => 'Users', 'icon' => 'arrow-right', 'url' => "./home"],
                    ['label' => 'Accounts', 'icon' => 'arrow-right', 'url' => "./home"],
                    ['label' => 'Reports', 'icon' => 'arrow-right', 'url' => "./home"],
                    //['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    //['label' => 'Login', 'url' => ["../login"], 'visible' => Yii::$app->user->isGuest],

                    // ------------------------------------------------
                    
                    
                   
                     
                    // ------------------------------------------------
                    
                    // System Settings start...
                    [
                        'label' => 'System Settings',
                        'icon' => 'cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Organization', 'icon' => 'caret-right', 'url' => ["./organization"],],
                            ['label' => 'Branches', 'icon' => 'caret-right', 'url' => ["./branches"],],
                            [
                                'label' => 'Vehicle',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Vehicle Type', 'icon' => 'chevron-right', 'url' => './vehicle-type',],
                                    ['label' => 'Sub Category', 'icon' => 'chevron-right', 'url' => './vehicle-type-sub-category',],
                                ],
                            ],
                            ['label' => 'Card Type', 'icon' => 'caret-right', 'url' => ["./card-type"],],
                            [
                                'label' => 'Stock',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Manufacturer', 'icon' => 'chevron-right', 'url' => './manufacture',],
                                    ['label' => 'Stock Type', 'icon' => 'chevron-right', 'url' => './stock-type',],
                                ],
                            ],
                            ['label' => 'User Types', 'icon' => 'caret-right', 'url' => ["./user-type"],],
                            ['label' => 'Employee Types', 'icon' => 'caret-right', 'url' => ["./employee-types"],],
                            [
                                'label' => 'Salary',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Wage Type', 'icon' => 'chevron-right', 'url' => './wage-type',],
                                    ['label' => 'Allowance Type', 'icon' => 'chevron-right', 'url' => './allowance-type',],
                                ],
                            ],
                            ['label' => 'Vendor', 'icon' => 'caret-right', 'url' => ["./vendor"],],
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
                ],
            ]
        ) ?>
        <?php } ?>

        <!-- Inquiry Nav Start -->
        <?php if(Yii::$app->user->can('inquiry-nav')){ ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'dashboard', 'url' => "./home"],
                    //['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ["../login"], 'visible' => Yii::$app->user->isGuest],

                    // ------------------------------------------------
                    // Student Module start...
                    [
                        'label' => 'Student Module',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Student Inquiry', 'icon' => 'caret-right', 'url' => ["/std-inquiry"],],
                            //['label' => 'Student Registration', 'icon' => 'caret-right', 'url' => ["/std-personal-info"],],
                            //['label' => 'Student Enrollment', 'icon' => 'caret-right', 'url' => ["/std-enrollment-head"],],
                            //['label' => 'Student Promotion', 'icon' => 'caret-right', 'url' => ["./std-promote"],],
                        ],
                    ],
                    
                    // ------------------------------------------------
                    
                ],
            ]
        ) ?>
        <?php } ?>
        <!-- Inquiry Nav end -->

    </section>

</aside>
