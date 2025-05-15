<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Gọi kiểm tra đăng nhập Admin */

// Thêm chấm công
if (isset($_POST['Add_Attendance'])) {
    $error = 0;
    $staff_id = trim($_POST['staff_id'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $check_in = trim($_POST['check_in'] ?? '');
    $check_out = trim($_POST['check_out'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if (!$staff_id) { $error = 1; $err = "Vui lòng chọn nhân viên"; }
    if (!$date) { $error = 1; $err = "Vui lòng chọn ngày"; }
    if (!$check_in) { $error = 1; $err = "Vui lòng nhập giờ vào"; }
    if (!$check_out) { $error = 1; $err = "Vui lòng nhập giờ ra"; }
    if (!$status) { $error = 1; $err = "Vui lòng chọn trạng thái"; }

    if (!$error) {
        $sql = "SELECT * FROM attendance WHERE staff_id = ? AND date = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ss', $staff_id, $date);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $err = "Nhân viên này đã được chấm công ngày này";
        } else {
            $query = "INSERT INTO attendance (staff_id, date, check_in, check_out, status) VALUES (?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('sssss', $staff_id, $date, $check_in, $check_out, $status);
            $stmt->execute();
            if ($stmt) {
                $success = "Đã thêm chấm công thành công" && header("refresh:1; url=attendance.php");
            } else {
                $info = "Vui lòng thử lại hoặc thử lại sau";
            }
        }
    }
}

// Cập nhật chấm công
if (isset($_POST['Update_Attendance'])) {
    $error = 0;
    $id = trim($_POST['id'] ?? '');
    $check_in = trim($_POST['check_in'] ?? '');
    $check_out = trim($_POST['check_out'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if (!$id) { $error = 1; $err = "ID không được để trống"; }
    if (!$check_in) { $error = 1; $err = "Vui lòng nhập giờ vào"; }
    if (!$check_out) { $error = 1; $err = "Vui lòng nhập giờ ra"; }
    if (!$status) { $error = 1; $err = "Vui lòng chọn trạng thái"; }

    if (!$error) {
        $query = "UPDATE attendance SET check_in =?, check_out =?, status =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssss', $check_in, $check_out, $status, $id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật chấm công thành công" && header("refresh:1; url=attendance.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}

// Xóa chấm công
if (isset($_GET['Delete_Attendance'])) {
    $id = $_GET['Delete_Attendance'];
    $adn = "DELETE FROM attendance WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa chấm công thành công" && header("refresh:1; url=attendance.php");
    } else {
        $info = "Vui lòng thử lại hoặc thử lại sau";
    }
}

require_once('../partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php require_once('../partials/admin_sidebar.php'); ?>
    <div class="wrapper">
        <?php require_once('../partials/admin_nav.php'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Chấm công nhân viên</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Chấm công</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <!-- Thêm chấm công -->
                    <div class="card mb-3">
                        <div class="card-header"><h3 class="card-title">Thêm chấm công</h3></div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <label>Nhân viên</label>
                                        <select name="staff_id" class="form-control" required>
                                            <option value="">Chọn nhân viên</option>
                                            <?php
                                            $ret = "SELECT id, name FROM staffs ORDER BY name ASC";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($staff = $res->fetch_object()) {
                                                echo "<option value='$staff->id'>$staff->name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label>Ngày</label>
                                        <input type="date" name="date" class="form-control" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label>Giờ vào</label>
                                        <input type="time" name="check_in" class="form-control" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label>Giờ ra</label>
                                        <input type="time" name="check_out" class="form-control" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label>Trạng thái</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">Chọn trạng thái</option>
                                            <option value="Present">Có mặt</option>
                                            <option value="Absent">Vắng mặt</option>
                                            <option value="Late">Đi muộn</option>
                                            <option value="Leave">Nghỉ phép</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2 d-flex align-items-end">
                                        <button type="submit" name="Add_Attendance" class="btn btn-primary w-100">Thêm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Danh sách chấm công -->
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Danh sách chấm công</h3></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dt-1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nhân viên</th>
                                            <th>Ngày</th>
                                            <th>Giờ vào</th>
                                            <th>Giờ ra</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT a.*, s.name as staff_name FROM attendance a JOIN staffs s ON a.staff_id = s.id ORDER BY a.date DESC, a.created_at DESC";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($row = $res->fetch_object()) {
                                            $status_label = '';
                                            if ($row->status == 'Present') $status_label = '<span class="badge badge-success">Có mặt</span>';
                                            elseif ($row->status == 'Absent') $status_label = '<span class="badge badge-danger">Vắng mặt</span>';
                                            elseif ($row->status == 'Late') $status_label = '<span class="badge badge-warning">Đi muộn</span>';
                                            elseif ($row->status == 'Leave') $status_label = '<span class="badge badge-info">Nghỉ phép</span>';
                                            else $status_label = '<span class="badge badge-secondary">'.htmlspecialchars($row->status).'</span>';
                                        ?>
                                        <tr>
                                            <td><?php echo $row->staff_name; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row->date)); ?></td>
                                            <td><?php echo $row->check_in; ?></td>
                                            <td><?php echo $row->check_out; ?></td>
                                            <td><?php echo $status_label; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row->created_at)); ?></td>
                                            <td>
                                                <a class="badge badge-primary" data-toggle="modal" href="#update_<?php echo $row->id; ?>">Sửa</a>
                                                <!-- Modal cập nhật -->
                                                <div class="modal fade" id="update_<?php echo $row->id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Cập nhật chấm công</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                                                    <div class="form-group">
                                                                        <label>Giờ vào</label>
                                                                        <input type="time" name="check_in" value="<?php echo $row->check_in; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Giờ ra</label>
                                                                        <input type="time" name="check_out" value="<?php echo $row->check_out; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Trạng thái</label>
                                                                        <select name="status" class="form-control" required>
                                                                            <option <?php if($row->status=='Present') echo 'selected'; ?>>Present</option>
                                                                            <option <?php if($row->status=='Absent') echo 'selected'; ?>>Absent</option>
                                                                            <option <?php if($row->status=='Late') echo 'selected'; ?>>Late</option>
                                                                            <option <?php if($row->status=='Leave') echo 'selected'; ?>>Leave</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" name="Update_Attendance" class="btn btn-primary">Cập nhật</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="badge badge-danger" data-toggle="modal" href="#delete_<?php echo $row->id; ?>">Xóa</a>
                                                <!-- Modal xóa -->
                                                <div class="modal fade" id="delete_<?php echo $row->id; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">XÁC NHẬN</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Xóa chấm công của <?php echo $row->staff_name; ?> ngày <?php echo date('d/m/Y', strtotime($row->date)); ?>?</h4>
                                                                <button type="button" class="btn btn-success" data-dismiss="modal">Không</button>
                                                                <a href="attendance.php?Delete_Attendance=<?php echo $row->id; ?>" class="btn btn-danger">Xóa</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>
</html>