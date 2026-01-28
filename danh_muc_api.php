<?php
require 'db.php';

$action = $_POST['action'] ?? '';

/* LẤY DANH SÁCH */
if ($action == 'fetch') {
    $rs = $conn->query("SELECT * FROM khoa ORDER BY id ASC");
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* THÊM MỚI */
if ($action == 'insert') {
    $ten = $_POST['ten'];
    $moTa = $_POST['moTa'];

    $stmt = $conn->prepare("INSERT INTO khoa (ten_khoa, mo_ta) VALUES (?,?)");
    $stmt->bind_param("ss", $ten, $moTa);
    echo $stmt->execute();
}

/* CẬP NHẬT */
if ($action == 'update') {
    $id = $_POST['id'];
    $ten = $_POST['ten'];
    $moTa = $_POST['moTa'];

    $stmt = $conn->prepare("UPDATE khoa SET ten_khoa=?, mo_ta=? WHERE id=?");
    $stmt->bind_param("ssi", $ten, $moTa, $id);
    echo $stmt->execute();
}

/* XÓA */
if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM khoa WHERE id=?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute();
}
?>