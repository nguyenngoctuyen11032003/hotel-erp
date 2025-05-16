<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Gọi kiểm tra đăng nhập quản trị viên */

if (isset($_POST['add_asset'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "ID tài sản không được để trống";
    }

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
    } else {
        $error = 1;
        $err = "Tên tài sản không được để trống";
    }

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    } else {
        $error = 1;
        $err = "Mã tài sản không được để trống";
    }

    if (isset($_POST['details']) && !empty($_POST['details'])) {
        $details = mysqli_real_escape_string($mysqli, trim($_POST['details']));
    } else {
        $error = 1;
        $err = "Chi tiết không được để trống";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Trạng thái không được để trống";
    }

    if (!$error) {
        // Ngăn chặn nhập trùng
        $sql = "SELECT * FROM  assets WHERE code = '$code'  ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($code == $row['code']) {
                $err =  "Một tài sản với mã số đó đã tồn tại";
            } else {
                //
            }
        } else {
            $query = "INSERT INTO assets (id, code, name, details, status) VALUES (?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('sssss', $id, $code, $name, $details, $status);
            $stmt->execute();
            if ($stmt) {
                $success = "Đã thêm" && header("refresh:1; url=inventory_assets.php");
            } else {
                $info = "Vui lòng thử lại hoặc thử lại sau";
            }
        }
    }
}

if (isset($_POST['Update_Asset'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "ID tài sản không được để trống";
    }

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
    } else {
        $error = 1;
        $err = "Tên tài sản không được để trống";
    }

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    } else {
        $error = 1;
        $err = "Mã tài sản không được để trống";
    }

    if (isset($_POST['details']) && !empty($_POST['details'])) {
        $details = mysqli_real_escape_string($mysqli, trim($_POST['details']));
    } else {
        $error = 1;
        $err = "Chi tiết không được để trống";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Trạng thái không được để trống";
    }

    if (!$error) {
        $query = "UPDATE assets SET code =?, name =?, details =?, status =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssss', $code, $name, $details, $status, $id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật" && header("refresh:1; url=inventory_assets.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}

if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $adn = "DELETE FROM assets WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa" && header("refresh:1; url=inventory_assets.php");
    } else {
        $info = "Vui lòng thử lại hoặc thử lại sau";
    }
}

require_once("../partials/head.php");

// Lấy đường dẫn logo hệ thống
$logo_dir = '../public/uploads/sys_logo/logo.png';
$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
if ($sys = $res->fetch_object()) {
    if (!empty($sys->sys_logo)) {
        $logo_dir = "../public/uploads/sys_logo/$sys->sys_logo";
    }
}
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Thanh điều hướng -->
        <?php require_once("../partials/admin_nav.php"); ?>
        <!-- /.navbar -->

        <!-- Container bên trái chính -->
        <?php require_once("../partials/admin_sidebar.php"); ?>

        <!-- Content Wrapper. Chứa nội dung trang -->
        <div class="content-wrapper">
            <!-- Tiêu đề nội dung (tiêu đề trang) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lý tài sản khách sạn</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item"><a href="">Kho</a></li>
                                <li class="breadcrumb-item active">Tài sản</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <form class="form-inline">
                    </form>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Thêm tài sản</button>
                    </div>
                    <!-- Modal Thêm -->
                    <div class="modal fade" id="add_modal">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Thêm tài sản mới</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-row mb-4">
                                            <div style="display:none" class="form-group col-md-6">
                                                <label for="inputEmail4">Id</label>
                                                <input type="text" name="id" value="<?php echo $ID; ?>" class="form-control">
                                                <input type="text" name="status" value="Hoạt động" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Mã tài sản</label>
                                                <input required type="text" value="<?php echo $a; ?>-<?php echo $b; ?>" name="code" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Tên tài sản</label>
                                                <input required type="text" name="name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Mô tả tài sản</label>
                                                <textarea rows="5" required type="text" name="details" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_asset" class="btn btn-warning mt-3">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Kết thúc Modal -->

                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Mã tài sản</th>
                                    <th>Tên tài sản</th>
                                    <th>Trạng thái tài sản</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `assets` ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($asset = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $asset->code; ?></td>
                                        <td><?php echo $asset->name; ?></td>
                                        <td><?php echo $asset->status; ?></td>
                                        <td><?php echo date('d M Y', strtotime($asset->created_at)); ?></td>
                                        <td>
                                            <a class="badge badge-success" data-toggle="modal" href="#view_<?php echo $asset->id; ?>">Xem</a>
                                            <!-- Xem tài sản -->
                                            <div class="modal fade" id="view_<?php echo $asset->id; ?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div id="Print_Payroll" class="invoice p-3 mb-3">
                                                                <div class="row">
                                                                    <div class="col-12 ">
                                                                        <h4 class="text-center">
                                                                            <img height="100" width="200" src="<?php echo $logo_dir; ?>" class="img-thumbnail img-fluid" alt="Logo hệ thống">
                                                                            <br>
                                                                            <small class="float-right">Tài sản được ghi nhận vào: <?php echo date('d M Y g:ia', strtotime($asset->created_at)); ?></small>
                                                                        </h4>
                                                                        <h4>
                                                                            Hồ sơ tài sản của NT Hotels Inc
                                                                        </h4>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-12 table-responsive">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Mã tài sản</th>
                                                                                    <th>Tên tài sản</th>
                                                                                    <th>Trạng thái tài sản</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><?php echo $asset->code; ?></td>
                                                                                    <td><?php echo $asset->name; ?></td>
                                                                                    <td><?php echo $asset->status; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-12 table-responsive">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Mô tả tài sản</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="text-center"><?php echo $asset->details; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                                                            <button id="print" onclick="printContent('Print_Payroll');" type="button" class="btn btn-primary">In</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="badge badge-primary" data-toggle="modal" href="#update_<?php echo $asset->id; ?>">Cập nhật</a>
                                            <!-- Cập nhật tài sản -->
                                            <div class="modal fade" id="update_<?php echo $asset->id; ?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Cập nhật tài sản: <?php echo $asset->code; ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="form-row mb-4">
                                                                    <div style="display:none" class="form-group col-md-6">
                                                                        <label for="inputEmail4">Id</label>
                                                                        <input type="text" name="id" value="<?php echo $asset->id; ?>" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Mã tài sản</label>
                                                                        <input required type="text" value="<?php echo $asset->code; ?>" name="code" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Trạng thái tài sản</label>
                                                                        <select class='form-control ' name="status" id="">
                                                                            <option selected><?php echo $asset->status; ?></option>
                                                                            <option>Hoạt động</option>
                                                                            <option>Hỏng</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Tên tài sản</label>
                                                                        <input required type="text" value="<?php echo $asset->name; ?>" name="name" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <label for="inputEmail4">Mô tả tài sản</label>
                                                                        <textarea rows="5" required type="text" name="details" class="form-control"><?php echo $asset->details; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="submit" name="Update_Asset" class="btn btn-warning mt-3">Cập nhật</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="badge badge-danger" data-toggle="modal" href="#delete_<?php echo $asset->id; ?>">Xóa</a>
                                            <!-- Xóa tài sản -->
                                            <div class="modal fade" id="delete_<?php echo $asset->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">XÁC NHẬN</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center text-danger">
                                                            <h4>Xóa tài sản <?php echo $asset->name; ?>?</h4>
                                                            <br>
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                            <a href="inventory_assets.php?Delete=<?php echo $asset->id; ?>" class="text-center btn btn-danger"> Xóa </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <?php require_once("../partials/footer.php"); ?>
    </div>
    <?php require_once("../partials/scripts.php"); ?>
</body>

</html>