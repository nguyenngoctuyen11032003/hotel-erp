<?php
session_start();
include('../config/config.php');
// Xử lý đăng nhập
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = sha1(md5($_POST['password']));
    $stmt = $mysqli->prepare("SELECT email, password, id  FROM admin  WHERE (email =? AND password =?)");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($email, $password, $id);
    $rs = $stmt->fetch();
    $_SESSION['id'] = $id;
    if ($rs) {
        header("location:dashboard.php");
    } else {
        $err = "Truy cập bị từ chối. Vui lòng kiểm tra thông tin đăng nhập.";
    }
}

require_once('../partials/head.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <?php
        $ret = "SELECT * FROM `system_settings` ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($sys = $res->fetch_object()) {
            if (empty($sys->sys_logo)) {
                $logo_dir = '../public/uploads/sys_logo/logo.png';
            } else {
                $logo_dir = "../public/uploads/sys_logo/$sys->sys_logo";
            }
        ?>
            <div class="login-logo">
                <img class="img-fluid" height="100" width="150" src="<?php echo $logo_dir; ?>" alt="">
            </div>
        <?php
        } ?>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Đăng nhập quản trị hệ thống</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" required class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" required class="form-control" name="password" placeholder="Mật khẩu">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <!-- <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Ghi nhớ tôi
                                </label>
                            </div> -->
                        </div>
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="../">Trang chủ</a>
                </p>
                <p class="mb-1">
                    <a href="reset_password.php">Quên mật khẩu?</a>
                </p>
            </div>
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>
</html>