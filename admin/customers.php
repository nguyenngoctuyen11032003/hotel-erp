<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
sudo(); /* Gọi kiểm tra đăng nhập Admin */

// Xử lý tìm kiếm khách hàng
$search_name = trim($_GET['search_name'] ?? '');
$search_phone = trim($_GET['search_phone'] ?? '');
$search_email = trim($_GET['search_email'] ?? '');
$search_id_number = trim($_GET['search_id_number'] ?? '');

$where = [];
$params = [];
$types = '';

if ($search_name !== '') {
    $where[] = "cust_name LIKE ?";
    $params[] = "%$search_name%";
    $types .= 's';
}
if ($search_phone !== '') {
    $where[] = "cust_phone LIKE ?";
    $params[] = "%$search_phone%";
    $types .= 's';
}
if ($search_email !== '') {
    $where[] = "cust_email LIKE ?";
    $params[] = "%$search_email%";
    $types .= 's';
}
if ($search_id_number !== '') {
    $where[] = "cust_id LIKE ?";
    $params[] = "%$search_id_number%";
    $types .= 's';
}

$query = "SELECT * FROM reservations";
if (count($where) > 0) {
    $query .= " WHERE " . implode(" AND ", $where);
}
$query .= " ORDER BY created_at DESC";

if (isset($_GET['Delete_Customer'])) {
    $id = $_GET['Delete_Customer'];
    $stmt = $mysqli->prepare("DELETE FROM reservations WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $success = $stmt ? "Đã xóa khách hàng thành công" : "Vui lòng thử lại";
}

require_once('../partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php require_once('../partials/admin_nav.php'); ?>
        <?php require_once('../partials/admin_sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Quản lý khách hàng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Khách hàng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <!-- Form tìm kiếm khách hàng -->
                    <div class="card mb-3">
                        <div class="card-header"><h3 class="card-title">Tìm kiếm khách hàng</h3></div>
                        <div class="card-body">
                            <form method="GET" class="row align-items-end">
                                <div class="col-md-3 mb-2">
                                    <label>Họ tên</label>
                                    <input type="text" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>" class="form-control" placeholder="Nhập họ tên">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="search_phone" value="<?php echo htmlspecialchars($search_phone); ?>" class="form-control" placeholder="Nhập số điện thoại">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>Email</label>
                                    <input type="text" name="search_email" value="<?php echo htmlspecialchars($search_email); ?>" class="form-control" placeholder="Nhập email">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>CMND/CCCD</label>
                                    <input type="text" name="search_id_number" value="<?php echo htmlspecialchars($search_id_number); ?>" class="form-control" placeholder="Nhập CMND/CCCD">
                                </div>
                                <div class="col-md-12 text-right mt-2">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    <a href="customers.php" class="btn btn-secondary">Đặt lại</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Danh sách khách hàng -->
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Danh sách khách hàng</h3></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Họ tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Email</th>
                                            <th>CCCD</th>
                                            <th>Địa chỉ</th>
                                            <th>Ngày đặt</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $mysqli->prepare($query);
                                        if (count($params) > 0) {
                                            $stmt->bind_param($types, ...$params);
                                        }
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($r = $res->fetch_object()) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(substr($r->id, 0, 8)); ?></td>
                                            <td><?php echo htmlspecialchars($r->cust_name); ?></td>
                                            <td><?php echo htmlspecialchars($r->cust_phone); ?></td>
                                            <td><?php echo htmlspecialchars($r->cust_email); ?></td>
                                            <td><?php echo htmlspecialchars($r->cust_id); ?></td>
                                            <td><?php echo htmlspecialchars($r->cust_adr); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($r->created_at)); ?></td>
                                            <td>
                                                <!-- Nút Chi tiết -->
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detail-<?php echo $r->id; ?>">Chi tiết</button>
                                                <!-- Modal Chi tiết -->
                                                <div class="modal fade" id="detail-<?php echo $r->id; ?>" tabindex="-1" role="dialog" aria-labelledby="detailLabel-<?php echo $r->id; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title" id="detailLabel-<?php echo $r->id; ?>">Chi tiết khách hàng</h5>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered mb-0">
                                                                    <tr>
                                                                        <th style="width: 35%;">Mã</th>
                                                                        <td><?php echo htmlspecialchars(substr($r->id, 0, 8)); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Họ tên</th>
                                                                        <td><?php echo htmlspecialchars($r->cust_name); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Số điện thoại</th>
                                                                        <td><?php echo htmlspecialchars($r->cust_phone); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        <td><?php echo htmlspecialchars($r->cust_email); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>CCCD</th>
                                                                        <td><?php echo htmlspecialchars($r->cust_id); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Địa chỉ</th>
                                                                        <td><?php echo htmlspecialchars($r->cust_adr); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Số phòng</th>
                                                                        <td><?php echo htmlspecialchars($r->room_number); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Nhận phòng</th>
                                                                        <td><?php echo htmlspecialchars($r->check_in); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Trả phòng</th>
                                                                        <td><?php echo htmlspecialchars($r->check_out); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Trạng thái</th>
                                                                        <td>
                                                                            <?php
                                                                            $status = $r->status;
                                                                            if ($status == 'Pending') {
                                                                                echo '<span class="badge badge-warning">Chờ xác nhận</span>';
                                                                            } elseif ($status == 'Paid' || $status == 'Đã thanh toán') {
                                                                                echo '<span class="badge badge-success">Đã thanh toán</span>';
                                                                            } elseif ($status == 'Checked In' || $status == 'Đã nhận phòng') {
                                                                                echo '<span class="badge badge-primary">Đã nhận phòng</span>';
                                                                            } elseif ($status == 'Checked Out' || $status == 'Đã trả phòng') {
                                                                                echo '<span class="badge badge-info">Đã trả phòng</span>';
                                                                            } elseif ($status == 'Cancelled' || $status == 'Đã hủy') {
                                                                                echo '<span class="badge badge-danger">Đã hủy</span>';
                                                                            } else {
                                                                                echo '<span class="badge badge-secondary">' . htmlspecialchars($status) . '</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Ngày đặt</th>
                                                                        <td><?php echo date('d/m/Y H:i', strtotime($r->created_at)); ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Nút Xóa -->
                                                <a href="customers.php?Delete_Customer=<?php echo htmlspecialchars($r->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($res->num_rows == 0): ?>
                                    <div class="text-center text-muted mt-3">Không tìm thấy khách hàng phù hợp.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>
</html>