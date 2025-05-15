<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Gọi kiểm tra đăng nhập Admin */

if (isset($_POST['Add_Attendance'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
        $staff_id = mysqli_real_escape_string($mysqli, trim($_POST['staff_id']));
    } else {
        $error = 1;
        $err = "ID nhân viên không được để trống";
    }

    if (isset($_POST['date']) && !empty($_POST['date'])) {
        $date = mysqli_real_escape_string($mysqli, trim($_POST['date']));
    } else {
        $error = 1;
        $err = "Ngày không được để trống";
    }

    if (isset($_POST['check_in']) && !empty($_POST['check_in'])) {
        $check_in = mysqli_real_escape_string($mysqli, trim($_POST['check_in']));
    } else {
        $error = 1;
        $err = "Thời gian vào không được để trống";
    }

    if (isset($_POST['check_out']) && !empty($_POST['check_out'])) {
        $check_out = mysqli_real_escape_string($mysqli, trim($_POST['check_out']));
    } else {
        $error = 1;
        $err = "Thời gian ra không được để trống";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Trạng thái không được để trống";
    }

    if (!$error) {
        // Kiểm tra xem sự hiện diện của nhân viên này vào ngày này đã tồn tại chưa
        $sql = "SELECT * FROM attendance WHERE staff_id = '$staff_id' AND date = '$date'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $err = "Sự hiện diện của nhân viên này vào ngày này đã tồn tại";
        } else {
            $query = "INSERT INTO attendance (staff_id, date, check_in, check_out, status) VALUES (?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('sssss', $staff_id, $date, $check_in, $check_out, $status);
            $stmt->execute();
            if ($stmt) {
                $success = "Đã thêm sự hiện diện thành công" && header("refresh:1; url=attendance.php");
            } else {
                $info = "Vui lòng thử lại hoặc thử lại sau";
            }
        }
    }
}

if (isset($_POST['Update_Attendance'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "ID sự hiện diện không được để trống";
    }

    if (isset($_POST['check_in']) && !empty($_POST['check_in'])) {
        $check_in = mysqli_real_escape_string($mysqli, trim($_POST['check_in']));
    } else {
        $error = 1;
        $err = "Thời gian vào không được để trống";
    }

    if (isset($_POST['check_out']) && !empty($_POST['check_out'])) {
        $check_out = mysqli_real_escape_string($mysqli, trim($_POST['check_out']));
    } else {
        $error = 1;
        $err = "Thời gian ra không được để trống";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Trạng thái không được để trống";
    }

    if (!$error) {
        $query = "UPDATE attendance SET check_in =?, check_out =?, status =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssss', $check_in, $check_out, $status, $id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật sự hiện diện thành công" && header("refresh:1; url=attendance.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}

if (isset($_GET['Delete_Attendance'])) {
    $id = $_GET['Delete_Attendance'];
    $adn = "DELETE FROM attendance WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa sự hiện diện thành công" && header("refresh:1; url=attendance.php");
    } else {
        $info = "Vui lòng thử lại hoặc thử lại sau";
    }
}

require_once('../partials/head.php');
?>

<body>
    <!-- Thanh bên trái -->
    <?php require_once('../partials/admin_sidebar.php'); ?>
    <!-- Kết thúc thanh bên trái -->

    <div class="page-wrapper">
        <!-- Thanh trên cùng -->
        <?php require_once('../partials/admin_nav.php'); ?>
        <!-- Kết thúc thanh trên cùng -->

        <!-- Nội dung trang -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Tiêu đề trang -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="row">
                                <div class="col">
                                    <h4 class="page-title">Quản lý sự hiện diện của nhân viên</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                        <li class="breadcrumb-item active">Sự hiện diện</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kết thúc tiêu đề trang -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Thêm bản ghi sự hiện diện mới</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Nhân viên</label>
                                                <select name="staff_id" required class="form-control">
                                                    <option>Chọn nhân viên</option>
                                                    <?php
                                                    $ret = "SELECT * FROM staffs ORDER BY name ASC";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();
                                                    while ($staff = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $staff->id; ?>"><?php echo $staff->name; ?> - <?php echo $staff->number; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Ngày</label>
                                                <input type="date" name="date" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Thời gian vào</label>
                                                <input type="time" name="check_in" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Thời gian ra</label>
                                                <input type="time" name="check_out" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Trạng thái</label>
                                                <select name="status" required class="form-control">
                                                    <option>Chọn trạng thái</option>
                                                    <option value="Có mặt">Có mặt</option>
                                                    <option value="Muộn">Muộn</option>
                                                    <option value="Vắng mặt">Vắng mặt</option>
                                                    <option value="Nửa ngày">Nửa ngày</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="Add_Attendance" class="btn btn-primary">Thêm sự hiện diện</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Bản ghi sự hiện diện</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Nhân viên</th>
                                                <th>Ngày</th>
                                                <th>Thời gian vào</th>
                                                <th>Thời gian ra</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT a.*, s.name as staff_name, s.number as staff_number 
                                                   FROM attendance a 
                                                   INNER JOIN staffs s ON a.staff_id = s.id 
                                                   ORDER BY a.date DESC";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($attendance = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $attendance->staff_name; ?> - <?php echo $attendance->staff_number; ?></td>
                                                    <td><?php echo $attendance->date; ?></td>
                                                    <td><?php echo $attendance->check_in; ?></td>
                                                    <td><?php echo $attendance->check_out; ?></td>
                                                    <td><?php echo $attendance->status; ?></td>
                                                    <td>
                                                        <a href="#update-<?php echo $attendance->id; ?>" data-toggle="modal" class="btn btn-sm btn-primary">Cập nhật</a>
                                                        <a href="attendance.php?Delete_Attendance=<?php echo $attendance->id; ?>" class="btn btn-sm btn-danger">Xóa</a>
                                                    </td>
                                                </tr>
                                                <!-- Modal Cập nhật -->
                                                <div class="modal fade" id="update-<?php echo $attendance->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Cập nhật sự hiện diện</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>Thời gian vào</label>
                                                                                <input type="time" name="check_in" value="<?php echo $attendance->check_in; ?>" required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>Thời gian ra</label>
                                                                                <input type="time" name="check_out" value="<?php echo $attendance->check_out; ?>" required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Trạng thái</label>
                                                                                <select name="status" required class="form-control">
                                                                                    <option value="Có mặt" <?php if ($attendance->status == 'Có mặt') echo 'selected'; ?>>Có mặt</option>
                                                                                    <option value="Muộn" <?php if ($attendance->status == 'Muộn') echo 'selected'; ?>>Muộn</option>
                                                                                    <option value="Vắng mặt" <?php if ($attendance->status == 'Vắng mặt') echo 'selected'; ?>>Vắng mặt</option>
                                                                                    <option value="Nửa ngày" <?php if ($attendance->status == 'Nửa ngày') echo 'selected'; ?>>Nửa ngày</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <input type="hidden" name="id" value="<?php echo $attendance->id; ?>">
                                                                            <button type="submit" name="Update_Attendance" class="btn btn-primary">Cập nhật sự hiện diện</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc nội dung trang -->
    </div>
    <!-- Kết thúc trang-wrapper -->

    <!-- jQuery  -->
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html> 