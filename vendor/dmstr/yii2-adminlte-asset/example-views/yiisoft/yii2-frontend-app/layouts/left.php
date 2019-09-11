<?php 
    if (isset($_GET['id'])) {
        $userID = $_GET['id'];
        //$user   = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = $userID")->queryAll();

        $user   = Yii::$app->db->createCommand("SELECT std_photo FROM std_personal_info WHERE std_id = $userID")->queryAll();

        if (empty($user)){
            $userPhoto = 'frontend/web/images/default.png';
        } else {
             $userPhoto = $user[0]['std_photo'];
        }

        ?>

        <aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php 
                    if (Yii::$app->user->identity->user_type == 'Executive') { ?>
                        <img src="<?php echo $userPhoto; ?>" class="img-circle" alt="User Image"/>
                <?php }else if (Yii::$app->user->identity->user_type == 'Inquiry') { ?>
                        <img src="<?php echo $userPhoto; ?>" class="img-circle" alt="User Image"/>
                <?php }
                    else { ?>
                        <img src="<?php echo 'backend/web/'.$userPhoto; ?>" class="img-circle" alt="User Image"/>
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p>
                <?php 
                //var_dump($userPhoto);
                    $cnic = Yii::$app->user->identity->username;
                    if (Yii::$app->user->identity->user_type == 'Student') {
                        $userName = Yii::$app->db->createCommand("SELECT std_name FROM std_personal_info WHERE std_b_form = '$cnic'")->queryAll();
                        echo $userName[0]['std_name'];
                    }
                    else if(Yii::$app->user->identity->user_type == 'Parent') {
                        $userName = Yii::$app->db->createCommand("SELECT guardian_name FROM std_guardian_info WHERE guardian_cnic = '$cnic'")->queryAll();
                        echo $userName[0]['guardian_name'];
                    }
                    else if(Yii::$app->user->identity->user_type == 'Teacher') {
                        $userName = Yii::$app->db->createCommand("SELECT emp_name FROM emp_info WHERE emp_cnic = '$cnic'")->queryAll();
                        echo $userName[0]['emp_name'];
                    }
                    else{
                        echo Yii::$app->user->identity->username;
                    }
                ?>
                    <!--  -->
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
<?php  if (Yii::$app->user->identity->user_type == 'Teacher') { ?>
        <?=  dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Porfile', 'icon' => 'user', 'url' => './employee-portfolio'],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                     [
                        'label' => 'Class Time Table',
                        'icon' => 'calendar',
                        'url' => './time-table-view',
                    ],
                    [
                        'label' => 'Class',
                        'icon' => 'copy',
                        'items' =>[
                             ['label' => 'Activity', 'icon' => 'caret-right', 'url' => ["./list-of-classes"],],
                            ['label' => 'View Classes', 'icon' => 'caret-right', 'url' => ["./view-classes"],],
                            ['label' => 'Take Attendance', 'icon' => 'caret-right', 'url' => ["./attendance-by-incharge"],],
                            ['label' => 'View Attendance', 'icon' => 'caret-right', 'url' => ["./monthly-class-atten-view"],],  
                        ]
                    ],
                    // [
                    //     'label' => 'Students',
                    //     'icon' => 'users',
                    //     'items' => [
                    //         ['label' => 'Profile', 'icon' => 'caret-right', 'url' => ["./students-view"],],
                    //     ]
                    // ],
                    [
                        'label' => 'Communication',
                        'icon' => 'envelope-o',
                        'items' => [
                            ['label' => 'SMS', 'icon' => 'caret-right', 'url' => ["./premium-version"],],
                             ['label' => 'Email', 'icon' => 'caret-right', 'url' => ["./premium-version"],],
                        ]
                    ],

                   [
                        'label' => 'Apply Leave',
                        'icon' => '',
                        'url' => './emp-leave',
                    ],
                    
                    // ------------------------------------------------
                    // Student Attendance end...
                    // ------------------------------------------------
                ],
            ]
        );
        } 
        // Closing of Teacher Nav Bar....
        // ---------------------------------------------------------
        // Starting of Student Nav Bar...
        if (Yii::$app->user->identity->user_type == 'Student') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Porfile', 'icon' => 'user', 'url' => './std-profile'],
                    ['label' => 'Fees', 'icon' => 'money', 'url' => './fee-details'],
                    ['label' => 'Exam', 'icon' => 'book', 'url' => './std-exams'],
                    ['label' => 'Time Table', 'icon' => 'calendar', 'url' => './premium-version'],
                    ['label' => 'Homework', 'icon' => 'book', 'url' => './premium-version'],
                     ['label' => 'Attendance', 'icon' => 'check-square-o', 'url' => './premium-version'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        );
        } 
        // Closing of Students Nav Bar...
        // ---------------------------------------------------------
        // Starting of Parent Nav Bar...
        if(Yii::$app->user->identity->user_type == 'Parent') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Children', 'icon' => 'user', 'url' => './children'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        );
        } 
        // Closing of Parent Nav Bar...
        // ---------------------------------------------------------
        // Starting of Director Nav Bar...
        if(Yii::$app->user->identity->user_type == 'Director' || Yii::$app->user->identity->user_type == 'Executive') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                    // Data Visualization start...
                    [
                        'label' => 'Data Visualization',
                        'icon' => 'bar-chart',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Financial Reports',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    //['label' => 'Income/Expence', 'icon' => 'chevron-right', 'url' => './income-expense',],
                                    ['label' => 'Balance Sheet', 'icon' => 'chevron-right', 'url' => './balance-sheet',],
                                ],
                            ],
                            [
                                'label' => 'Attendance Reports',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Students Attendance', 'icon' => 'chevron-right', 'url' => './premium-version',],
                                    ['label' => 'Employees Attendance', 'icon' => 'chevron-right', 'url' => './premium-version',],
                                    // ['label' => 'Students Attendance', 'icon' => 'chevron-right', 'url' => './std-attendance-report',],
                                    // ['label' => 'Employees Attendance', 'icon' => 'chevron-right', 'url' => './emp-attendance-report',],
                                ],
                            ],
                        ],
                    ],
                    // ------------------------------------------------
                    // Data Visualization  close...
                ],

            ]

        );
        } 
        
        // Closing of Director Nav Bar...
        // Inquiery side bar
        //echo Yii::$app->user->identity->user_type;
         if (Yii::$app->user->identity->user_type == 'Inquiry') { ?>
        <?=  dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    //['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'View Porfile', 'icon' => 'user', 'url' => './student-details'],
                   // ['label' => 'Edit Profile', 'icon' => 'user', 'url' => './edit-profile'],
                    
                ],
            ]
        );
        } 
        // Closing of Inquiery Nav Bar....
        // ---------------------------------------------------------

        ?>
    </section>

</aside>

<?php
    }
    else if (empty(Yii::$app->user->identity->id)){
            //echo "DEXDEVS";
    } else {
            $userID = Yii::$app->user->identity->id; 
            
            $user   = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = '$userID'")->queryAll();
            //print_r($user+);
    
        if (empty($user)){
            $userPhoto = 'frontend/web/images/default.png';
        } else {
             $userPhoto = $user[0]['user_photo'];
        }
?>
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php 
                    if (Yii::$app->user->identity->user_type == 'Executive') { ?>
                        <img src="<?php echo $userPhoto; ?>" class="img-circle" alt="User Image"/>
                <?php }else if (Yii::$app->user->identity->user_type == 'Inquiry') { ?>
                        <img src="<?php echo $userPhoto; ?>" class="img-circle" alt="User Image"/>
                <?php }
                    else { ?>
                        <img src="<?php echo 'backend/web/'.$userPhoto; ?>" class="img-circle" alt="User Image"/>
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p>
                <?php 
                //var_dump($userPhoto);
                    $cnic = Yii::$app->user->identity->username;
                    if (Yii::$app->user->identity->user_type == 'Student') {
                        $userName = Yii::$app->db->createCommand("SELECT std_name FROM std_personal_info WHERE std_b_form = '$cnic'")->queryAll();
                        echo $userName[0]['std_name'];
                    }
                    else if(Yii::$app->user->identity->user_type == 'Parent') {
                        $userName = Yii::$app->db->createCommand("SELECT guardian_name FROM std_guardian_info WHERE guardian_cnic = '$cnic'")->queryAll();
                        echo $userName[0]['guardian_name'];
                    }
                    else if(Yii::$app->user->identity->user_type == 'Teacher') {
                        $userName = Yii::$app->db->createCommand("SELECT emp_name FROM emp_info WHERE emp_cnic = '$cnic'")->queryAll();
                        echo $userName[0]['emp_name'];
                    }
                    else{
                        echo Yii::$app->user->identity->username;
                    }
                ?>
                    <!--  -->
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
<?php  if (Yii::$app->user->identity->user_type == 'Teacher') { ?>
        <?=  dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Porfile', 'icon' => 'user', 'url' => './employee-portfolio'],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                     [
                        'label' => 'Class Time Table',
                        'icon' => 'calendar',
                        'url' => './time-table-view',
                    ],
                    [
                        'label' => 'Class',
                        'icon' => 'copy',
                        'items' =>[
                             ['label' => 'Activity', 'icon' => 'caret-right', 'url' => ["./list-of-classes"],],
                            ['label' => 'View Classes', 'icon' => 'caret-right', 'url' => ["./view-classes"],],
                            ['label' => 'Take Attendance', 'icon' => 'caret-right', 'url' => ["./attendance-by-incharge"],],
                            ['label' => 'View Attendance', 'icon' => 'caret-right', 'url' => ["./monthly-class-atten-view"],],  
                        ]
                    ],
                    // [
                    //     'label' => 'Students',
                    //     'icon' => 'users',
                    //     'items' => [
                    //         ['label' => 'Profile', 'icon' => 'caret-right', 'url' => ["./students-view"],],
                    //     ]
                    // ],
                    [
                        'label' => 'Communication',
                        'icon' => 'envelope-o',
                        'items' => [
                            ['label' => 'SMS', 'icon' => 'caret-right', 'url' => ["./premium-version"],],
                             ['label' => 'Email', 'icon' => 'caret-right', 'url' => ["./premium-version"],],
                        ]
                    ],

                   [
                        'label' => 'Apply Leave',
                        'icon' => '',
                        'url' => './emp-leave',
                    ],
                    
                    // ------------------------------------------------
                    // Student Attendance end...
                    // ------------------------------------------------
                ],
            ]
        );
        } 
        // Closing of Teacher Nav Bar....
        // ---------------------------------------------------------
        // Starting of Student Nav Bar...
        if (Yii::$app->user->identity->user_type == 'Student') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Porfile', 'icon' => 'user', 'url' => './std-profile'],
                    ['label' => 'Fees', 'icon' => 'money', 'url' => './fee-details'],
                    ['label' => 'Exam', 'icon' => 'book', 'url' => './std-exams'],
                    ['label' => 'Time Table', 'icon' => 'calendar', 'url' => './premium-version'],
                    ['label' => 'Homework', 'icon' => 'book', 'url' => './premium-version'],
                     ['label' => 'Attendance', 'icon' => 'check-square-o', 'url' => './premium-version'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        );
        } 
        // Closing of Students Nav Bar...
        // ---------------------------------------------------------
        // Starting of Parent Nav Bar...
        if(Yii::$app->user->identity->user_type == 'Parent') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Children', 'icon' => 'user', 'url' => './children'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        );
        } 
        // Closing of Parent Nav Bar...
        // ---------------------------------------------------------
        // Starting of Director Nav Bar...
        if(Yii::$app->user->identity->user_type == 'Director' || Yii::$app->user->identity->user_type == 'Executive') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                    // Data Visualization start...
                    [
                        'label' => 'Data Visualization',
                        'icon' => 'bar-chart',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Financial Reports',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    //['label' => 'Income/Expence', 'icon' => 'chevron-right', 'url' => './income-expense',],
                                    ['label' => 'Balance Sheet', 'icon' => 'chevron-right', 'url' => './balance-sheet',],
                                ],
                            ],
                            [
                                'label' => 'Attendance Reports',
                                'icon' => 'caret-right',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Students Attendance', 'icon' => 'chevron-right', 'url' => './premium-version',],
                                    ['label' => 'Employees Attendance', 'icon' => 'chevron-right', 'url' => './premium-version',],
                                    // ['label' => 'Students Attendance', 'icon' => 'chevron-right', 'url' => './std-attendance-report',],
                                    // ['label' => 'Employees Attendance', 'icon' => 'chevron-right', 'url' => './emp-attendance-report',],
                                ],
                            ],
                        ],
                    ],
                    // ------------------------------------------------
                    // Data Visualization  close...
                ],

            ]

        );
        } 
        
        // Closing of Director Nav Bar...
        // Inquiery side bar
        //echo Yii::$app->user->identity->user_type;
         if (Yii::$app->user->identity->user_type == 'Inquiry') { ?>
        <?=  dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    //['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'View Porfile', 'icon' => 'user', 'url' => './student-details'],
                   // ['label' => 'Edit Profile', 'icon' => 'user', 'url' => './edit-profile'],
                    
                ],
            ]
        );
        } 
        // Closing of Inquiery Nav Bar....
        // ---------------------------------------------------------

        ?>
    </section>

</aside>
<?php } ?>