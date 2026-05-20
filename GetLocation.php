<?php
include 'Connect.php';

header('Content-Type: application/json; charset=utf-8');

$type = isset($_GET['type']) ? $_GET['type'] : '';
$data = [];

// 1. ดึงข้อมูลอำเภอ (กรองจากชื่อจังหวัด)
if ($type == 'amphures' && isset($_GET['name'])) {
    $province = trim($_GET['name']);
    $stmt = $conn->prepare("SELECT Site_District FROM Site_tb WHERE Site_Province = ? GROUP BY Site_District ORDER BY Site_District ASC");
    $stmt->bind_param("s", $province);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
} 

// 2. ดึงข้อมูลตำบล (กรองจากชื่อจังหวัด และ ชื่ออำเภอ)
if ($type == 'districts' && isset($_GET['province']) && isset($_GET['district'])) {
    $province = trim($_GET['province']);
    $district = trim($_GET['district']);
    $stmt = $conn->prepare("SELECT Site_Subdistrict FROM Site_tb WHERE Site_Province = ? AND Site_District = ? GROUP BY Site_Subdistrict ORDER BY Site_Subdistrict ASC");
    $stmt->bind_param("ss", $province, $district);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
} 

// 3. ดึงรายชื่อศูนย์ทั้งหมดภายในตำบลนั้นๆ
if ($type == 'centers' && isset($_GET['province']) && isset($_GET['district']) && isset($_GET['Site_Subdistrict'])) {
    $province = trim($_GET['province']);
    $district = trim($_GET['district']);
    $tambon = trim($_GET['Site_Subdistrict']);
    
    // ** ตรวจสอบคอลัมน์ Site_Name ให้ตรงกับชื่อคอลัมน์เก็บชื่อศูนย์ในฐานข้อมูลของคุณด้วยครับ **
    $stmt = $conn->prepare("SELECT Site_ID, Site_Name FROM Site_tb WHERE Site_Province = ? AND Site_District = ? AND Site_Subdistrict = ? ORDER BY Site_Name ASC");
    $stmt->bind_param("sss", $province, $district, $tambon);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>