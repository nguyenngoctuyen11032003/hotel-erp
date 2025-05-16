<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
sudo(); /* Gọi kiểm tra đăng nhập Admin */

// Xử lý thêm/cập nhật/xóa khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $id_number = trim($_POST['id_number'] ?? '');
    $id = $_POST['id'] ?? null;

    if (isset($_POST['Add_Customer'])) {
        $created_at = date('Y-m-d H:i:s');
        // Sinh mã khách hàng ngắn 8 ký tự (chữ + số)
        $short_id = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        $stmt = $mysqli->prepare("INSERT INTO customers (id, name, phone, email, address, id_number, created_at) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss', $short_id, $name, $phone, $email, $address, $id_number, $created_at);
        $stmt->execute();
        $success = $stmt ? "Đã thêm khách hàng thành công" : "Vui lòng thử lại";
    }
    if (isset($_POST['Update_Customer'])) {
        $stmt = $mysqli->prepare("UPDATE customers SET name=?, phone=?, email=?, address=?, id_number=? WHERE id=?");
        $stmt->bind_param('ssssss', $name, $phone, $email, $address, $id_number, $id);
        $stmt->execute();
        $success = $stmt ? "Đã cập nhật khách hàng thành công" : "Vui lòng thử lại";
    }
}
if (isset($_GET['Delete_Customer'])) {
    $id = $_GET['Delete_Customer'];
    $stmt = $mysqli->prepare("DELETE FROM customers WHERE id=?");
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
                    <!-- Form thêm khách hàng -->
                    <div class="card mb-3">
                        <div class="card-header"><h3 class="card-title">Thêm khách hàng mới</h3></div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Họ tên</label>
                                        <input type="text" name="name" required class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Số điện thoại</label>
                                        <input type="text" name="phone" required class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>CMND/CCCD</label>
                                        <input type="text" name="id_number" class="form-control">
                                    </div>
                                    <div class="col-md-8 mb-2">
                                        <label>Địa chỉ</label>
                                        <textarea name="address" class="form-control" rows="1"></textarea>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" name="Add_Customer" class="btn btn-primary">Thêm khách hàng</button>
                                    </div>
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
                                            <th>Số phòng</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT * FROM reservations ORDER BY created_at DESC";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($r = $res->fetch_object()) {
                                            $status = '';
                                            if ($r->status == 'Pending') $status = '<span class="badge badge-warning">Chờ xác nhận</span>';
                                            elseif ($r->status == 'Checked In') $status = '<span class="badge badge-success">Đã nhận phòng</span>';
                                            elseif ($r->status == 'Checked Out') $status = '<span class="badge badge-info">Đã trả phòng</span>';
                                            elseif ($r->status == 'Cancelled') $status = '<span class="badge badge-danger">Đã hủy</span>';
                                            else $status = '<span class="badge badge-secondary">' . htmlspecialchars($r->status) . '</span>';
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($r->id); ?></td>
                                            <td><?php echo $r->cust_name; ?></td>
                                            <td><?php echo $r->cust_phone; ?></td>
                                            <td><?php echo $r->cust_email; ?></td>
                                            <td><?php echo $r->cust_id; ?></td>
                                            <td><?php echo $r->cust_adr; ?></td>
                                            <td><?php echo $r->room_number; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($r->check_in)); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($r->check_out)); ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td>
                                                <a href="reservations.php?view=<?php echo $r->id; ?>" class="btn btn-sm btn-info">Chi tiết</a>
                                                <a href="customers.php?Delete_Customer=<?php echo htmlspecialchars($r->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">Xóa</a>
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
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>
</html>