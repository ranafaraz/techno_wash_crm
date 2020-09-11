<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php 
    $userID = Yii::$app->user->id;
    $user = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = '$userID'")->queryAll();
    // Student Photo...
    $userPhoto = $user[0]['user_photo'];
?>
<style type="text/css">
    /*body{
        font-family: serif;
    }*/
    .main-header{
        background-color: #000000;
        color: white;
    }
    .main-header a{
        color: white;
    }
    .panel-heading{
        background-color: #AA5397;
        color: white;
    }
</style>
<body>
<header class="main-header fixed text-dark">

    <?= Html::a('<span class="logo-mini"><b style="color:#FAB61C; font-family: serif;">TW</b></span><span class="logo-lg">' . "<b style='color:#FAB61C; font-family: serif;'>TECHNO<span style='color:white;'>WASH</span></b>" . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top">

        <a style="color:#FAB61C;" href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu invisible">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                                 alt="User Image"/>
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <!-- Notifications Starts -->
                <li class="dropdown notifications-menu invisible">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?php //echo $no_of_leaves; ?> notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    
                                </li>
                                <?php 
                                    // foreach ($emp_leave as $key => $value) {
                                    //     $emp_id=$value["emp_id"];
                                    //     $emp_name = Yii::$app->db->createCommand("SELECT emp_name FROM emp_info WHERE emp_id=$emp_id")->queryAll();        
                                ?>
                                <li>
                                    <a href="./emp-leave">
                                        <i class="fa fa-user text-yellow"></i><?php //echo $emp_name[0]["emp_name"]." ".$value["leave_type"]; ?> 
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="footer"><a href="#">View all</a></li> -->
                    </ul>
                </li>
                <!-- Notifications close -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo '../frontend/web/'.$userPhoto; ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">
                            <!--  -->
                            <?= Yii::$app->user->identity->username ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu" style="background-color:#FAB61C;">
                        <!-- User image -->
                        <li class="user-header" style="height: 200px">
                            <img src="<?php echo '../frontend/web/'.$userPhoto; ?>" class="img-circle"
                                 alt="User Image"/>
                            <p>
                                <label for="">Contact Info</label><br>
                                <?= Yii::$app->user->identity->email ?>
                                <!-- user_phone_no -->

                                <!-- email -->
                                <!-- - Web Developer
                                <small>Member since Nov. 2012</small> -->
                            </p>
                            <div class="pull">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat btn-sm']
                                ) ?>
                            </div>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="user-body">
                            <div class="col-xs-12 text-center">
                                <label for="">User Name</label>
                                <a href="#"></a>
                            </div>
                        </li>
                        <li class="user-body">    
                            <div class="col-xs-12 text-center">
                                <label for="">Email</label>
                                <a href="#"></a>
                            </div>
                        </li> -->
                        <!-- Menu Footer-->
                        <li class="user-foote invisible">
                            <div class="pull-left invisible">
                                <a href="./user-profile" class="btn btn-primary btn-flat btn-sm">Profile</a>
                            </div>
                            <div class="pull-right invisible">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat btn-sm']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
</body>