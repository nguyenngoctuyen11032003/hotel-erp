<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
sudo();

/* Cài đặt hệ thống */
if (isset($_POST['systemSettings'])) {
    // Xử lý lỗi và ngăn chặn việc gửi dữ liệu trùng lặp
    $error = 0;
    if (isset($_POST['sys_id']) && !empty($_POST['sys_id'])) {
        $sys_id = mysqli_real_escape_string($mysqli, trim($_POST['sys_id']));
    } else {
        $error = 1;
        $err = "ID hệ thống không được để trống";
    }

    if (isset($_POST['sys_name']) && !empty($_POST['sys_name'])) {
        $sys_name = mysqli_real_escape_string($mysqli, trim($_POST['sys_name']));
    } else {
        $error = 1;
        $err = "Tên hệ thống không được để trống";
    }

    if (isset($_POST['sys_tagline']) && !empty($_POST['sys_tagline'])) {
        $sys_tagline = mysqli_real_escape_string($mysqli, trim($_POST['sys_tagline']));
    } else {
        $error = 1;
        $err = "Khẩu hiệu hệ thống không được để trống";
    }

    if (!$error) {
        // Kiểm tra và xử lý upload logo
        if (isset($_FILES['sys_logo']) && $_FILES['sys_logo']['error'] == 0) {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $filename = $_FILES['sys_logo']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $upload_dir = "../public/uploads/sys_logo/";
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $new_filename = uniqid() . '.' . $ext;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['sys_logo']['tmp_name'], $upload_path)) {
                    $sys_logo = $new_filename;
                } else {
                    $error = 1;
                    $err = "Không thể upload logo. Vui lòng thử lại.";
                }
            } else {
                $error = 1;
                $err = "Định dạng file không hợp lệ. Chỉ chấp nhận JPG, JPEG, PNG và GIF.";
            }
        } else {
            // Nếu không có file mới, giữ nguyên logo cũ
            $ret = "SELECT sys_logo FROM system_settings WHERE sys_id = ?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('s', $sys_id);
            $stmt->execute();
            $stmt->bind_result($old_logo);
            $stmt->fetch();
            $stmt->close();
            $sys_logo = $old_logo;
        }

        if (!$error) {
            $query = "UPDATE system_settings SET sys_name=?, sys_logo=?, sys_tagline=? WHERE sys_id = ?";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('ssss', $sys_name, $sys_logo, $sys_tagline, $sys_id);
            $stmt->execute();
            if ($stmt) {
                $success = "Cài đặt đã được cập nhật thành công" && header("refresh:1; url=settings.php");
            } else {
                $info = "Vui lòng thử lại hoặc thử lại sau";
            }
        }
    }
}

/* Tùy chỉnh trang chính và các trang khác */
if (isset($_POST['HomePageCustomizations'])) {
    // Xử lý lỗi và ngăn chặn việc gửi dữ liệu trùng lặp
    if (isset($_POST['sys_id']) && !empty($_POST['sys_id'])) {
        $sys_id = mysqli_real_escape_string($mysqli, trim($_POST['sys_id']));
    } else {
        $error = 1;
        $err = "ID hệ thống không được để trống";
    }

    if (isset($_POST['welcome_heading']) && !empty($_POST['welcome_heading'])) {
        $welcome_heading = mysqli_real_escape_string($mysqli, trim($_POST['welcome_heading']));
    } else {
        $error = 1;
        $err = "Khẩu hiệu chào mừng không được để trống";
    }

    if (isset($_POST['welcome_content']) && !empty($_POST['welcome_content'])) {
        $welcome_content  = mysqli_real_escape_string($mysqli, trim($_POST['welcome_content']));
    } else {
        $error = 1;
        $err = "Nội dung chào mừng không được để trống";
    }

    if (!$error) {
        $query = "UPDATE system_settings SET welcome_heading = ?, welcome_content = ? WHERE sys_id = ?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sss',  $welcome_heading, $welcome_content, $sys_id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật" && header("refresh:1; url=settings.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}

/* Tùy chỉnh thông tin liên hệ */
if (isset($_POST['ContactsCustomizations'])) {
    // Xử lý lỗi và ngăn chặn việc gửi dữ liệu trùng lặp
    if (isset($_POST['sys_id']) && !empty($_POST['sys_id'])) {
        $sys_id = mysqli_real_escape_string($mysqli, trim($_POST['sys_id']));
    } else {
        $error = 1;
        $err = "ID hệ thống không được để trống";
    }

    if (isset($_POST['contacts_phone']) && !empty($_POST['contacts_phone'])) {
        $contacts_phone  = mysqli_real_escape_string($mysqli, trim($_POST['contacts_phone']));
    } else {
        $error = 1;
        $err = "Số điện thoại liên hệ không được để trống";
    }

    if (isset($_POST['contacts_email']) && !empty($_POST['contacts_email'])) {
        $contacts_email  = mysqli_real_escape_string($mysqli, trim($_POST['contacts_email']));
    } else {
        $error = 1;
        $err = "Địa chỉ email liên hệ không được để trống";
    }

    if (isset($_POST['contacts_addres']) && !empty($_POST['contacts_addres'])) {
        $contacts_addres   = mysqli_real_escape_string($mysqli, trim($_POST['contacts_addres']));
    } else {
        $error = 1;
        $err = "Địa chỉ hệ thống không được để trống";
    }

    if (isset($_POST['social_fb']) && !empty($_POST['social_fb'])) {
        $social_fb   = mysqli_real_escape_string($mysqli, trim($_POST['social_fb']));
    } else {
        $error = 1;
        $err = "Hồ sơ Facebook không được để trống";
    }

    if (isset($_POST['social_ig']) && !empty($_POST['social_ig'])) {
        $social_ig   = mysqli_real_escape_string($mysqli, trim($_POST['social_ig']));
    } else {
        $error = 1;
        $err = "Nội dung Instagram không được để trống";
    }

    if (isset($_POST['social_twitter']) && !empty($_POST['social_twitter'])) {
        $social_twitter   = mysqli_real_escape_string($mysqli, trim($_POST['social_twitter']));
    } else {
        $error = 1;
        $err = "Nội dung Twitter không được để trống";
    }

    if (!$error) {
        $query = "UPDATE system_settings SET  contacts_phone = ?, contacts_email =?, contacts_addres = ?, social_fb = ?, social_ig = ?, social_twitter = ? WHERE sys_id = ?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssssss',  $contacts_phone, $contacts_email, $contacts_addres, $social_fb, $social_ig, $social_twitter, $sys_id);
        $stmt->execute();
        if ($stmt) {
            $success = "Cài đặt đã được cập nhật" && header("refresh:1; url=settings.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}

/* Cài đặt về */
if (isset($_POST['AboutCustomization'])) {
    // Xử lý lỗi và ngăn chặn việc gửi dữ liệu trùng lặp
    if (isset($_POST['sys_id']) && !empty($_POST['sys_id'])) {
        $sys_id = mysqli_real_escape_string($mysqli, trim($_POST['sys_id']));
    } else {
        $error = 1;
        $err = "ID hệ thống không được để trống";
    }

    if (isset($_POST['contact_about']) && !empty($_POST['contact_about'])) {
        $contact_about  = mysqli_real_escape_string($mysqli, trim($_POST['contact_about']));
    } else {
        $error = 1;
        $err = "Nội dung về không được để trống";
    }

    if (!$error) {
        $query = "UPDATE system_settings SET  contact_about = ? WHERE sys_id = ?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss',  $contact_about, $sys_id);
        $stmt->execute();
        if ($stmt) {
            $success = "Cài đặt đã được cập nhật" && header("refresh:1; url=settings.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}

require_once('../partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Thanh điều hướng -->
        <?php require_once('../partials/admin_nav.php'); ?>
        <!-- /.navbar -->

        <!-- Container bên trái chính -->
        <?php require_once('../partials/admin_sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Cài đặt hệ thống</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Cài đặt hệ thống</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Tùy chỉnh</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home-page" role="tab" aria-controls="custom-content-below-home-page" aria-selected="true">Tùy chỉnh trang chính</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="custom-content-below-home-tab" data-toggle="pill" href="#contact_details" role="tab" aria-controls="custom-content-below-home-page" aria-selected="true">Liên hệ</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="custom-content-below-home-tab" data-toggle="pill" href="#about" role="tab" aria-controls="custom-content-below-home-page" aria-selected="true">Về</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="custom-content-below-tabContent">
                                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                <br>
                                                <?php
                                                $ret = "SELECT * FROM `system_settings` ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($sys = $res->fetch_object()) {
                                                ?>
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="sys_name">Tên hệ thống</label>
                                                                    <input type="text" name="sys_name" class="form-control" value="<?php echo $sys->sys_name; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="sys_tagline">Khẩu hiệu hệ thống</label>
                                                                    <input type="text" name="sys_tagline" class="form-control" value="<?php echo $sys->sys_tagline; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="sys_logo">Logo hệ thống</label>
                                                                    <input type="file" name="sys_logo" class="form-control">
                                                                    <?php if (!empty($sys->sys_logo)) { ?>
                                                                        <img src="../public/uploads/sys_logo/<?php echo $sys->sys_logo; ?>" height="60" alt="Logo hiện tại">
                                                                    <?php } ?>
                                                                </div>
                                                                <input type="hidden" name="sys_id" value="<?php echo $sys->sys_id; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="systemSettings" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                <?php
                                                } ?>
                                            </div>

                                            <div class="tab-pane fade show " id="custom-content-below-home-page" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                <br>
                                                <?php
                                                $ret = "SELECT * FROM `system_settings` ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($sys = $res->fetch_object()) {
                                                ?>
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="welcome_heading">Tiêu đề chào mừng</label>
                                                                    <input type="text" name="welcome_heading" class="form-control" value="<?php echo $sys->welcome_heading; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="welcome_content">Nội dung chào mừng</label>
                                                                    <textarea name="welcome_content" class="form-control" rows="3" required><?php echo $sys->welcome_content; ?></textarea>
                                                                </div>
                                                                <input type="hidden" name="sys_id" value="<?php echo $sys->sys_id; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="HomePageCustomizations" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                <?php
                                                } ?>
                                            </div>

                                            <div class="tab-pane fade show " id="contact_details" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                <br>
                                                <?php
                                                $ret = "SELECT * FROM `system_settings` ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($sys = $res->fetch_object()) {
                                                ?>
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="contacts_phone">Số điện thoại liên hệ</label>
                                                                    <input type="text" name="contacts_phone" class="form-control" value="<?php echo $sys->contacts_phone; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="contacts_email">Email liên hệ</label>
                                                                    <input type="email" name="contacts_email" class="form-control" value="<?php echo $sys->contacts_email; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="contacts_addres">Địa chỉ liên hệ</label>
                                                                    <input type="text" name="contacts_addres" class="form-control" value="<?php echo $sys->contacts_addres; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="social_fb">Facebook</label>
                                                                    <input type="text" name="social_fb" class="form-control" value="<?php echo $sys->social_fb; ?>">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="social_ig">Instagram</label>
                                                                    <input type="text" name="social_ig" class="form-control" value="<?php echo $sys->social_ig; ?>">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="social_twitter">Twitter</label>
                                                                    <input type="text" name="social_twitter" class="form-control" value="<?php echo $sys->social_twitter; ?>">
                                                                </div>
                                                                <input type="hidden" name="sys_id" value="<?php echo $sys->sys_id; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="ContactsCustomizations" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                <?php
                                                } ?>
                                            </div>

                                            <div class="tab-pane fade show " id="about" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                <br>
                                                <?php
                                                $ret = "SELECT * FROM `system_settings` ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($sys = $res->fetch_object()) {
                                                ?>
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="contact_about">Nội dung giới thiệu</label>
                                                                    <textarea name="contact_about" class="form-control" rows="4" required><?php echo $sys->contact_about; ?></textarea>
                                                                </div>
                                                                <input type="hidden" name="sys_id" value="<?php echo $sys->sys_id; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="AboutCustomization" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Chân trang chính -->
                <?php require_once('..//partials/footer.php'); ?>
            </div>
        </div>
        <!-- ./wrapper -->
        <?php require_once('../partials/scripts.php'); ?>
</body>

</html>