<?php
require 'db.php';
$action = $_POST['action'] ?? '';

/* 1. LẤY DANH SÁCH MÔN HỌC */
if ($action == 'fetch') {
    $rs = $conn->query("SELECT * FROM mon_hoc ORDER BY id ASC");
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 2. THÊM MỚI */
if ($action == 'insert') {
    $ten = $_POST['ten_mon'];
    $stc = $_POST['so_tin_chi'];
    $stmt = $conn->prepare("INSERT INTO mon_hoc (ten_mon, so_tin_chi) VALUES (?, ?)");
    $stmt->bind_param("si", $ten, $stc);
    echo $stmt->execute();
}

/* 3. CẬP NHẬT */
if ($action == 'update') {
    $id = $_POST['id'];
    $ten = $_POST['ten_mon'];
    $stc = $_POST['so_tin_chi'];
    $stmt = $conn->prepare("UPDATE mon_hoc SET ten_mon=?, so_tin_chi=? WHERE id=?");
    $stmt->bind_param("sii", $ten, $stc, $id);
    echo $stmt->execute();
}

/* 4. XÓA */
if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM mon_hoc WHERE id=?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute();
}
?>