<?php
session_start();
include('../config/config.php');

if (isset($_POST['reset_password'])) {
    $error = 0;
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Vui lòng nhập email";
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $err = 'Email không hợp lệ';
    }
    $checkEmail = mysqli_query($mysqli, "SELECT `email` FROM `admin` WHERE `email` = '" . $_POST['email'] . "'") or exit(mysqli_error($mysqli));
    if (mysqli_num_rows($checkEmail) > 0) {

        $n = date('y');
        $new_password = bin2hex(random_bytes($n));
        $query = "UPDATE admin SET  password=? WHERE email =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss', $new_password, $email);
        $stmt->execute();
        if ($stmt) {
            $_SESSION['email'] = $email;
            $success = "Vui lòng xác nhận mật khẩu mới" && header("refresh:1; url=confirm_password.php");
        } else {
            $err = "Đặt lại mật khẩu thất bại";
        }
    } else {
        $err = "Email không tồn tại";
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
                <p class="login-box-msg">Đặt lại mật khẩu</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="reset_password" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="index.php">Quay lại đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>
</html>