<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
sudo();/* Invoke Sudo */

if (isset($_POST['profile_update'])) {

    /* Update Profile */
    $error = 0;
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = mysqli_real_escape_string($mysqli, trim((($_POST['username']))));
    } else {
        $error = 1;
        $err = "Không được để trống tên người dùng";
    }
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = mysqli_real_escape_string($mysqli, trim((($_POST['email']))));
    } else {
        $error = 1;
        $err = "Không được để trống email";
    }

    $id = $_SESSION['id'];
    $query = "UPDATE  admin  SET username =?, email =?  WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sss',  $username, $email, $id);
    $stmt->execute();
    if ($stmt) {
        $success = "Đã cập nhật thông tin" && header("refresh:1; url=profile.php");
    } else {
        $info = "Vui lòng thử lại sau";
    }
}


if (isset($_POST['change_password'])) {

    //Change Password
    $error = 0;
    if (isset($_POST['old_password']) && !empty($_POST['old_password'])) {
        $old_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['old_password']))));
    } else {
        $error = 1;
        $err = "Không được để trống mật khẩu cũ";
    }
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
    } else {
        $error = 1;
        $err = "Không được để trống mật khẩu mới";
    }
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
    } else {
        $error = 1;
        $err = "Không được để trống xác nhận mật khẩu";
    }

    if (!$error) {
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM  admin  WHERE id = '$id'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($old_password != $row['password']) {
                $err =  "Vui lòng nhập đúng mật khẩu cũ";
            } elseif ($new_password != $confirm_password) {
                $err = "Mật khẩu xác nhận không khớp";
            } else {
                $query = "UPDATE admin SET  password =? WHERE id =?";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('ss', $new_password, $id);
                $stmt->execute();
                if ($stmt) {
                    $success = "Đã đổi mật khẩu" && header("refresh:1; url=profile.php");
                } else {
                    $err = "Vui lòng thử lại sau";
                }
            }
        }
    }
}
require_once('../partials/head.php');
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once("../partials/admin_nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        require_once("../partials/admin_sidebar.php");
        $id = $_SESSION['id'];
        $ret = "SELECT * FROM `admin` WHERE id ='$id' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($admin = $res->fetch_object()) {
        ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Hồ sơ: <?php echo $admin->username; ?></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                    <li class="breadcrumb-item active">Hồ sơ người dùng</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Cập nhật thông tin</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Đổi mật khẩu</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="settings">
                                                <form method='post' enctype="multipart/form-data" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Tên người dùng</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" required class="form-control" value="<?php echo $admin->username; ?>" name="username" id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" required class="form-control" value="<?php echo $admin->email; ?>" name="email" id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" name="profile_update" class="btn btn-primary">Cập nhật</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane" id="changePassword">
                                                <form method='post' class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Mật khẩu cũ</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="old_password" required class="form-control" id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Mật khẩu mới</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="new_password" required class="form-control" id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Xác nhận mật khẩu mới</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="confirm_password" required class="form-control" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" name="change_password" class="btn btn-primary">Đổi mật khẩu</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php require_once('../partials/footer.php');
        } ?>
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>