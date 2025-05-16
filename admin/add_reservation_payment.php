<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Gọi kiểm tra đăng nhập Admin */

if (isset($_POST['Pay_Reservation'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "ID thanh toán không được để trống";
    }

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    } else {
        $error = 1;
        $err = "Mã thanh toán không được để trống";
    }

    if (isset($_POST['payment_means']) && !empty($_POST['payment_means'])) {
        $payment_means = mysqli_real_escape_string($mysqli, trim($_POST['payment_means']));
    } else {
        $error = 1;
        $err = "Phương thức thanh toán không được để trống";
    }

    if (isset($_POST['amt']) && !empty($_POST['amt'])) {
        $amt = mysqli_real_escape_string($mysqli, trim($_POST['amt']));
    } else {
        $error = 1;
        $err = "Số tiền thanh toán không được để trống";
    }

    if (isset($_POST['cust_name']) && !empty($_POST['cust_name'])) {
        $cust_name = mysqli_real_escape_string($mysqli, trim($_POST['cust_name']));
    } else {
        $error = 1;
        $err = "Tên khách hàng không được để trống";
    }

    if (isset($_POST['service_paid']) && !empty($_POST['service_paid'])) {
        $service_paid = mysqli_real_escape_string($mysqli, trim($_POST['service_paid']));
    } else {
        $error = 1;
        $err = "Dịch vụ đã thanh toán không được để trống";
    }

    /* Không cần xử lý lỗi cho những trường này */
    $month = $_POST['month'];
    $status = $_POST['status'];
    $r_id = $_POST['r_id'];

    if (!$error) {
        // Ngăn chặn việc nhập trùng thanh toán
        $sql = "SELECT * FROM  payments WHERE code = '$code'  ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($code == $row['code']) {
                $err =  "Một thanh toán với mã đó đã tồn tại";
            } else {
                //
            }
        } else {
            $query = "INSERT INTO payments (id, code, payment_means, amt, cust_name, service_paid, month) VALUES (?,?,?,?,?,?,?)";
            $r_qry = "UPDATE reservations SET status =? WHERE id =?";
            $stmt = $mysqli->prepare($query);
            $rstmt = $mysqli->prepare($r_qry);
            $rc = $rstmt->bind_param('ss', $status, $r_id);
            $rc = $stmt->bind_param('sssssss', $id, $code, $payment_means, $amt, $cust_name, $service_paid, $month);
            $stmt->execute();
            $rstmt->execute();
            if ($stmt && $rstmt) {
                $success = "Đã thanh toán" && header("refresh:1; url=add_reservation_payment.php");
            } else {
                $info = "Vui lòng thử lại hoặc thử lại sau";
            }
        }
    }
}

// Xử lý xóa đặt phòng khi có tham số delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM reservations WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    if ($stmt) {
        header("Location: add_reservation_payment.php");
        exit();
    } else {
        $err = "Không thể xóa đặt phòng. Vui lòng thử lại.";
    }
}

if (isset($_GET['pay'])) {
    // Lấy thông tin đặt phòng để thanh toán
    $reservation_id = $_GET['pay'];
    $ret = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $reservation_id);
    $stmt->execute();
    $reservation = $stmt->get_result()->fetch_object();
    if ($reservation) {
        // Tính số ngày đặt và số tiền
        $date1 = date_create($reservation->check_in);
        $date2 = date_create($reservation->check_out);
        $diff = date_diff($date1, $date2);
        $days_stayed = $diff->format("%a");
        $amount = $days_stayed * $reservation->room_cost;
        // Hiển thị form xác nhận thanh toán
        ?>
        <div class="modal show" style="display:block; background:rgba(0,0,0,0.3);" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Xác nhận thanh toán đặt phòng</h4>
                        </div>
                        <div class="modal-body">
                            <div style="display:none">
                                <input type="text" name="id" value="<?php echo $ID; ?>" class="form-control">
                                <input type="text" name="month" value="<?php echo date('M'); ?>" class="form-control">
                                <input type="text" name="service_paid" value="Reservations" class="form-control">
                                <input type="text" name="r_id" value="<?php echo $reservation->id; ?>" class="form-control">
                                <input type="text" name="status" value="Paid" class="form-control">
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label>Tên khách hàng</label>
                                    <input required type="text" value="<?php echo $reservation->cust_name; ?>" readonly name="cust_name" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Số tiền thanh toán</label>
                                    <input required type="text" value="<?php echo $amount; ?>" readonly name="amt" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Mã thanh toán</label>
                                    <input required type="text" value="<?php echo $paycode; ?>" name="code" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phương thức thanh toán</label>
                                    <select class='form-control' name="payment_means">
                                        <option selected>Tiền mặt</option>
                                        <option>Mpesa</option>
                                        <option>Thẻ tín dụng</option>
                                        <option>Airtel Money</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" name="Pay_Reservation" class="btn btn-primary">Xác nhận</button>
                            <a href="add_reservation_payment.php" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            // Đóng modal khi nhấn Hủy hoặc sau khi thanh toán thành công
            document.body.classList.add('modal-open');
        </script>
        <?php
    }
}

require_once("../partials/head.php");
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
                            <h1>Thêm thanh toán đặt phòng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item"><a href="reservations.php">Đặt phòng</a></li>
                                <li class="breadcrumb-item"><a href="reservation_payments.php">Thanh toán</a></li>
                                <li class="breadcrumb-item active">Thêm thanh toán</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Số phòng</th>
                                    <th>Ngày nhận phòng</th>
                                    <th>Ngày trả phòng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số ngày đặt</th>
                                    <th>Số tiền</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `reservations` WHERE status ='Pending' ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($reservation = $res->fetch_object()) {
                                    // Lấy số ngày đã đặt phòng
                                    $date1 = date_create("$reservation->check_in");
                                    $date2 = date_create("$reservation->check_out");

                                    $diff = date_diff($date1, $date2);
                                    $days_stayed =  $diff->format("%a");

                                    // Thanh toán
                                    $amount = $days_stayed * $reservation->room_cost;

                                ?>
                                    <tr>
                                        <td><?php echo $reservation->room_number; ?></td>
                                        <td><?php echo $reservation->check_in; ?></td>
                                        <td><?php echo $reservation->check_out; ?></td>
                                        <td><?php echo $reservation->cust_name; ?></td>
                                        <td><?php echo $days_stayed; ?> Ngày</td>
                                        <td><?php echo number_format($reservation->room_cost, 0, ',', ',') . ' VND'; ?></td>
                                        <td><?php echo date('d M Y', strtotime($reservation->created_at)); ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 6px;">
                                                <a href="add_reservation_payment.php?pay=<?php echo $reservation->id; ?>" class="btn btn-warning btn-sm" style="min-width:120px;">Thanh toán</a>
                                                <a href="add_reservation_payment.php?delete=<?php echo $reservation->id; ?>" class="btn btn-danger btn-sm" style="min-width:60px;" onclick="return confirm('Bạn có chắc chắn muốn xóa đặt phòng này?');">Xóa</a>
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