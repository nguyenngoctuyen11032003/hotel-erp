<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
staff(); /* Invoke  Check Login */

if (isset($_POST['Add_Reservation'])) {
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Reservation ID Cannot Be Empty";
    }

    // Lấy đúng room_id từ input ẩn hoặc tự động lấy lại từ số phòng nếu thiếu
    if (isset($_POST['room_id']) && !empty($_POST['room_id'])) {
        $room_id = mysqli_real_escape_string($mysqli, trim($_POST['room_id']));
    } else {
        if (isset($_POST['room_number']) && !empty($_POST['room_number'])) {
            $room_number = mysqli_real_escape_string($mysqli, trim($_POST['room_number']));
            $query = "SELECT id FROM rooms WHERE number = ?";
            $stmt_room = $mysqli->prepare($query);
            $stmt_room->bind_param('s', $room_number);
            $stmt_room->execute();
            $stmt_room->bind_result($room_id_found);
            if ($stmt_room->fetch()) {
                $room_id = $room_id_found;
            } else {
                $error = 1;
                $err = "Không tìm thấy ID phòng cho số phòng đã chọn";
            }
            $stmt_room->close();
        } else {
            $error = 1;
            $err = "Room ID Cannot Be Empty";
        }
    }

    if (isset($_POST['room_number']) && !empty($_POST['room_number'])) {
        $room_number = mysqli_real_escape_string($mysqli, trim($_POST['room_number']));
    } else {
        $error = 1;
        $err = "Room Number Cannot Be Empty";
    }

    // Lấy đúng giá trị giá phòng từ trường input readonly (room_cost)
    if (isset($_POST['room_cost']) && !empty($_POST['room_cost'])) {
        $room_cost = mysqli_real_escape_string($mysqli, trim($_POST['room_cost']));
    } else {
        $error = 1;
        $err = "Room Price Cannot Be Empty";
    }

    if (isset($_POST['room_type']) && !empty($_POST['room_type'])) {
        $room_type = mysqli_real_escape_string($mysqli, trim($_POST['room_type']));
    } else {
        $error = 1;
        $err = "Room Type Cannot Be Empty";
    }

    if (isset($_POST['check_in']) && !empty($_POST['check_in'])) {
        $check_in = mysqli_real_escape_string($mysqli, trim($_POST['check_in']));
    } else {
        $error = 1;
        $err = "Check In Cannot Be Empty";
    }

    if (isset($_POST['check_out']) && !empty($_POST['check_out'])) {
        $check_out = mysqli_real_escape_string($mysqli, trim($_POST['check_out']));
    } else {
        $error = 1;
        $err = "Check Out Cannot Be Empty";
    }

    if (isset($_POST['cust_name']) && !empty($_POST['cust_name'])) {
        $cust_name = mysqli_real_escape_string($mysqli, trim($_POST['cust_name']));
    } else {
        $error = 1;
        $err = "Customer Name Cannot Be Empty";
    }

    if (isset($_POST['cust_id']) && !empty($_POST['cust_id'])) {
        $cust_id = mysqli_real_escape_string($mysqli, trim($_POST['cust_id']));
    } else {
        $error = 1;
        $err = "Customer National ID Cannot Be Empty";
    }

    if (isset($_POST['cust_phone']) && !empty($_POST['cust_phone'])) {
        $cust_phone = mysqli_real_escape_string($mysqli, trim($_POST['cust_phone']));
    } else {
        $error = 1;
        $err = "Customer Phone Number Cannot Be Empty";
    }

    if (isset($_POST['cust_email']) && !empty($_POST['cust_email'])) {
        $cust_email = mysqli_real_escape_string($mysqli, trim($_POST['cust_email']));
    } else {
        $error = 1;
        $err = "Customer Email Cannot Be Empty";
    }

    if (isset($_POST['cust_adr']) && !empty($_POST['cust_adr'])) {
        $cust_adr = mysqli_real_escape_string($mysqli, trim($_POST['cust_adr']));
    } else {
        $error = 1;
        $err = "Customer Address Cannot Be Empty";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Status Cannot Be Empty";
    }

    if (!$error) {
        $room_status = $_POST['room_status'];
        $query = "INSERT INTO reservations (id, room_id, room_number, room_cost, room_type, check_in, check_out, cust_name, cust_id, cust_phone, cust_email, cust_adr, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $room_querry = "UPDATE rooms SET status =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $roomstmt = $mysqli->prepare($room_querry);
        $rc = $stmt->bind_param('sssssssssssss', $id, $room_id, $room_number, $room_cost, $room_type, $check_in, $check_out, $cust_name, $cust_id, $cust_phone, $cust_email, $cust_adr, $status);
        $rc = $roomstmt->bind_param('ss', $room_status, $room_id);
        $stmt->execute();
        $roomstmt->execute();
        if ($stmt && $roomstmt) {
            $success = "Added" && header("refresh:1; url=reservations.php");
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

if (isset($_POST['Update_Reservation'])) {
    /* Error Handling And Update Room */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Rerservation ID  Cannot Be Empty";
    }

    if (isset($_POST['room_id']) && !empty($_POST['room_id'])) {
        $room_id = mysqli_real_escape_string($mysqli, trim($_POST['room_id']));
    } else {
        $error = 1;
        $err = "Room ID  Cannot Be Empty";
    }

    if (isset($_POST['room_number']) && !empty($_POST['room_number'])) {
        $room_number = mysqli_real_escape_string($mysqli, trim($_POST['room_number']));
    } else {
        $error = 1;
        $err = "Room Number Cannot Be Empty";
    }

    if (isset($_POST['room_cost']) && !empty($_POST['room_cost'])) {
        $room_cost = mysqli_real_escape_string($mysqli, trim($_POST['room_cost']));
    } else {
        $error = 1;
        $err = "Room Cost Cannot Be Empty";
    }

    if (isset($_POST['room_type']) && !empty($_POST['room_type'])) {
        $room_type = mysqli_real_escape_string($mysqli, trim($_POST['room_type']));
    } else {
        $error = 1;
        $err = "Room Type Cannot Be Empty";
    }

    if (isset($_POST['check_in']) && !empty($_POST['check_in'])) {
        $check_in = mysqli_real_escape_string($mysqli, trim($_POST['check_in']));
    } else {
        $error = 1;
        $err = "Check In Cannot Be Empty";
    }

    if (isset($_POST['check_out']) && !empty($_POST['check_out'])) {
        $check_out = mysqli_real_escape_string($mysqli, trim($_POST['check_out']));
    } else {
        $error = 1;
        $err = "Check Out Cannot Be Empty";
    }

    if (isset($_POST['cust_name']) && !empty($_POST['cust_name'])) {
        $cust_name = mysqli_real_escape_string($mysqli, trim($_POST['cust_name']));
    } else {
        $error = 1;
        $err = "Customer Name Cannot Be Empty";
    }


    if (isset($_POST['cust_phone']) && !empty($_POST['cust_phone'])) {
        $cust_phone = mysqli_real_escape_string($mysqli, trim($_POST['cust_phone']));
    } else {
        $error = 1;
        $err = "Customer Phone Cannot Be Empty";
    }

    if (isset($_POST['cust_email']) && !empty($_POST['cust_email'])) {
        $cust_email = mysqli_real_escape_string($mysqli, trim($_POST['cust_email']));
    } else {
        $error = 1;
        $err = "Customer Email Cannot Be Empty";
    }

    if (isset($_POST['cust_id']) && !empty($_POST['cust_id'])) {
        $cust_id = mysqli_real_escape_string($mysqli, trim($_POST['cust_id']));
    } else {
        $error = 1;
        $err = "Customer National ID Cannot Be Empty";
    }

    if (isset($_POST['cust_adr']) && !empty($_POST['cust_adr'])) {
        $cust_adr = mysqli_real_escape_string($mysqli, trim($_POST['cust_adr']));
    } else {
        $error = 1;
        $err = "Customer Address Cannot Be Empty";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Reservation Status Cannot Be Empty";
    }

    if (isset($_POST['room_status']) && !empty($_POST['room_status'])) {
        $room_status = mysqli_real_escape_string($mysqli, trim($_POST['room_status']));
    } else {
        $error = 1;
        $err = "Room Status Cannot Be Empty";
    }

    if (!$error) {

        $query = "UPDATE reservations SET room_id =?, room_number =?, room_cost =?, room_type =?, check_in =?, check_out =?, cust_name =?, cust_id =?, cust_phone =?, cust_email =?, cust_adr =?, status =? WHERE id =?";
        $room_querry = "UPDATE rooms SET status =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $roomstmt = $mysqli->prepare($room_querry);
        $rc = $stmt->bind_param('sssssssssssss',  $room_id, $room_number, $room_cost, $room_type, $check_in, $check_out, $cust_name, $cust_id, $cust_phone, $cust_email, $cust_adr, $status, $id);
        $rc = $roomstmt->bind_param('ss', $room_status, $room_id);
        $stmt->execute();
        $roomstmt->execute();
        if ($stmt && $roomstmt) {
            $success = "Updated" && header("refresh:1; url=reservations.php");
        } else {
            //inject alert that task failed
            $info = "Please Try Again Or Try Later";
        }
    }
}


if (isset($_GET['Vacate_Room'])) {
    /* After Clients Reservations Days Are Over They Have To Vacate Room */
    $room_id = $_GET['Vacate_Room'];
    $status = $_GET['status'];
    $rooms = "UPDATE rooms SET status =? WHERE  id =?";
    $roomsStmt = $mysqli->prepare($rooms);
    $roomsStmt->bind_param('ss', $status, $room_id);
    $roomsStmt->execute();
    $roomsStmt->close();
    if ($roomsStmt) {
        $success = "Deleted" && header("refresh:1; url=reservations.php");
    } else {
        //inject alert that task failed
        $info = "Please Try Again Or Try Later";
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
        <?php require_once("../partials/staff_sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lý đặt phòng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Đặt phòng</li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-room">Thêm đặt phòng</button>
                    </div>
                    <!-- Add Modal -->
                    <div class="modal fade" id="add-room">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Điền đầy đủ thông tin</h4>
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
                                                <input type="text" name="status" value="Pending" class="form-control">
                                                <input type="text" name="room_status" value="Occupied" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Số phòng</label>
                                                <select name="room_number" id="RNumber" class="form-control" onchange="getRoomDetails(this.value);">
                                                    <option value="">Chọn số phòng</option>
                                                    <?php
                                                    $ret = "SELECT * FROM `rooms` ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();
                                                    while ($rooms = $res->fetch_object()) {
                                                        echo "<option value='{$rooms->number}'>{$rooms->number}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="room_id" id="RID" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Giá phòng</label>
                                                <input type="text" readonly id="RCost" name="room_cost" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Loại phòng</label>
                                                <input type="text" readonly id="RType" name="room_type" class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Ngày nhận phòng</label>
                                                <input type="date" name="check_in" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Ngày trả phòng</label>
                                                <input type="date" name="check_out" class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Họ tên khách hàng</label>
                                                <input type="text" name="cust_name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Số CMND/CCCD</label>
                                                <input type="text" name="cust_id" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Số điện thoại</label>
                                                <input type="text" name="cust_phone" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" name="cust_email" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Địa chỉ</label>
                                                <input type="text" name="cust_adr" class="form-control">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="Add_Reservation" class="btn btn-warning mt-3">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Số phòng</th>
                                    <th>Loại phòng</th>
                                    <th>Ngày nhận phòng</th>
                                    <th>Ngày trả phòng</th>
                                    <th>Họ tên</th>
                                    <th>CMND/CCCD</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `reservations` ORDER BY `reservations`.`created_at` DESC";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($reservation = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $reservation->room_number; ?></td>
                                        <td><?php echo $reservation->room_type; ?></td>
                                        <td><?php echo $reservation->check_in; ?></td>
                                        <td><?php echo $reservation->check_out; ?></td>
                                        <td><?php echo $reservation->cust_name; ?></td>
                                        <td><?php echo $reservation->cust_id; ?></td>
                                        <td>
                                            <?php
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
                                        <td><?php echo date('d M Y', strtotime($reservation->created_at)); ?></td>
                                        <td>
                                            <a class="badge badge-primary" data-toggle="modal" href="#update-<?php echo $reservation->id; ?>">Cập nhật</a>
                                            <!-- Update Modal -->
                                            <div class="modal fade" id="update-<?php echo $reservation->id; ?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Cập nhật đặt phòng: <?php echo $reservation->cust_name; ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="form-row mb-4">
                                                                    <div style="display:none" class="form-group col-md-6">
                                                                        <label for="inputEmail4">Id</label>
                                                                        <input type="text" name="id" value="<?php echo $reservation->id; ?>" class="form-control">
                                                                        <input type="text" name="status" value="Pending" class="form-control">
                                                                        <input type="text" name="room_status" value="Occupied" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Số phòng</label>
                                                                        <input type="text" readonly value="<?php echo $reservation->room_number; ?>" name="room_number" class="form-control">
                                                                        <input type="hidden" name="room_id" value="<?php echo $reservation->room_id; ?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Giá phòng</label>
                                                                        <input type="text" readonly value="<?php echo $reservation->room_cost; ?>" name="room_cost" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Loại phòng</label>
                                                                        <input type="text" readonly value="<?php echo $reservation->room_type; ?>" name="room_type" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Ngày nhận phòng</label>
                                                                        <input type="date" value="<?php echo $reservation->check_in; ?>" name="check_in" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Ngày trả phòng</label>
                                                                        <input type="date" value="<?php echo $reservation->check_out; ?>" name="check_out" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Họ tên khách hàng</label>
                                                                        <input type="text" value="<?php echo $reservation->cust_name; ?>" name="cust_name" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Số CMND/CCCD</label>
                                                                        <input type="text" value="<?php echo $reservation->cust_id; ?>" name="cust_id" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail4">Số điện thoại</label>
                                                                        <input type="text" value="<?php echo $reservation->cust_phone; ?>" name="cust_phone" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Email</label>
                                                                        <input type="email" value="<?php echo $reservation->cust_email; ?>" name="cust_email" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Địa chỉ</label>
                                                                        <input type="text" value="<?php echo $reservation->cust_adr; ?>" name="cust_adr" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="submit" name="Update_Reservation" class="btn btn-primary mt-3">Cập nhật</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Update Modal -->

                                            <!-- Staff Cant Delete Reservations -->

                                            <a class="badge badge-success" data-toggle="modal" href="#vacate-<?php echo $reservation->id; ?>">Trả phòng</a>
                                            <!-- Vacate Room Modal  -->
                                            <div class="modal fade" id="vacate-<?php echo $reservation->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">XÁC NHẬN</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center text-danger">
                                                            <h4>Trả phòng <?php echo $reservation->room_number; ?>?</h4>
                                                            <br>
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                            <a href="reservations.php?Vacate_Room=<?php echo $reservation->room_id; ?>&status=Vacant" class="text-center btn btn-danger"> Trả phòng </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Vacate Room Modal -->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <?php require_once("../partials/footer.php"); ?>
    </div>
    <?php require_once("../partials/scripts.php"); ?>
    <script>
        function getRoomDetails(roomNumber) {
            if (!roomNumber) {
                document.getElementById('RCost').value = '';
                document.getElementById('RType').value = '';
                document.getElementById('RID').value = '';
                return;
            }
            // Lấy giá phòng và loại phòng
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../admin/reservations.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        document.getElementById('RCost').value = data.price ? data.price : '';
                        document.getElementById('RType').value = data.type ? data.type : '';
                    } catch (e) {
                        document.getElementById('RCost').value = '';
                        document.getElementById('RType').value = '';
                    }
                }
            };
            xhr.send('get_room_info=' + encodeURIComponent(roomNumber));

            // Lấy room_id (ID phòng) theo số phòng qua AJAX
            var xhr2 = new XMLHttpRequest();
            xhr2.open('POST', '../partials/ajax.php', true);
            xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr2.onload = function () {
                if (xhr2.status === 200) {
                    document.getElementById('RID').value = xhr2.responseText.trim();
                }
            };
            xhr2.send('RNumber=' + encodeURIComponent(roomNumber));
        }
    </script>
</body>
</html>