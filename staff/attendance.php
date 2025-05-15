<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
staff(); /* Invoke Staff Check Login */

// Handle Check In
if (isset($_POST['Check_In'])) {
    $staff_id = $_SESSION['id'];
    $date = date('Y-m-d');
    $check_in = date('H:i:s');
    $status = 'Present';
    
    // Check if already checked in today
    $check_stmt = $mysqli->prepare("SELECT id FROM attendance WHERE staff_id = ? AND date = ?");
    $check_stmt->bind_param('ss', $staff_id, $date);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if($check_result->num_rows == 0) {
        // Generate a unique ID for the attendance record
        $att_id = uniqid();
        
        // Insert new attendance record
        $att_stmt = $mysqli->prepare("INSERT INTO attendance (id, staff_id, date, check_in, status) VALUES (?, ?, ?, ?, ?)");
        $att_stmt->bind_param('sssss', $att_id, $staff_id, $date, $check_in, $status);
        $att_stmt->execute();
        if($att_stmt) {
            $success = "Đã check in thành công";
        } else {
            $err = "Vui lòng thử lại";
        }
    } else {
        $err = "Bạn đã check in hôm nay rồi";
    }
}

// Handle Check Out
if (isset($_POST['Check_Out'])) {
    $staff_id = $_SESSION['id'];
    $date = date('Y-m-d');
    $check_out = date('H:i:s');
    
    // Update attendance record with check out time
    $stmt = $mysqli->prepare("UPDATE attendance SET check_out = ? WHERE staff_id = ? AND date = ? AND check_out IS NULL");
    $stmt->bind_param('sss', $check_out, $staff_id, $date);
    $stmt->execute();
    if($stmt) {
        $success = "Checked Out Successfully";
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
                            <h1 class="m-0 text-dark">Chấm công</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Chấm công</li>
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
                                    <h3 class="card-title">Chấm công hôm nay</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $staff_id = $_SESSION['id'];
                                    $date = date('Y-m-d');
                                    
                                    // Check today's attendance
                                    $check = $mysqli->prepare("SELECT * FROM attendance WHERE staff_id = ? AND date = ?");
                                    $check->bind_param('ss', $staff_id, $date);
                                    $check->execute();
                                    $result = $check->get_result();
                                    $today = $result->fetch_object();
                                    ?>
                                    
                                    <div class="text-center">
                                        <h4>Ngày: <?php echo date('d/m/Y'); ?></h4>
                                        <h4>Giờ hiện tại: <span id="current-time"></span></h4>
                                        
                                        <?php if(!$today) { ?>
                                            <form method="POST">
                                                <button type="submit" name="Check_In" class="btn btn-success btn-lg">
                                                    <i class="fas fa-sign-in-alt"></i> Check In
                                                </button>
                                            </form>
                                        <?php } else if(!$today->check_out) { ?>
                                            <form method="POST">
                                                <button type="submit" name="Check_Out" class="btn btn-danger btn-lg">
                                                    <i class="fas fa-sign-out-alt"></i> Check Out
                                                </button>
                                            </form>
                                            <p class="mt-3">Đã check in lúc: <?php echo date('H:i:s', strtotime($today->check_in)); ?></p>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <h5>Bạn đã hoàn thành chấm công hôm nay</h5>
                                                <p>Check in: <?php echo date('H:i:s', strtotime($today->check_in)); ?></p>
                                                <p>Check out: <?php echo date('H:i:s', strtotime($today->check_out)); ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance History -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Lịch sử chấm công</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Check In</th>
                                                <th>Check Out</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $history = $mysqli->prepare("SELECT * FROM attendance WHERE staff_id = ? ORDER BY date DESC LIMIT 10");
                                            $history->bind_param('s', $staff_id);
                                            $history->execute();
                                            $records = $history->get_result();
                                            while($record = $records->fetch_object()) {
                                            ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y', strtotime($record->date)); ?></td>
                                                <td><?php echo $record->check_in ? date('H:i:s', strtotime($record->check_in)) : '-'; ?></td>
                                                <td><?php echo $record->check_out ? date('H:i:s', strtotime($record->check_out)) : '-'; ?></td>
                                                <td><?php echo $record->status; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php require_once('../partials/scripts.php'); ?>
    
    <script>
    // Update current time
    function updateTime() {
        const now = new Date();
        document.getElementById('current-time').textContent = now.toLocaleTimeString();
    }
    
    // Update time every second
    setInterval(updateTime, 1000);
    updateTime(); // Initial update
    </script>
</body>
</html> 