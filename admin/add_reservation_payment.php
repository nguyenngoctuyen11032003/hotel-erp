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
                                    <th>Số ngày đã đặt</th>
                                    <th>Số tiền</th>
                                    <th>Ngày đặt</th>
                                    <th>Hành động</th>
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
                                        <td>Ksh <?php echo $amount; ?></td>
                                        <td><?php echo date('d M Y', strtotime($reservation->created_at)); ?></td>
                                        <td>
                                            <a class="badge badge-warning" data-toggle="modal" href="#pay_<?php echo $reservation->id; ?>"> Thanh toán phí đặt phòng </a>
                                            <!-- Modal Thanh toán -->
                                            <div class="modal fade " id="pay_<?php echo $reservation->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Điền tất cả các giá trị </h4>
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
                                                                        <input type="text" name="month" value="<?php echo date('M'); ?>" class="form-control">
                                                                        <input type="text" name="service_paid" value="Đặt phòng" class="form-control">
                                                                        <input type="text" name="r_id" value="<?php echo $reservation->id; ?>" class="form-control">
                                                                        <input type="text" name="status" value="Đã thanh toán" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Tên khách hàng</label>
                                                                        <input required type="text" value="<?php echo $reservation->cust_name; ?>" readonly name="cust_name" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Số tiền đặt phòng</label>
                                                                        <input required type="text" value="<?php echo $amount; ?>" readonly name="amt" class="form-control">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Mã thanh toán</label>
                                                                        <input required type="text" value="<?php echo $paycode; ?>" name="code" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Phương thức thanh toán</label>
                                                                        <select class='form-control' name="payment_means" id="">
                                                                            <option selected>Tiền mặt</option>
                                                                            <option>Mpesa</option>
                                                                            <option>Thẻ tín dụng</option>
                                                                            <option>Tiền Airtel</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="text-right">
                                                                    <button type="submit" name="Pay_Reservation" class="btn btn-primary mt-3">Gửi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Thanh toán -->
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