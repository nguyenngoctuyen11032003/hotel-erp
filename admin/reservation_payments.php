<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Invoke Admin Check Login */

if (isset($_GET['delete'])) {
    /* Delete Reservation Payment */
    $id = $_GET['delete'];
    $adn = "DELETE FROM payments WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa" && header("refresh:1; url=reservation_payments.php");
    } else {
        //inject alert that task failed
        $info = "Vui lòng thử lại sau";
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
                            <h1>Quản lý thanh toán đặt phòng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item"><a href="reservations.php">Đặt phòng</a></li>
                                <li class="breadcrumb-item active">Thanh toán</li>
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
                        <a href="add_reservation_payment.php" class="btn btn-primary">Thêm thanh toán đặt phòng</a>
                    </div>
                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã thanh toán</th>
                                    <th>Số tiền</th>
                                    <th>Tên khách hàng</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Ngày thanh toán</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `payments` WHERE service_paid ='Reservations' ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($payments = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $payments->code; ?></td>
                                        <td>Ksh <?php echo $payments->amt; ?></td>
                                        <td><?php echo $payments->cust_name; ?></td>
                                        <td><?php echo $payments->payment_means; ?></td>
                                        <td><?php echo date('d M Y', strtotime($payments->created_at)); ?></td>
                                        <td>
                                            <a class="badge badge-success" data-toggle="modal" href="#receipt-<?php echo $payments->id; ?>">In hóa đơn</a>
                                            <!-- Print Receipt -->
                                            <div class="modal fade" id="receipt-<?php echo $payments->id; ?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div id="Print_Receipt" class="invoice p-3 mb-3">
                                                                <div class="row">
                                                                    <div class="col-12 ">
                                                                        <h4 class="text-center">
                                                                            <img height="100" width="200" src="../public/uploads/sys_logo/logo.png" class="img-thumbnail img-fluid" alt="System Logo">
                                                                            <br>
                                                                            <small class="float-right">Ngày: <?php echo date('d M Y');?></small>
                                                                        </h4>
                                                                        <h4>
                                                                        NT Hotels Inc
                                                                        </h4>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-12 table-responsive">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Tên khách hàng</th>
                                                                                    <th>Số tiền đã thanh toán</th>
                                                                                    <th>Dịch vụ đã thanh toán</th>
                                                                                    <th>Phương thức thanh toán</th>
                                                                                    <th>Mã thanh toán</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><?php echo $payments->cust_name;?></td>
                                                                                    <td>Ksh <?php echo $payments->amt;?></td>
                                                                                    <td><?php echo $payments->service_paid;?></td>
                                                                                    <td><?php echo $payments->payment_means;?></td>
                                                                                    <td><?php echo $payments->code;?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                            
                                                            <button id="print" onclick="printContent('Print_Receipt');"  type="button" class="btn btn-primary" >In</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Print Receipt -->
                                            <a class="badge badge-danger" data-toggle="modal" href="#delete-<?php echo $payments->id; ?>">Xóa</a>
                                            <!-- Delete Confirmation -->
                                            <div class="modal fade" id="delete-<?php echo $payments->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">XÁC NHẬN</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center text-danger">
                                                            <h4>Xóa bản ghi thanh toán đặt phòng của <?php echo $payments->cust_name; ?>?</h4>
                                                            <br>
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                            <a href="reservation_payments.php?delete=<?php echo $payments->id; ?>" class="text-center btn btn-danger"> Xóa </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Confirmation -->

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