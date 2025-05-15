<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Invoke Admin Check Login */

if (isset($_POST['Add_Roomservice'])) {
    /* Error Handling  */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "ID Dịch Vụ Phòng Không Được Để Trống";
    }

    if (isset($_POST['room_id']) && !empty($_POST['room_id'])) {
        $room_id = mysqli_real_escape_string($mysqli, trim($_POST['room_id']));
    } else {
        $error = 1;
        $err = "ID Phòng Không Được Để Trống";
    }

    if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
        $staff_id = mysqli_real_escape_string($mysqli, trim($_POST['staff_id']));
    } else {
        $error = 1;
        $err = "ID Nhân Viên Không Được Để Trống";
    }

    if (isset($_POST['staff_name']) && !empty($_POST['staff_name'])) {
        $staff_name = mysqli_real_escape_string($mysqli, trim($_POST['staff_name']));
    } else {
        $error = 1;
        $err = "Tên Nhân Viên Không Được Để Trống";
    }

    if (isset($_POST['staff_number']) && !empty($_POST['staff_number'])) {
        $staff_number = mysqli_real_escape_string($mysqli, trim($_POST['staff_number']));
    } else {
        $error = 1;
        $err = "Số Nhân Viên Không Được Để Trống";
    }

    if (isset($_POST['room_number']) && !empty($_POST['room_number'])) {
        $room_number = mysqli_real_escape_string($mysqli, trim($_POST['room_number']));
    } else {
        $error = 1;
        $err = "Số Phòng Không Được Để Trống";
    }

    if (!$error) {

        $query = "INSERT INTO room_service (id, room_id, staff_id, room_number, staff_number, staff_name) VALUES (?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssssss', $id, $room_id, $staff_id, $room_number, $staff_number, $staff_name);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã Thêm" && header("refresh:1; url=room_service.php");
        } else {
            $info = "Vui Lòng Thử Lại Hoặc Thử Sau";
        }
    }
}

if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $adn = "DELETE FROM room_service WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã Xóa" && header("refresh:1; url=room_service.php");
    } else {
        $info = "Vui Lòng Thử Lại Hoặc Thử Sau";
    }
}

require_once("../partials/head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once("../partials/admin_nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once("../partials/admin_sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dịch Vụ Phòng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng Điều Khiển</a></li>
                                <li class="breadcrumb-item active">Dịch Vụ Phòng</li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Thêm Phân Công Dịch Vụ Phòng</button>
                    </div>
                    <!-- Add  Modal -->
                    <div class="modal fade" id="add_modal">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Điền Tất Cả Các Giá Trị</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-row mb-4">
                                            <div style="display:none" class="form-group col-md-6">
                                                <label for="inputEmail4">Id</label>
                                                <input type="text" name="id" value="<?php echo $ID; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Số Nhân Viên</label>
                                                <select name="staff_number" class="form-control" id="StaffNumber" onchange="getStaffDetails(this.value);">
                                                    <option>Chọn Số Nhân Viên</option>
                                                    <?php
                                                    $ret = "SELECT * FROM `staffs`  ORDER BY `staffs`.`name` ASC ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($staff = $res->fetch_object()) {
                                                    ?>
                                                        <option><?php echo $staff->number; ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Số Phòng</label>
                                                <select name="room_number" class="form-control" id="RNumber" onchange="getRoomDetails(this.value);">
                                                    <option>Chọn Số Phòng</option>
                                                    <?php
                                                    $ret = "SELECT * FROM `rooms`   ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($rooms = $res->fetch_object()) {
                                                    ?>
                                                        <option><?php echo $rooms->number; ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Tên Nhân Viên</label>
                                                <input required type="text" id="StaffName" name="staff_name" class="form-control">
                                                <input required type="hidden" id="StaffID" name="staff_id" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input required type="hidden" ID="RID" name="room_id" class="form-control">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="Add_Roomservice" class="btn btn-warning mt-3">Gửi</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End  Modal -->

                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Số Nhân Viên</th>
                                    <th>Tên</th>
                                    <th>Phòng Được Phân Công</th>
                                    <th>Ngày Phân Công</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `room_service`  ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($service = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $service->staff_number; ?></td>
                                        <td><?php echo $service->staff_name; ?></td>
                                        <td><?php echo $service->room_number; ?></td>
                                        <td><?php echo date('d M Y g:ia', strtotime($service->created_at)); ?></td>
                                        <td>

                                            <a class="badge badge-danger" data-toggle="modal" href="#delete_<?php echo $service->id; ?>">Xóa</a>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete_<?php echo $service->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">XÁC NHẬN</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center text-danger">
                                                            <h4>Xóa Bản Ghi Phân Công Dịch Vụ Phòng Của <?php echo $service->staff_name; ?>?</h4>
                                                            <br>
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                            <a href="room_service.php?Delete=<?php echo $service->id; ?>" class="text-center btn btn-danger">Xóa</a>
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