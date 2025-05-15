<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php
    /* Persisit System Settings On Brand */
    $ret = "SELECT * FROM `system_settings` ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($sys = $res->fetch_object()) {
        // Sửa lỗi logic: kiểm tra rỗng thay vì gán
        if (empty($sys->sys_logo)) {
            $logo_dir = '../public/uploads/sys_logo/logo.png';
        } else {
            $logo_dir = "../public/uploads/sys_logo/$sys->sys_logo";
        }
    ?>
        <a href="dashboard.php" class="brand-link">
            <img src="<?php echo $logo_dir; ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo $sys->sys_name; ?></span>
        </a>
    <?php
    } ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="rooms.php" class="nav-link">
                        <i class="nav-icon fas fa-bed"></i>
                        <p>
                            Quản lý phòng
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            Quản lý đặt phòng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="reservations.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Danh sách đặt phòng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reservation_payments.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Thanh toán đặt phòng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="resturant_sales.php" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>
                            Quản lý nhà hàng
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Quản lý nhân sự
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="staffs.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="attendance.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Chấm công</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="payrolls.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Bảng lương</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="room_service.php" class="nav-link">
                        <i class="nav-icon fas fa-person-booth"></i>
                        <p>
                            Dịch vụ phòng
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-dolly-flatbed"></i>
                        <p>
                            Quản lý kho
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="inventory_assets.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Tài sản</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="rooms.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Phòng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Quản lý khách hàng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="customers.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Khách hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Báo cáo thống kê
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="reports_rooms.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Báo cáo phòng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reports_reservations.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Báo cáo đặt phòng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reports_revenues.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Báo cáo doanh thu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reports_staffs.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Báo cáo nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reports_payrolls.php" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Báo cáo lương</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="settings.php" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Thiết lập hệ thống
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Đăng xuất
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>