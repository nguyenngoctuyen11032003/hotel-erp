<?php
include('../config/pdoconfig.php');

// Lấy ID phòng theo số phòng
if (!empty($_POST["RNumber"])) {
    $id = $_POST['RNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM rooms WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['id']);
    }
}

// Lấy giá phòng theo số phòng
if (!empty($_POST["RID"])) {
    $id = $_POST['RID'];
    $stmt = $DB_con->prepare("SELECT * FROM rooms WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['price']);
    }
}

// Lấy loại phòng theo số phòng
if (!empty($_POST["RCost"])) {
    $id = $_POST['RCost'];
    $stmt = $DB_con->prepare("SELECT * FROM rooms WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['type']);
    }
}

// Lấy thông tin nhân viên theo mã số nhân viên
if (!empty($_POST["StaffNumber"])) {
    $id = $_POST['StaffNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM staffs WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['id']);
    }
}

// Lấy tên nhân viên theo mã số nhân viên
if (!empty($_POST["StaffID"])) {
    $id = $_POST['StaffID'];
    $stmt = $DB_con->prepare("SELECT * FROM staffs WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['name']);
    }
}
