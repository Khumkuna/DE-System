<?php
// --- ส่วนที่ 1: PHP API สำหรับค้นหาศูนย์ (Backend Logic) ---
if (isset($_POST['find_nearest'])) {
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();

    include 'Connect.php'; 
    
    $response = ['success' => false, 'message' => ''];

    if ($conn->connect_error) {
        $response['message'] = 'Database Connection Failed';
    } else {
        $userLat = floatval($_POST['lat']);
        $userLng = floatval($_POST['lng']);

        // รัศมีค้นหาประมาณ 150 เมตร (0.00150 องศา)
        $margin = 0.00150; 

        $latMin = $userLat - $margin;
        $latMax = $userLat + $margin;
        $lngMin = $userLng - $margin;
        $lngMax = $userLng + $margin;

        // SQL ค้นหาศูนย์ที่อยู่ในขอบเขตพิกัด
        $sql = "SELECT Site_Name, Site_ID FROM site_tb 
                WHERE (CAST(Site_Latitude AS DECIMAL(10,8)) BETWEEN $latMin AND $latMax)
                AND (CAST(Site_Longitude AS DECIMAL(11,8)) BETWEEN $lngMin AND $lngMax)
                LIMIT 1";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['success'] = true;
            $response['name'] = $row['Site_Name'];
            $response['site_id'] = $row['Site_ID'];
        } else {
            $response['message'] = "ไม่พบศูนย์ดิจิทัลในระยะใกล้";
        }
    }
    $conn->close();
    ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกข้อมูลการเข้าใช้บริการ - Digital Community Center</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Sarabun', sans-serif;
            min-height: 100vh;
        }
        
        .survey-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header-section {
            background: linear-gradient(135deg, #123a0d 0%, #22543d 100%);
            padding: 40px 20px;
            color: white;
            text-align: center;
        }

        .section-label { 
            font-size: 0.85rem; 
            font-weight: 700; 
            color: #123a0d; 
            text-transform: uppercase; 
            margin-top: 30px;
            margin-bottom: 15px; 
            display: flex; 
            align-items: center; 
        }
        .section-label::after { content: ""; flex: 1; height: 2px; background: #e2e8f0; margin-left: 15px; }
        
        .location-status-bar {
            background: #ebf8ff;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 25px;
            border: 1px solid #bee3f8;
            color: #2b6cb0;
            font-weight: 600;
        }

        .center-card {
            border: 2px solid #123a0d;
            border-radius: 20px;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 10px 20px rgba(18, 58, 13, 0.05);
            text-align: center;
        }

        .btn-outline-custom {
            border: 1px solid #dee2e6;
            color: #4a5568;
            border-radius: 15px;
            padding: 12px;
            transition: all 0.3s;
            background: white;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        .btn-check:checked + .btn-outline-custom {
            background-color: #123a0d !important;
            border-color: #123a0d !important;
            color: #fff !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(18, 58, 13, 0.2);
        }

        .form-control-custom {
            border-radius: 15px;
            padding: 15px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .form-control-custom:focus {
            box-shadow: 0 0 0 4px rgba(18, 58, 13, 0.1);
            border-color: #123a0d;
        }

        .btn-submit {
            background: linear-gradient(135deg, #123a0d 0%, #22543d 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 40px;
            box-shadow: 0 10px 20px rgba(18, 58, 13, 0.2);
        }

        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="survey-container">
        <div class="header-section">
            <i class="fas fa-university fa-3x mb-3"></i>
            <h2 class="fw-bold">บันทึกข้อมูลการเข้าใช้บริการ</h2>
            <p class="mb-0 opacity-75">ศูนย์ดิจิทัลชุมชน (Digital Community Center)</p>
        </div>

        <form action="save.php" method="POST" class="p-4 p-md-5">
            
            <div class="location-status-bar d-flex align-items-center justify-content-between">
                <div>
                    <i class="fas fa-map-marker-alt me-2"></i>
                    <span id="location-text">กำลังระบุพิกัดของคุณ...</span>
                </div>
                <input type="hidden" name="lat" id="inp-lat">
                <input type="hidden" name="lng" id="inp-lng">
            </div>

            <div class="center-card mb-4">
                <small class="text-muted text-uppercase fw-bold">ศูนย์ที่ตรวจพบในพื้นที่ของคุณ</small>
                <h3 class="fw-bold mt-2" id="display-center-name" style="color: #123a0d;">กำลังค้นหาศูนย์...</h3>
                <input type="hidden" name="Site_ID" id="inp-site-id" required>
                <button type="button" class="btn btn-sm btn-link text-decoration-none mt-2" onclick="getLocation()" id="btn-retry" style="display:none;">
                    <i class="fas fa-sync-alt me-1"></i> ค้นหาอีกครั้ง
                </button>
            </div>

            <div class="section-label">ข้อมูลผู้เข้าใช้บริการ</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">ชื่อ-นามสกุล</label>
                    <input type="text" name="fullname" class="form-control form-control-custom" placeholder="ระบุชื่อของคุณ" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">เบอร์โทรศัพท์</label>
                    <input type="tel" name="phone" class="form-control form-control-custom" placeholder="08X-XXXXXXX" required>
                </div>
            </div>

            <!-- เพศ (เพิ่มใหม่) -->
            <div class="section-label">เพศ</div>
            <div class="row g-2 mb-4">
                <?php 
                $genders = ['ชาย', 'หญิง', 'ไม่ระบุ/เพศทางเลือก'];
                foreach($genders as $idx => $gender): ?>
                    <div class="col-4 col-md-4">
                        <input type="radio" class="btn-check" name="gender" id="gender_<?=$idx?>" value="<?=$gender?>" required>
                        <label class="btn btn-outline-custom w-100 py-2 d-flex align-items-center justify-content-center" for="gender_<?=$idx?>"><?=$gender?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="section-label">อายุของคุณ (ปี)</div>
            <div class="row row-cols-2 row-cols-sm-4 g-2 mb-4">
                <?php 
                $ages = ['น้อยกว่า 6', '6-9', '10-19', '20-29', '30-39', '40-49', '50-59', '60 ขึ้นไป'];
                foreach($ages as $idx => $age): ?>
                    <div class="col">
                        <input type="radio" class="btn-check" name="age_range" id="age_<?=$idx?>" value="<?=$age?>" required>
                        <label class="btn btn-outline-custom w-100" for="age_<?=$idx?>"><?=$age?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- อาชีพ (เพิ่มใหม่) -->
            <div class="section-label">อาชีพ</div>
            <div class="row row-cols-2 row-cols-md-4 g-2 mb-4">
                <?php 
                $careers = ['นักเรียน/นักศึกษา', 'ข้าราชการ/รัฐวิสาหกิจ', 'พนักงานบริษัทเอกชน', 'ธุรกิจส่วนตัว/ค้าขาย', 'รับจ้างทั่วไป', 'เกษตรกร', 'พ่อบ้าน/แม่บ้าน/เกษียณ', 'อื่นๆ'];
                foreach($careers as $idx => $career): ?>
                    <div class="col">
                        <input type="radio" class="btn-check" name="career" id="career_<?=$idx?>" value="<?=$career?>" required>
                        <label class="btn btn-outline-custom w-100 h-100 d-flex align-items-center justify-content-center text-center small py-2" style="min-height: 48px;" for="career_<?=$idx?>"><?=$career?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="section-label">วัตถุประสงค์การใช้บริการ</div>
            <div class="row g-2 mb-4">
                <?php 
                $services = ['อบรมคอมพิวเตอร์', 'ประชุม/ขอใช้พื้นที่', 'สืบค้นข้อมูลอินเทอร์เน็ต', 'พิมพ์เอกสาร/ถ่ายเอกสาร', 'การเรียนการสอน (e-Learning)', 'สตูดิโอ/ตัดต่อ', 'นันทนาการ/พักผ่อน'];
                foreach($services as $idx => $service): ?>
                    <div class="col-12 col-md-6">
                        <input type="checkbox" class="btn-check" name="services[]" id="ser_<?=$idx?>" value="<?=$service?>">
                        <label class="btn btn-outline-custom text-start d-flex align-items-center justify-content-start w-100" for="ser_<?=$idx?>">
                            <i class="far fa-square me-2 opacity-50"></i> 
                            <span><?=$service?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-submit">
                <i class="fas fa-save me-2"></i> บันทึกข้อมูลการเข้าใช้บริการ
            </button>
            
            <p class="text-center text-muted mt-4 small">
                © 2026 สำนักงานคณะกรรมการดิจิทัลเพื่อเศรษฐกิจและสังคมแห่งชาติ
            </p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function getLocation() {
        const locText = document.getElementById('location-text');
        const centerName = document.getElementById('display-center-name');
        const retryBtn = document.getElementById('btn-retry');
        
        locText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังระบุตำแหน่ง...';
        centerName.innerText = "กำลังค้นหาศูนย์ที่ใกล้ที่สุด...";
        retryBtn.style.display = "none";

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                document.getElementById('inp-lat').value = lat;
                document.getElementById('inp-lng').value = lng;
                locText.innerText = "ตำแหน่งของคุณ: " + lat.toFixed(6) + ", " + lng.toFixed(6);

                const formData = new FormData();
                formData.append('find_nearest', '1');
                formData.append('lat', lat);
                formData.append('lng', lng);

                fetch('Survey.php', { method: 'POST', body: formData })
                .then(async res => {
                    const text = await res.text();
                    try { return JSON.parse(text); } 
                    catch(e) { throw new Error("JSON Error"); }
                })
                .then(data => {
                    if(data.success) {
                        centerName.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i>' + data.name;
                        document.getElementById('inp-site-id').value = data.site_id;
                    } else {
                        centerName.innerHTML = '<span class="text-danger">' + data.message + '</span>';
                        retryBtn.style.display = "inline-block";
                    }
                })
                .catch(err => {
                    centerName.innerText = "ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้";
                    retryBtn.style.display = "inline-block";
                });

            }, function(error) {
                locText.innerText = "กรุณาอนุญาตการเข้าถึงพิกัด (GPS)";
                centerName.innerText = "ไม่สามารถระบุพิกัดได้";
                retryBtn.style.display = "inline-block";
            }, { enableHighAccuracy: true });
        } else {
            locText.innerText = "เบราว์เซอร์ไม่รองรับ GPS";
        }
    }

    // เรียกทำงานทันทีที่โหลดหน้าเสร็จ
    window.onload = getLocation;
</script>

</body>
</html>