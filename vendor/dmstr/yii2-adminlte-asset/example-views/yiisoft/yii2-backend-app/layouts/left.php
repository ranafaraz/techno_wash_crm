<?php 

    $userID = Yii::$app->user->id;
    $user = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = '$userID'")->queryAll();
    // Student Photo...
    $userPhoto = $user[0]['user_photo'];
?>
<style type="text/css">
    .main-sidebar{
        font-family: georgia;
        background-color: #fab61c !important;

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
                <img src="<?php echo '../backend/web/'.$userPhoto; ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p id="user-name">
                    <?php 
                    $name = Yii::$app->user->identity->username;
                    if ($name = 'developer') {
                        echo "Developer";
                    }



                     ?>
                    <!--  -->
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
                     //['label' => 'Customer', 'icon' => 'users', 'url' => "./customer"],
                     ['label' => 'Sale Invoice', 'icon' => 'file-pdf-o', 'url' => "./customer-vehicles"],
                     [
                        'label' => 'Employee',
                        'icon' => 'user-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Add Employee', 'icon' => 'user-plus', 'url' => './employee',],
                            ['label' => 'Employee Salary', 'icon' => 'money', 'url' => './salary',],
                            ['label' => 'Employee Allowance', 'icon' => 'credit-card', 'url' => './employee-allowances',],
                            ['label' => 'Stock Issues', 'icon' => 'exclamation-triangle', 'url' => './stock-issue',],
                        ],
                    ],
                     ['label' => 'Membership', 'icon' => 'handshake-o', 'url' => "./under-construction"],
                     ['label' => 'Vendor', 'icon' => 'male', 'url' => ["./vendor"],],
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
                    ['label' => 'Accounts', 'icon' => 'server', 'url' => ["./under-construction"]],
                    ['label' => 'Reports', 'icon' => 'book', 'url' => ["./under-construction"]],
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
                            ['label' => 'Card Type', 'icon' => 'credit-card', 'url' => ["./under-construction"],],
                            ['label' => 'Services', 'icon' => 'strikethrough', 'url' => "./services"],
                            [
                                'label' => 'Stock',
                                'icon' => 'bar-chart',
                                'url' => './stock-type',
                                
                            ],
                            //['label' => 'Card Type', 'icon' => 'credit-card', 'url' => ["./card-type"],],
                            // ['label' => 'User Types', 'icon' => 'user-circle-o', 'url' => ["./user-type"],],
                            // ['label' => 'Employee Types', 'icon' => 'user-secret', 'url' => ["./employee-types"],],
                            [
                                'label' => 'Employee',
                                'icon' => 'usd',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Wage Type', 'icon' => 'won', 'url' => './under-construction',],
                                    ['label' => 'Allowance Type', 'icon' => 'credit-card-alt', 'url' => './under-construction',],
                                ],
                            ],
                            
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
