<?php
session_start();
// Xóa phiên đăng nhập và chuyển về trang đăng nhập
unset($_SESSION['id']);
session_destroy();
header("Location: index.php");
exit;
