<?php
session_start();
require_once('../config/config.php');
require_once('../config/Gen.php');
require_once('../config/checklogin.php');
sudo(); /* Invoke Admin Check Login */

if (isset($_POST['Add_Payroll'])) {
    /* Error Handling  */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Không được để trống ID";
    }

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    } else {
        $error = 1;
        $err = "Không được để trống mã lương";
    }

    if (isset($_POST['month']) && !empty($_POST['month'])) {
        $month = mysqli_real_escape_string($mysqli, trim($_POST['month']));
    } else {
        $error = 1;
        $err = "Không được để trống tháng thanh toán";
    }

    if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
        $staff_id = mysqli_real_escape_string($mysqli, trim($_POST['staff_id']));
    } else {
        $error = 1;
        $err = "Không được để trống ID nhân viên";
    }

    if (isset($_POST['staff_name']) && !empty($_POST['staff_name'])) {
        $staff_name = mysqli_real_escape_string($mysqli, trim($_POST['staff_name']));
    } else {
        $error = 1;
        $err = "Không được để trống tên nhân viên";
    }

    if (isset($_POST['salary']) && !empty($_POST['salary'])) {
        $salary = mysqli_real_escape_string($mysqli, trim($_POST['salary']));
    } else {
        $error = 1;
        $err = "Không được để trống lương";
    }

    if (isset($_POST['month']) && !empty($_POST['month'])) {
        $month = mysqli_real_escape_string($mysqli, trim($_POST['month']));
    } else {
        $error = 1;
        $err = "Không được để trống tháng";
    }


    if (!$error) {
        //Prevent Double Entries
        $sql = "SELECT * FROM  payrolls WHERE code = '$code'  ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($code == $row['code']) {
                $err =  "Mã lương này đã tồn tại";
            } else {
                //
            }
        } else {

            $query = "INSERT INTO payrolls (id, code, month, staff_id, staff_name, salary) VALUES (?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('ssssss', $id, $code, $month, $staff_id, $staff_name, $salary);
            $stmt->execute();
            if ($stmt) {
                $success = "Đã thêm" && header("refresh:1; url=payrolls.php");
            } else {
                $info = "Vui lòng thử lại sau";
            }
        }
    }
}

if (isset($_POST['Update_Payroll'])) {
    /* Error Handling */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Không được để trống ID";
    }

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    } else {
        $error = 1;
        $err = "Không được để trống mã lương";
    }

    if (isset($_POST['month']) && !empty($_POST['month'])) {
        $month = mysqli_real_escape_string($mysqli, trim($_POST['month']));
    } else {
        $error = 1;
        $err = "Không được để trống tháng thanh toán";
    }

    if (isset($_POST['salary']) && !empty($_POST['salary'])) {
        $salary = mysqli_real_escape_string($mysqli, trim($_POST['salary']));
    } else {
        $error = 1;
        $err = "Không được để trống lương";
    }

    if (!$error) {

        $query = "UPDATE  payrolls SET code =?, month =?, salary =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssss', $code, $month, $salary, $id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật" && header("refresh:1; url=payrolls.php");
        } else {
            //inject alert that task failed
            $info = "Vui lòng thử lại sau";
        }
    }
}

if (isset($_GET['Delete'])) {
    $delete = $_GET['Delete'];
    $adn = "DELETE FROM payrolls WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa" && header("refresh:1; url=payrolls.php");
    } else {
        $info = "Vui lòng thử lại sau";
    }
}

// AJAX endpoint lấy thông tin nhân viên
if (isset($_POST['get_staff_by_number'])) {
    $number = mysqli_real_escape_string($mysqli, $_POST['get_staff_by_number']);
    $query = "SELECT id, name FROM staffs WHERE number = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $number);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);
    exit();
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
                            <h1>Quản lý bảng lương</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Bảng lương</li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Thêm bảng lương</button>
                    </div>
                    <!-- Add  Modal -->
                    <div class="modal fade" id="add_modal">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Điền đầy đủ thông tin</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" id="payrollForm">
                                        <div class="form-row mb-4">
                                            <div style="display:none" class="form-group col-md-6">
                                                <label for="inputEmail4">ID bảng lương</label>
                                                <input type="text" name="id" value="<?php echo $ID; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Mã bảng lương</label>
                                                <input type="text" name="code" value="<?php echo $a; ?>-<?php echo $b; ?>" class="form-control">
                                            </div>
                                            <!-- Ajax Staff Number To Give Me Staff ID AND Name -->
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Mã nhân viên</label>
                                                <select class='form-control' id="StaffNumber">
                                                    <option selected>Chọn mã nhân viên</option>
                                                    <?php
                                                    $ret = "SELECT * FROM `staffs`  ORDER BY `staffs`.`name` ASC ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($staff = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $staff->number; ?>"><?php echo $staff->number; ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Tên nhân viên</label>
                                                <input type="text" name="staff_name" id="StaffName" class="form-control" readonly>
                                                <input type="hidden" name="staff_id" id="StaffID" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Tháng</label>
                                                <select class='form-control' name="month" id="">
                                                    <option selected>Chọn tháng</option>
                                                    <option>Tháng 1</option>
                                                    <option>Tháng 2</option>
                                                    <option>Tháng 3</option>
                                                    <option>Tháng 4</option>
                                                    <option>Tháng 5</option>
                                                    <option>Tháng 6</option>
                                                    <option>Tháng 7</option>
                                                    <option>Tháng 8</option>
                                                    <option>Tháng 9</option>
                                                    <option>Tháng 10</option>
                                                    <option>Tháng 11</option>
                                                    <option>Tháng 12</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Số tiền</label>
                                                <input required type="text" name="salary" class="form-control">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="Add_Payroll" class="btn btn-warning mt-3">Tạo bảng lương</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End  Modal -->

                    <hr>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="dt-1" class="table table-bordered table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center align-middle" style="width: 15%;">Mã bảng lương</th>
                                        <th class="text-center align-middle" style="width: 15%;">Tháng</th>
                                        <th class="text-center align-middle" style="width: 20%;">Số tiền</th>
                                        <th class="text-center align-middle" style="width: 25%;">Tên nhân viên</th>
                                        <th class="text-center align-middle" style="width: 15%;">Ngày tạo</th>
                                        <th class="text-center align-middle" style="width: 10%;">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM `payrolls` ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($payrolls = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td class="text-center align-middle"><?php echo htmlspecialchars($payrolls->code); ?></td>
                                            <td class="text-center align-middle"><?php echo htmlspecialchars($payrolls->month); ?></td>
                                            <td class="text-center align-middle"><?php echo number_format($payrolls->salary, 0, ',', ',') . ' VND'; ?></td>
                                            <td class="text-center align-middle"><?php echo htmlspecialchars($payrolls->staff_name); ?></td>
                                            <td class="text-center align-middle"><?php echo date('d M Y g:i', strtotime($payrolls->created_at)); ?></td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center align-items-center" style="gap: 4px;">
                                                    <a class="badge badge-success" style="font-size: 13px; padding: 5px 10px; border-radius: 6px;" data-toggle="modal" href="#view_<?php echo $payrolls->id; ?>">Xem</a>
                                                    <a class="badge badge-primary" style="font-size: 13px; padding: 5px 10px; border-radius: 6px;" data-toggle="modal" href="#update_<?php echo $payrolls->id; ?>">Cập nhật</a>
                                                    <a class="badge badge-danger" style="font-size: 13px; padding: 5px 10px; border-radius: 6px;" data-toggle="modal" href="#delete_<?php echo $payrolls->id; ?>">Xóa</a>
                                                </div>
                                                <!-- View Modal -->
                                                <div class="modal fade" id="view_<?php echo $payrolls->id; ?>">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div id="Print_Payroll" class="invoice p-3 mb-3">
                                                                    <div class="row">
                                                                        <div class="col-12 ">
                                                                            <h4 class="text-center">
                                                                                <img height="100" width="200" src="../public/uploads/sys_logo/logo.png" class="img-thumbnail img-fluid" alt="System Logo">
                                                                                <br>
                                                                                <small class="float-right">Tạo ngày: <?php echo date('d M Y', strtotime($payrolls->created_at)); ?></small>
                                                                            </h4>
                                                                            <h4>
                                                                                Bảng lương nhân viên NNT Hotels
                                                                            </h4>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-12 table-responsive">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Mã bảng lương</th>
                                                                                        <th>Tên nhân viên</th>
                                                                                        <th>Số tiền</th>
                                                                                        <th>Tháng</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><?php echo htmlspecialchars($payrolls->code); ?></td>
                                                                                        <td><?php echo htmlspecialchars($payrolls->staff_name); ?></td>
                                                                                        <td><?php echo number_format($payrolls->salary, 0, ',', ',') . ' VND'; ?></td>
                                                                                        <td><?php echo htmlspecialchars($payrolls->month); ?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                                                                <button id="print" onclick="printContent('Print_Payroll');" type="button" class="btn btn-primary">In</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Update Modal -->
                                                <div class="modal fade" id="update_<?php echo $payrolls->id; ?>">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Cập nhật bảng lương <?php echo $payrolls->staff_name; ?> tháng <?php echo $payrolls->month; ?>.</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="form-row mb-4">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="inputEmail4">Mã bảng lương</label>
                                                                            <input type="text" name="code" value="<?php echo $payrolls->code; ?>" class="form-control">
                                                                            <input type="hidden" name="id" value="<?php echo $payrolls->id; ?>" class="form-control">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mb-4">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="inputEmail4">Tháng</label>
                                                                            <select class='form-control' name="month" id="">
                                                                                <option selected><?php echo $payrolls->month; ?></option>
                                                                                <option>Tháng 1</option>
                                                                                <option>Tháng 2</option>
                                                                                <option>Tháng 3</option>
                                                                                <option>Tháng 4</option>
                                                                                <option>Tháng 5</option>
                                                                                <option>Tháng 6</option>
                                                                                <option>Tháng 7</option>
                                                                                <option>Tháng 8</option>
                                                                                <option>Tháng 9</option>
                                                                                <option>Tháng 10</option>
                                                                                <option>Tháng 11</option>
                                                                                <option>Tháng 12</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="inputEmail4">Số tiền</label>
                                                                            <input required type="text" value="<?php echo $payrolls->salary; ?>" name="salary" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="submit" name="Update_Payroll" class="btn btn-warning mt-3">Cập nhật bảng lương</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete_<?php echo $payrolls->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">XÁC NHẬN</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Xóa bảng lương của <?php echo $payrolls->staff_name; ?>?</h4>
                                                                <br>
                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                                <a href="payrolls.php?Delete=<?php echo $payrolls->id; ?>" class="text-center btn btn-danger"> Xóa </a>
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
                </div>
            </section>
        </div>
        <?php require_once("../partials/footer.php"); ?>
    </div>
    <?php require_once("../partials/scripts.php"); ?>
    <script>
        // Khi chọn mã nhân viên, lấy tên và id nhân viên
        document.getElementById('StaffNumber').addEventListener('change', function() {
            var staffNumber = this.value;
            if (staffNumber && staffNumber !== 'Chọn mã nhân viên') {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        try {
                            var data = JSON.parse(xhr.responseText);
                            document.getElementById('StaffName').value = data.name || '';
                            document.getElementById('StaffID').value = data.id || '';
                        } catch (e) {
                            document.getElementById('StaffName').value = '';
                            document.getElementById('StaffID').value = '';
                        }
                    }
                };
                xhr.send('get_staff_by_number=' + encodeURIComponent(staffNumber));
            } else {
                document.getElementById('StaffName').value = '';
                document.getElementById('StaffID').value = '';
            }
        });
    </script>
</body>

</html>