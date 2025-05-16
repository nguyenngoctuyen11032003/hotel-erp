<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
staff(); /* Invoke Staff Check Login */
require_once('../partials/analytics.php');
require_once("../partials/head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once('../partials/admin_nav.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once('../partials/staff_sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Bảng điều khiển</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Trang chủ</a></li>
                                <li class="breadcrumb-item active">Bảng điều khiển</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bed"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Tổng số phòng khách sạn</span>
                                    <span class="info-box-number">
                                        <?php echo $rooms; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Phòng đã sử dụng</span>
                                    <span class="info-box-number"><?php echo $rooms_occupied; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-down"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Phòng còn trống</span>
                                    <span class="info-box-number"><?php echo $rooms_vacant; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Doanh thu phòng</span>
                                    <span class="info-box-number">
                                        <?php echo number_format($accomodation, 0, ',', ','); ?> VND
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-basket"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Doanh thu nhà hàng</span>
                                    <span class="info-box-number"><?php echo number_format($Resturant_Service, 0, ',', ','); ?> VND</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Doanh thu theo loại phòng</h5>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="chart">
                                                <canvas id="RoomsIncome" style="height: 200px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-6 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header"><?php echo number_format($Resturant_Service + $accomodation, 0, ',', ','); ?> VND</h5>
                                                <span class="description-text">Tổng doanh thu</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header"><?php echo number_format(($Resturant_Service + $accomodation) - ($salary), 0, ',', ','); ?> VND</h5>
                                                <span class="description-text">Lợi nhuận sau lương</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Biểu đồ số lượng theo loại phòng</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-md-flex">
                                        <canvas id="NumberOfRoomsAsType" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Biểu đồ đặt phòng theo loại phòng</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-md-flex">
                                        <div class="table-responsive">
                                            <canvas id="roomReservations" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Đặt phòng gần đây</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-md-flex">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Số phòng</th>
                                                    <th>Giá</th>
                                                    <th>Khách hàng</th>
                                                    <th>Thời gian đặt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM `reservations` ORDER BY `reservations`.`created_at` DESC LIMIT 5";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($reservation = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="td-content"><span class="badge badge-success"><?php echo $reservation->room_number; ?></span></div>
                                                        </td>
                                                        <td>
                                                            <?php echo number_format($reservation->room_cost, 0, ',', ','); ?> VND
                                                        </td>
                                                        <td>
                                                            <?php echo $reservation->cust_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo date('d/m/Y H:i', strtotime($reservation->created_at)); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Thanh toán gần đây</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-md-flex">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Mã thanh toán</th>
                                                        <th>Số tiền</th>
                                                        <th>Dịch vụ</th>
                                                        <th>Ngày thanh toán</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ret = "SELECT * FROM `payments` ORDER BY `payments`.`created_at` DESC LIMIT 5";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();
                                                    while ($payments = $res->fetch_object()) {
                                                        // Dịch vụ tiếng Việt
                                                        $service_vn = $payments->service_paid;
                                                        if ($service_vn == 'Resturant Sales') $service_vn = 'Doanh thu nhà hàng';
                                                        elseif ($service_vn == 'Reservations' || $service_vn == 'Đặt phòng') $service_vn = 'Đặt phòng';
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <div class="td-content"><span class="badge badge-success"><?php echo $payments->code; ?></span></div>
                                                            </td>
                                                            <td>
                                                                <?php echo number_format($payments->amt, 0, ',', ','); ?> VND
                                                            </td>
                                                            <td>
                                                                <?php echo $service_vn; ?>
                                                            </td>
                                                            <td>
                                                                <span class="text-center badge bg-primary"><?php echo date('d/m/Y H:i', strtotime($payments->created_at)); ?> </span>
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
                </div>
            </section>
        </div>
        <!-- Main Footer -->
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->

    <?php
    require_once('../partials/scripts.php');
    require_once("../partials/charts.php");
    ?>

</body>

</html>