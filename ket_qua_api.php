<?php
require 'db.php';
$action = $_POST['action'] ?? '';

/* 1. LẤY DANH SÁCH ĐIỂM KÈM TÊN SV VÀ TÊN MÔN */
if ($action == 'fetch') {
    $sql = "SELECT kq.*, sv.ho_ten, mh.ten_mon 
            FROM ket_qua_hoc_tap kq 
            JOIN sinh_vien sv ON kq.sinh_vien_id = sv.id 
            JOIN mon_hoc mh ON kq.mon_hoc_id = mh.id 
            ORDER BY kq.id ASC";
    $rs = $conn->query($sql);
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

/* 2. LẤY DANH SÁCH SV VÀ MÔN CHO DROPDOWN */
if ($action == 'fetch_options') {
    $sv = $conn->query("SELECT id, ho_ten FROM sinh_vien");
    $mh = $conn->query("SELECT id, ten_mon FROM mon_hoc");
    $data = [
        'sinh_vien' => $sv->fetch_all(MYSQLI_ASSOC),
        'mon_hoc' => $mh->fetch_all(MYSQLI_ASSOC)
    ];
    echo json_encode($data);
}

/* 3. THÊM ĐIỂM */
if ($action == 'insert') {
    $sv_id = $_POST['sv_id'];
    $mh_id = $_POST['mh_id'];
    $diem = $_POST['diem'];
    $stmt = $conn->prepare("INSERT INTO ket_qua_hoc_tap (sinh_vien_id, mon_hoc_id, diem) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $sv_id, $mh_id, $diem);
    echo $stmt->execute();
}

/* 4. XÓA */
if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM ket_qua_hoc_tap WHERE id=?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute();
}
?>