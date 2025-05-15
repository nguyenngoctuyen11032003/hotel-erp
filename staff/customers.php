<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
staff(); /* Invoke Staff Check Login */

// Handle Add Customer
if (isset($_POST['Add_Customer'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $id_number = $_POST['id_number'];
    $created_at = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO customers (name, phone, email, address, id_number, created_at) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('ssssss', $name, $phone, $email, $address, $id_number, $created_at);
    $stmt->execute();
    if ($stmt) {
        $success = "Customer Added Successfully";
    } else {
        $err = "Please Try Again";
    }
}

// Handle Update Customer
if (isset($_POST['Update_Customer'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $id_number = $_POST['id_number'];

    $stmt = $mysqli->prepare("UPDATE customers SET name=?, phone=?, email=?, address=?, id_number=? WHERE id=?");
    $stmt->bind_param('ssssss', $name, $phone, $email, $address, $id_number, $id);
    $stmt->execute();
    if ($stmt) {
        $success = "Customer Updated Successfully";
    } else {
        $err = "Please Try Again";
    }
}

// Handle Delete Customer
if (isset($_GET['Delete_Customer'])) {
    $id = $_GET['Delete_Customer'];
    $stmt = $mysqli->prepare("DELETE FROM customers WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    if ($stmt) {
        $success = "Customer Deleted Successfully";
    } else {
        $err = "Please Try Again";
    }
}

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
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Thêm khách hàng mới</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Họ tên</label>
                                                    <input type="text" name="name" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" name="phone" required class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CMND/CCCD</label>
                                                    <input type="text" name="id_number" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Địa chỉ</label>
                                                    <textarea name="address" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="Add_Customer" class="btn btn-primary">Thêm khách hàng</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách khách hàng</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Mã</th>
                                                    <th style="width: 15%">Họ tên</th>
                                                    <th style="width: 10%">Số điện thoại</th>
                                                    <th style="width: 15%">Email</th>
                                                    <th style="width: 10%">CCCD</th>
                                                    <th style="width: 15%">Địa chỉ</th>
                                                    <th style="width: 8%">Số phòng</th>
                                                    <th style="width: 8%">Check-in</th>
                                                    <th style="width: 8%">Check-out</th>
                                                    <th style="width: 8%">Trạng thái</th>
                                                    <th style="width: 8%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM reservations ORDER BY created_at DESC";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($reservation = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $reservation->id; ?></td>
                                                        <td><?php echo $reservation->cust_name; ?></td>
                                                        <td><?php echo $reservation->cust_phone; ?></td>
                                                        <td><?php echo $reservation->cust_email; ?></td>
                                                        <td><?php echo $reservation->cust_id; ?></td>
                                                        <td><?php echo $reservation->cust_adr; ?></td>
                                                        <td><?php echo $reservation->room_number; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($reservation->check_in)); ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($reservation->check_out)); ?></td>
                                                        <td>
                                                            <?php if($reservation->status == 'Pending') { ?>
                                                                <span class="badge badge-warning">Chờ xác nhận</span>
                                                            <?php } else if($reservation->status == 'Checked In') { ?>
                                                                <span class="badge badge-success">Đã nhận phòng</span>
                                                            <?php } else if($reservation->status == 'Checked Out') { ?>
                                                                <span class="badge badge-info">Đã trả phòng</span>
                                                            <?php } else if($reservation->status == 'Cancelled') { ?>
                                                                <span class="badge badge-danger">Đã hủy</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a href="reservations.php?view=<?php echo $reservation->id; ?>" class="btn btn-sm btn-info">Chi tiết</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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