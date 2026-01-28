<?php
require 'db.php'; // Kết nối CSDL

$action = $_POST['action'] ?? '';

/* 1. LẤY DANH SÁCH LỚP (Kèm tên khoa để hiển thị) */
if ($action == 'fetch_lop') {
    // Sử dụng JOIN để lấy ten_khoa từ bảng khoa dựa trên khoa_id
    $sql = "SELECT lop.*, khoa.ten_khoa 
            FROM lop 
            LEFT JOIN khoa ON lop.khoa_id = khoa.id 
            ORDER BY lop.id ASC";
    $rs = $conn->query($sql);
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 2. LẤY DANH SÁCH KHOA (Đổ vào ô chọn trong Modal) */
if ($action == 'fetch_khoa_list') {
    $rs = $conn->query("SELECT id, ten_khoa FROM khoa ORDER BY ten_khoa ASC");
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 3. THÊM LỚP MỚI */
if ($action == 'insert') {
    $tenLop = $_POST['ten_lop'];
    $khoaId = $_POST['khoa_id'];

    $stmt = $conn->prepare("INSERT INTO lop (ten_lop, khoa_id) VALUES (?, ?)");
    $stmt->bind_param("si", $tenLop, $khoaId); // s: string, i: integer
    echo $stmt->execute();
    $stmt->close();
}

/* 4. CẬP NHẬT LỚP */
if ($action == 'update') {
    $id = $_POST['id'];
    $tenLop = $_POST['ten_lop'];
    $khoaId = $_POST['khoa_id'];

    $stmt = $conn->prepare("UPDATE lop SET ten_lop = ?, khoa_id = ? WHERE id = ?");
    $stmt->bind_param("sii", $tenLop, $khoaId, $id);
    echo $stmt->execute();
    $stmt->close();
}

/* 5. XÓA LỚP */
if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM lop WHERE id = ?");
    $stmt->bind_param("i", $id); // Đảm bảo không có dấu & ở đây
    echo $stmt->execute();
    $stmt->close();
}
?>