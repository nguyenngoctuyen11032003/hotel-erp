<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Invoke Admin Check Login */

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
                            <h1>Báo cáo đặt phòng và lưu trú</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Báo cáo</a></li>
                                <li class="breadcrumb-item active">Đặt phòng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <hr>
                    <div class="col-12">
                        <table id="reports" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Số phòng</th>
                                    <th>Loại phòng</th>
                                    <th>Ngày nhận phòng</th>
                                    <th>Ngày trả phòng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số CMND/CCCD</th>
                                    <th>Trạng thái thanh toán</th>
                                    <th>Ngày đặt phòng</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `reservations` ORDER BY `reservations`.`created_at` DESC";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($reservation = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $reservation->room_number; ?></td>
                                        <td><?php echo $reservation->room_type; ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($reservation->check_in)); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($reservation->check_out)); ?></td>
                                        <td><?php echo $reservation->cust_name; ?></td>
                                        <td><?php echo $reservation->cust_id; ?></td>
                                        <td>
                                            <?php
                                            // Dịch trạng thái Pending sang tiếng Việt
                                            if ($reservation->status == 'Pending') {
                                                echo '<span class="badge badge-warning">Chờ xác nhận</span>';
                                            } elseif ($reservation->status == 'Paid') {
                                                echo '<span class="badge badge-success">Đã thanh toán</span>';
                                            } elseif ($reservation->status == 'Checked In') {
                                                echo '<span class="badge badge-primary">Đã nhận phòng</span>';
                                            } elseif ($reservation->status == 'Checked Out') {
                                                echo '<span class="badge badge-info">Đã trả phòng</span>';
                                            } elseif ($reservation->status == 'Cancelled') {
                                                echo '<span class="badge badge-danger">Đã hủy</span>';
                                            } else {
                                                echo '<span class="badge badge-secondary">' . htmlspecialchars($reservation->status) . '</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo date('d-M-Y g:ia', strtotime($reservation->created_at)); ?></td>
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