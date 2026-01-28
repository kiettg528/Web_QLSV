<?php
require 'db.php';

$action = $_POST['action'] ?? '';

/* 1. LẤY DANH SÁCH SINH VIÊN (Kèm tên lớp) */
if ($action == 'fetch_sinh_vien') {
    // Sắp xếp ORDER BY id ASC để tránh bị đảo ngược ID
    $sql = "SELECT sv.*, l.ten_lop 
            FROM sinh_vien sv 
            LEFT JOIN lop l ON sv.lop_id = l.id 
            ORDER BY sv.id ASC";
    $rs = $conn->query($sql);
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 2. LẤY DANH SÁCH LỚP (Cho dropdown chọn lớp) */
if ($action == 'fetch_lop_list') {
    $rs = $conn->query("SELECT id, ten_lop FROM lop ORDER BY ten_lop ASC");
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 3. THÊM SINH VIÊN MỚI */
if ($action == 'insert') {
    $ma_sv = $_POST['ma_sinh_vien'];
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $lop_id = $_POST['lop_id'];
    $email = $_POST['email'];
    $sdt = $_POST['so_dien_thoai'];

    $stmt = $conn->prepare("INSERT INTO sinh_vien (ma_sinh_vien, ho_ten, ngay_sinh, gioi_tinh, lop_id, email, so_dien_thoai) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // s: string, i: integer. Thứ tự: s, s, s, s, i, s, s
    $stmt->bind_param("ssssiss", $ma_sv, $ho_ten, $ngay_sinh, $gioi_tinh, $lop_id, $email, $sdt);
    echo $stmt->execute();
    $stmt->close();
}

/* 4. CẬP NHẬT THÔNG TIN */
if ($action == 'update') {
    $id = $_POST['id'];
    $ma_sv = $_POST['ma_sinh_vien'];
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $lop_id = $_POST['lop_id'];
    $email = $_POST['email'];
    $sdt = $_POST['so_dien_thoai'];

    $stmt = $conn->prepare("UPDATE sinh_vien SET ma_sinh_vien=?, ho_ten=?, ngay_sinh=?, gioi_tinh=?, lop_id=?, email=?, so_dien_thoai=? WHERE id=?");
    $stmt->bind_param("ssssissi", $ma_sv, $ho_ten, $ngay_sinh, $gioi_tinh, $lop_id, $email, $sdt, $id);
    echo $stmt->execute();
    $stmt->close();
}

/* 5. XÓA SINH VIÊN */
if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM sinh_vien WHERE id = ?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute();
    $stmt->close();
}
?>