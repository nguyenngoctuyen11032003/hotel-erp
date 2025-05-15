<?php
require_once('config/config.php');
require_once('config/codeGen.php');

if (isset($_POST['Add_Reservation'])) {
    /* Error Handling And Add Room */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Mã đặt phòng không được để trống";
    }

    if (isset($_POST['room_id']) && !empty($_POST['room_id'])) {
        $room_id = mysqli_real_escape_string($mysqli, trim($_POST['room_id']));
    } else {
        $error = 1;
        $err = "Mã phòng không được để trống";
    }

    if (isset($_POST['room_number']) && !empty($_POST['room_number'])) {
        $room_number = mysqli_real_escape_string($mysqli, trim($_POST['room_number']));
    } else {
        $error = 1;
        $err = "Số phòng không được để trống";
    }

    if (isset($_POST['room_cost']) && !empty($_POST['room_cost'])) {
        $room_cost = mysqli_real_escape_string($mysqli, trim($_POST['room_cost']));
    } else {
        $error = 1;
        $err = "Giá phòng không được để trống";
    }

    if (isset($_POST['room_type']) && !empty($_POST['room_type'])) {
        $room_type = mysqli_real_escape_string($mysqli, trim($_POST['room_type']));
    } else {
        $error = 1;
        $err = "Loại phòng không được để trống";
    }

    if (isset($_POST['check_in']) && !empty($_POST['check_in'])) {
        $check_in = mysqli_real_escape_string($mysqli, trim($_POST['check_in']));
    } else {
        $error = 1;
        $err = "Ngày nhận phòng không được để trống";
    }

    if (isset($_POST['check_out']) && !empty($_POST['check_out'])) {
        $check_out = mysqli_real_escape_string($mysqli, trim($_POST['check_out']));
    } else {
        $error = 1;
        $err = "Ngày trả phòng không được để trống";
    }

    if (isset($_POST['cust_name']) && !empty($_POST['cust_name'])) {
        $cust_name = mysqli_real_escape_string($mysqli, trim($_POST['cust_name']));
    } else {
        $error = 1;
        $err = "Họ và tên không được để trống";
    }

    if (isset($_POST['cust_id']) && !empty($_POST['cust_id'])) {
        $cust_id = mysqli_real_escape_string($mysqli, trim($_POST['cust_id']));
    } else {
        $error = 1;
        $err = "Số CMND/CCCD không được để trống";
    }

    if (isset($_POST['cust_phone']) && !empty($_POST['cust_phone'])) {
        $cust_phone = mysqli_real_escape_string($mysqli, trim($_POST['cust_phone']));
    } else {
        $error = 1;
        $err = "Số điện thoại không được để trống";
    }

    if (isset($_POST['cust_email']) && !empty($_POST['cust_email'])) {
        $cust_email = mysqli_real_escape_string($mysqli, trim($_POST['cust_email']));
    } else {
        $error = 1;
        $err = "Email không được để trống";
    }

    if (isset($_POST['cust_adr']) && !empty($_POST['cust_adr'])) {
        $cust_adr = mysqli_real_escape_string($mysqli, trim($_POST['cust_adr']));
    } else {
        $error = 1;
        $err = "Địa chỉ không được để trống";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = mysqli_real_escape_string($mysqli, trim($_POST['status']));
    } else {
        $error = 1;
        $err = "Trạng thái không được để trống";
    }

    if (!$error) {
        //Update Room That It Has Been Occupied
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
            $success = "Thêm thành công" && header("refresh:1; url=rooms.php");
        } else {
            //inject alert that task failed
            $info = "Vui lòng thử lại sau";
        }
    }
}

/* Persist System Settigs On Landing Pages */
$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
    if (empty($sys->sys_logo)) {
        $logo_dir = 'public/uploads/sys_logo/logo.png';
    } else {
        $logo_dir = "public/uploads/sys_logo/$sys->sys_logo";
    }
    require_once('partials/cms_head.php');
?>
    <style>
        /* Tối ưu giao diện phòng */
        .room-card {
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            transition: box-shadow 0.2s;
            min-height: 420px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .room-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
        }
        .room-card img {
            max-height: 160px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }
        .rooms_title h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .rooms_price {
            font-size: 1.1rem;
            font-weight: bold;
            color: #ff9800;
            margin-bottom: 10px;
        }
        .rooms_button {
            margin-top: 10px;
        }
        @media (max-width: 991.98px) {
            .room-card img { max-height: 120px; }
        }
        @media (max-width: 767.98px) {
            .room-card img { max-height: 100px; }
        }
    </style>
    <body>
        <div class="super_container">
            <?php require_once("partials/cms_nav.php"); ?>
            <div class="home">
                <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="public/cms_assets/images/home.jpg" data-speed="0.8"></div>
                <div class="home_container d-flex flex-column align-items-center justify-content-center">
                    <div class="home_title">
                        <h1><?php echo $sys->sys_name; ?></h1>
                    </div>
                </div>
            </div>
            <br>
            <div class="rooms">
                <div class="container">
                    <div class="row">
                        <?php
                        $ret = "SELECT * FROM `rooms`  WHERE status = 'Vacant' ORDER BY RAND() ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($rooms = $res->fetch_object()) {
                            if ($rooms->image == '') {
                                $img_dir =  "public/uploads/sys_logo/logo.png";
                            } else {
                                $img_dir =  "public/uploads/rooms/$rooms->image";
                            }
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex">
                            <div class="card room-card w-100">
                                <img class="card-img-top" src="<?php echo $img_dir; ?>" alt="Hình ảnh phòng">
                                <div class="card-body d-flex flex-column">
                                    <div class="rooms_title">
                                        <h2><?php echo $rooms->type; ?></h2>
                                    </div>
                                    <div class="rooms_price"><?php echo number_format($rooms->price); ?> VND /<span>đêm</span></div>
                                    <div class="button rooms_button mt-auto"><a data-toggle="modal" href="#book-<?php echo $rooms->id; ?>">Đặt ngay</a></div>
                                </div>
                            </div>
                        </div>
                        <!-- Book Room Modal -->
                        <div class="modal fade" id="book-<?php echo $rooms->id; ?>">
                            <div class="modal-dialog  modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Điền đầy đủ thông tin</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data" class="booking-form" onsubmit="return validateBookingForm(this);">
                                            <div id="form-error-<?php echo $rooms->id; ?>" class="alert alert-danger d-none"></div>
                                            <div class="form-row mb-4">
                                                <div style="display:none" class="form-group col-md-6">
                                                    <label for="inputEmail4">Id</label>
                                                    <input type="text" name="id" value="<?php echo $ID; ?>" class="form-control">
                                                    <input type="text" name="room_id" value="<?php echo $rooms->id; ?>" class="form-control">
                                                    <input type="text" name="status" value="Pending" class="form-control">
                                                    <input type="text" name="room_status" value="Occupied" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row mb-4" style="display: none;">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Số phòng</label>
                                                    <input type="text" readonly value="<?php echo $rooms->number; ?>" name="room_number" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Giá phòng</label>
                                                    <input type="text" readonly value="<?php echo $rooms->price; ?>"  name="room_cost" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Loại phòng</label>
                                                    <input type="text" readonly value="<?php echo $rooms->type; ?>"  name="room_type" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row mb-4">
                                                <div class="form-group col-md-6">
                                                    <label for="check_in_<?php echo $rooms->id; ?>">Ngày nhận phòng</label>
                                                    <input type="date" name="check_in" id="check_in_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="check_out_<?php echo $rooms->id; ?>">Ngày trả phòng</label>
                                                    <input type="date" name="check_out" id="check_out_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-row mb-4">
                                                <div class="form-group col-md-12">
                                                    <label for="cust_name_<?php echo $rooms->id; ?>">Họ và tên</label>
                                                    <input type="text" name="cust_name" id="cust_name_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cust_id_<?php echo $rooms->id; ?>">Số CMND/CCCD</label>
                                                    <input type="text" name="cust_id" id="cust_id_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cust_phone_<?php echo $rooms->id; ?>">Số điện thoại</label>
                                                    <input type="text" name="cust_phone" id="cust_phone_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-row mb-4">
                                                <div class="form-group col-md-12">
                                                    <label for="cust_email_<?php echo $rooms->id; ?>">Email</label>
                                                    <input type="email" name="cust_email" id="cust_email_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="cust_adr_<?php echo $rooms->id; ?>">Địa chỉ</label>
                                                    <input type="text" name="cust_adr" id="cust_adr_<?php echo $rooms->id; ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" name="Add_Reservation" class="btn btn-warning mt-3">Gửi yêu cầu</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Room Modal -->
                        <?php } ?>
                    </div>
                </div>
            </div>
            <script>
                // Kiểm tra hợp lệ form đặt phòng
                function validateBookingForm(form) {
                    var checkIn = form.querySelector('[name="check_in"]').value;
                    var checkOut = form.querySelector('[name="check_out"]').value;
                    var phone = form.querySelector('[name="cust_phone"]').value.trim();
                    var cmnd = form.querySelector('[name="cust_id"]').value.trim();
                    var errorDiv = form.querySelector('.alert');
                    var errorMsg = '';

                    // Ngày nhận phòng phải nhỏ hơn ngày trả phòng
                    if (checkIn === '' || checkOut === '') {
                        errorMsg = 'Vui lòng chọn ngày nhận và trả phòng.';
                    } else if (checkIn >= checkOut) {
                        errorMsg = 'Ngày nhận phòng phải nhỏ hơn ngày trả phòng.';
                    }
                    // Số điện thoại phải >= 10 số, chỉ nhận số
                    else if (!/^\d{10,}$/.test(phone)) {
                        errorMsg = 'Số điện thoại phải có ít nhất 10 chữ số và chỉ chứa số.';
                    }
                    // Số CMND/CCCD phải >= 12 số, chỉ nhận số
                    else if (!/^\d{12,}$/.test(cmnd)) {
                        errorMsg = 'Số CMND/CCCD phải có ít nhất 12 chữ số và chỉ chứa số.';
                    }

                    if (errorMsg) {
                        errorDiv.textContent = errorMsg;
                        errorDiv.classList.remove('d-none');
                        return false;
                    } else {
                        errorDiv.classList.add('d-none');
                        return true;
                    }
                }
            </script>
            <footer class="footer">
                <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="public/cms_assets/images/footer.jpg" data-speed="0.8"></div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="footer_logo text-center">
                                <a href="#"><img src="images/logo.png" alt=""></a>
                            </div>
                            <div class="footer_content">
                                <div class="row">
                                    <div class="col-lg-4 footer_col">
                                        <div class="footer_info d-flex flex-column align-items-lg-end align-items-center justify-content-start">
                                            <div class="text-center">
                                                <div>Điện thoại:</div>
                                                <div><?php echo $sys->contacts_phone; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 footer_col">
                                        <div class="footer_info d-flex flex-column align-items-center justify-content-start">
                                            <div class="text-center">
                                                <div>Địa chỉ:</div>
                                                <div><?php echo $sys->contacts_addres; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 footer_col">
                                        <div class="footer_info d-flex flex-column align-items-lg-start align-items-center justify-content-start">
                                            <div class="text-center">
                                                <div>Email:</div>
                                                <div><?php echo $sys->contacts_email; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php require_once("partials/cms_footer.php"); ?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <?php require_once("partials/cms_scripts.php"); ?>
    </body>

    </html>
<?php
} ?>