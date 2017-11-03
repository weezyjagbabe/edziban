<?php
session_start();
if(!isset($_SESSION['userCode']) && !isset($_SESSION['email'])){
//    echo "<script>location.href='login.php'</script>";
    //die("You are not logged in");
    header("Location: login.php");
}
else{
    $pageName	=	"Home";
    $userCode = $_SESSION['userCode'];
    $email = $_SESSION['email'];
    require_once 'dbconfig.php';
    require_once 'functions/functions.php';

    ?>

    <?php require_once 'includes/pageHead.php';?>
    <body>
    <?php require_once 'includes/navbar.php'; ?>

    <div class="page-content">
        <div class="row">
            <?php require_once  'includes/pageLeftNav.php'?>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content-box-large">
                            <div class="panel-heading">
                                <div class="panel-title">Password Change</div>
                            </div>
                            <div class="panel-body">

                                <?php
                                if ( isset( $_POST['changePassword'] ) ) {

                                    $conn = connection();

                                    $oldPass = mysqli_real_escape_string($conn, $_POST['currentPass']);
                                    $newPass = mysqli_real_escape_string($conn, $_POST['newPass']);
                                    $newPass1 = mysqli_real_escape_string($conn, $_POST['newPass1']);


                                    if ($newPass <> $newPass1) {
                                        ?>
                                        <div class="alert alert-error">
                                            <button type="button" class="close" data-dismiss="alert">&times;
                                            </button>
                                            <h4>ERROR!</h4> Your Passwords do not match!!!
                                        </div>
                                        <?php
                                    }
                                    elseif (checkPassword($oldPass, $email)) {
                                        $options = [
                                            'cost' => 12,
                                        ];
                                        $password = password_hash($newPass, PASSWORD_BCRYPT, $options);
                                        if (updatePassword($password, $email)) {
                                            ?>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                <h4>Password!</h4> changed successfully!!! Logging out NOW!!!
                                                <?php echo "<script>setTimeout(function(){
                                                                location.href='logout.php';
                                                            },1500)</script>"; ?>
                                            </div>

                                            <?php
                                        } else {
                                            ?>
                                            <div class="alert alert-error">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                <h4>Ooops!</h4> Something went wrong!!!
                                            </div>
                                            <?php
                                        }
                                    }
                                    else {
                                        ?>
                                        <div class="alert alert-error">
                                            <button type="button" class="close" data-dismiss="alert">&times;
                                            </button>
                                            <h4>Error!</h4> The Current Password you entered doesn't match what is on record!!!
                                        </div>
                                        <?php
                                        mysqli_error($conn);
                                    }
                                    mysqli_close($conn);
                                }

                                ?>
                                <form class="form-horizontal" action="" method="post">
                                    <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Current Password</label>
                                        <div class="col-md-10">
                                            <input class="form-control" placeholder="Password field" type="password"  name="currentPass">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">New Password</label>
                                        <div class="col-md-10">
                                            <input class="form-control" placeholder="Password field" type="password"  name="newPass">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Re-type Password</label>
                                        <div class="col-md-10">
                                            <input class="form-control" placeholder="Password field" type="password"  name="newPass1">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="changePassword">
                                        Submit
                                    </button>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>



    <?php
    require_once 'includes/pageFooter.php';
    require_once 'includes/pageScripts.php';

    ?>
    <!---->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    <!--<script type="text/javascript">-->
    <!--    $( document ).ready(function() {-->
    <!--        $('.changeStatus').on('click', function (e) {-->
    <!--            e.preventDefault();-->
    <!--            var $this = $(this);-->
    <!--            var status = $this.html();-->
    <!--            var cycleNo = $this.attr('data-cycle-id');-->
    <!--            var subStatus = $this.attr('data-cycle-status');-->
    <!--            var userCode = $this.attr('data-user-id');-->
    <!--            var acolor = $('#text');-->
    <!--            acolor.toggleClass('btn btn-default btn-xs');-->
    <!--//            bcolor.toggleClass('label active');-->
    <!--            $.get('/paySwitchAdwane/userCycleStatus.php?userCode='+userCode+'&subStatus='+subStatus+'$cycleNo='+cycleNo).then(function (response) {-->
    <!--                var data = $.parseJSON(response);-->
    <!--                $this.attr('data-cycle-status', data.status);-->
    <!--                $this.html((data.status)? 'Already Subscribed' : 'Subscribe Now!!!');-->
    <!--            });-->
    <!--        });-->
    <!--    });-->
    <!--</script>-->
    </body>
    </html>
<?php } ?>