<?php
require 'db.php'; // Kết nối CSDL

$action = $_POST['action'] ?? '';

/* 1. LẤY DANH SÁCH NGƯỜI DÙNG */
if ($action == 'fetch') {
    $sql = "SELECT nd.*, sv.ho_ten 
            FROM nguoi_dung nd 
            LEFT JOIN sinh_vien sv ON nd.sinh_vien_id = sv.id 
            ORDER BY nd.id ASC";
    $rs = $conn->query($sql);
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 2. LẤY DANH SÁCH SINH VIÊN (Để liên kết tài khoản) */
if ($action == 'fetch_sinh_vien') {
    $rs = $conn->query("SELECT id, ho_ten FROM sinh_vien ORDER BY ho_ten ASC");
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 3. THÊM NGƯỜI DÙNG MỚI */
if ($action == 'insert') {
    $user = $_POST['ten_dang_nhap'];
    $pass = $_POST['mat_khau']; // Trong thực tế nên dùng password_hash
    $sv_id = $_POST['sinh_vien_id'] != "" ? $_POST['sinh_vien_id'] : NULL;
    $vai_tro = $_POST['vai_tro'];

    $stmt = $conn->prepare("INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, sinh_vien_id, vai_tro) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $user, $pass, $sv_id, $vai_tro); //
    echo $stmt->execute();
    $stmt->close();
}

/* 4. CẬP NHẬT */
if ($action == 'update') {
    $id = $_POST['id'];
    $user = $_POST['ten_dang_nhap'];
    $pass = $_POST['mat_khau'];
    $sv_id = $_POST['sinh_vien_id'] != "" ? $_POST['sinh_vien_id'] : NULL;
    $vai_tro = $_POST['vai_tro'];

    $stmt = $conn->prepare("UPDATE nguoi_dung SET ten_dang_nhap=?, mat_khau=?, sinh_vien_id=?, vai_tro=? WHERE id=?");
    $stmt->bind_param("ssisi", $user, $pass, $sv_id, $vai_tro, $id);
    echo $stmt->execute();
    $stmt->close();
}

/* 5. XÓA */
if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM nguoi_dung WHERE id = ?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute();
    $stmt->close();
}
?>