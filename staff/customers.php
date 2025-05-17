<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
staff(); /* Invoke Staff Check Login */

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

require_once('../partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once('../partials/admin_nav.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once('../partials/staff_sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Quản lý khách hàng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Trang chủ</a></li>
                                <li class="breadcrumb-item active">Khách hàng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
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
                        <div class="card-header">
                            <h3 class="card-title">Danh sách khách hàng</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">Mã</th>
                                            <th style="width: 15%">Họ tên</th>
                                            <th style="width: 10%">Số điện thoại</th>
                                            <th style="width: 15%">Email</th>
                                            <th style="width: 10%">CMND/CCCD</th>
                                            <th style="width: 15%">Địa chỉ</th>
                                            <th style="width: 8%">Số phòng</th>
                                            <th style="width: 8%">Nhận phòng</th>
                                            <th style="width: 8%">Trả phòng</th>
                                            <th style="width: 8%">Trạng thái</th>
                                            <th style="width: 8%">Thao tác</th>
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
                                            <td><?php echo htmlspecialchars($r->room_number); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($r->check_in)); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($r->check_out)); ?></td>
                                            <td>
                                                <?php
                                                if ($r->status == 'Pending') {
                                                    echo '<span class="badge badge-warning">Chờ xác nhận</span>';
                                                } elseif ($r->status == 'Paid' || $r->status == 'Đã thanh toán') {
                                                    echo '<span class="badge badge-success">Đã thanh toán</span>';
                                                } elseif ($r->status == 'Checked In' || $r->status == 'Đã nhận phòng') {
                                                    echo '<span class="badge badge-primary">Đã nhận phòng</span>';
                                                } elseif ($r->status == 'Checked Out' || $r->status == 'Đã trả phòng') {
                                                    echo '<span class="badge badge-info">Đã trả phòng</span>';
                                                } elseif ($r->status == 'Cancelled' || $r->status == 'Đã hủy') {
                                                    echo '<span class="badge badge-danger">Đã hủy</span>';
                                                } else {
                                                    echo '<span class="badge badge-secondary">' . htmlspecialchars($r->status) . '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <!-- Nút Chi tiết: chuyển hướng sang reservations.php -->
                                                <a href="reservations.php?view=<?php echo htmlspecialchars($r->id); ?>" class="btn btn-sm btn-info">Chi tiết</a>
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