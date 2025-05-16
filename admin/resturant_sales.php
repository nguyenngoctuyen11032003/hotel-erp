<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Invoke Admin Check Login */

if (isset($_POST['Add_Sale'])) {

    /* Error Handling */
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
        $err = "Dịch vụ thanh toán không được để trống";
    }

    if (isset($_POST['month']) && !empty($_POST['month'])) {
        $month = mysqli_real_escape_string($mysqli, trim($_POST['month']));
    } else {
        $error = 1;
        $err = "Tháng thanh toán không được để trống";
    }
    /* Prevent Double Entrie */
    if (!$error) {
        //Prevent Double Entries
        $sql = "SELECT * FROM  payments WHERE code = '$code'  ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($code == $row['code']) {
                $err =  "Một thanh toán với mã này đã tồn tại";
            } else {
                //
            }
        } else {
            $query = "INSERT INTO payments (id, code, payment_means, amt, cust_name, service_paid, month) VALUES (?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('sssssss', $id, $code, $payment_means, $amt, $cust_name, $service_paid, $month);
            $stmt->execute();
            if ($stmt) {
                $success = "Đã thêm" && header("refresh:1; url=resturant_sales.php");
            } else {
                $info = "Vui lòng thử lại hoặc thử lại sau";
            }
        }
    }
}

if (isset($_POST['Update_Sale'])) {

    /* Error Handling And Update Sale */
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
        $err = "Dịch vụ thanh toán không được để trống";
    }

    if (isset($_POST['month']) && !empty($_POST['month'])) {
        $month = mysqli_real_escape_string($mysqli, trim($_POST['month']));
    } else {
        $error = 1;
        $err = "Tháng thanh toán không được để trống";
    }
    /* Prevent Double Entrie */
    if (!$error) {

        $query = "UPDATE payments SET  code =?, payment_means =?, amt =?, cust_name =?, service_paid =?, month =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssssss', $code, $payment_means, $amt, $cust_name, $service_paid, $month, $id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật" && header("refresh:1; url=resturant_sales.php");
        } else {
            $info = "Vui lòng thử lại hoặc thử lại sau";
        }
    }
}



if (isset($_GET['delete'])) {
    /* Delete Sale */
    $id = $_GET['delete'];
    $adn = "DELETE FROM payments WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa" && header("refresh:1; url=resturant_sales.php");
    } else {
        $info = "Vui lòng thử lại hoặc thử lại sau";
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
                            <h1>Quản lý doanh thu nhà hàng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Doanh thu nhà hàng</li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-sale">Thêm Doanh Thu Nhà Hàng</button>
                    </div>
                    <!-- Add Sale Modal -->
                    <div class="modal fade" id="add-sale">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Thêm doanh thu nhà hàng</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                <input type="text" name="service_paid" value="Resturant Sales" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Mã doanh thu</label>
                                                <input required type="text" value="<?php echo $paycode; ?>" name="code" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Phương thức thanh toán</label>
                                                <select class='form-control' name="payment_means" id="">
                                                    <option selected>Tiền mặt</option>
                                                    <option>Mpesa</option>
                                                    <option>Thẻ tín dụng</option>
                                                    <option>Airtel Money</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Tên khách hàng</label>
                                                <input required type="text" name="cust_name" class="form-control">

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Số tiền</label>
                                                <input required type="text" name="amt" class="form-control">
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" name="Add_Sale" class="btn btn-primary mt-3">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./End Modal -->
                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã doanh thu</th>
                                    <th>Số tiền</th>
                                    <th>Tên khách hàng</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Ngày thanh toán</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `payments` WHERE service_paid ='Resturant Sales' ORDER BY `payments`.`created_at` ASC ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($payments = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $payments->code; ?></td>
                                        <td><?php echo number_format($payments->amt, 0, ',', ',') . ' VND'; ?></td>
                                        <td><?php echo $payments->cust_name; ?></td>
                                        <td><?php echo $payments->payment_means; ?></td>
                                        <td><?php echo date('d M Y g:ia', strtotime($payments->created_at)); ?></td>
                                        <td>
                                            <a class="badge badge-success" data-toggle="modal" href="#receipt-<?php echo $payments->id; ?>">Hóa đơn</a>
                                            <!-- Receipt Modal -->
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
                                                                            <small class="float-right">Ngày: <?php echo date('d M Y'); ?></small>
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
                                                                                    <td><?php echo $payments->cust_name; ?></td>
                                                                                    <td>Ksh <?php echo $payments->amt; ?></td>
                                                                                    <td><?php echo $payments->service_paid; ?></td>
                                                                                    <td><?php echo $payments->payment_means; ?></td>
                                                                                    <td><?php echo $payments->code; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                                                            <button id="print" onclick="printContent('Print_Receipt');" type="button" class="btn btn-primary">In</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="badge badge-primary" data-toggle="modal" href="#update-<?php echo $payments->id; ?>">Cập nhật</a>
                                            <!-- Update Modal -->
                                            <div class="modal fade" id="update-<?php echo $payments->id; ?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Cập nhật doanh thu nhà hàng: <?php echo $payments->cust_name; ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="form-row mb-4">
                                                                    <div style="display:none" class="form-group col-md-6">
                                                                        <label for="inputEmail4">Id</label>
                                                                        <input type="text" name="id" value="<?php echo $payments->id; ?>" class="form-control">
                                                                        <input type="text" name="month" value="<?php echo date('M'); ?>" class="form-control">
                                                                        <input type="text" name="service_paid" value="Resturant Sales" class="form-control">

                                                                    </div>
                                                                </div>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Mã doanh thu</label>
                                                                        <input required type="text" value="<?php echo $payments->code; ?>" name="code" class="form-control">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Phương thức thanh toán</label>
                                                                        <select class='form-control' name="payment_means" id="">
                                                                            <option><?php echo $payments->payment_means; ?></option>
                                                                            <option>Tiền mặt</option>
                                                                            <option>Mpesa</option>
                                                                            <option>Thẻ tín dụng</option>
                                                                            <option>Airtel Money</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Tên khách hàng</label>
                                                                        <input required type="text" value="<?php echo $payments->cust_name; ?>" name="cust_name" class="form-control">

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Số tiền</label>
                                                                        <input required type="text" value="<?php echo $payments->amt; ?>" name="amt" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="text-right">
                                                                    <button type="submit" name="Update_Sale" class="btn btn-primary mt-3">Gửi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="badge badge-danger" data-toggle="modal" href="#delete-<?php echo $payments->id; ?>">Xóa</a>
                                            <!-- Delete Modal -->
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
                                                            <h4>Xóa doanh thu <?php echo $payments->code; ?>?</h4>
                                                            <br>
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                            <a href="resturant_sales.php?delete=<?php echo $payments->id; ?>" class="text-center btn btn-danger">Xóa</a>
                                                        </div>
                                                    </div>
                                                </div>
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