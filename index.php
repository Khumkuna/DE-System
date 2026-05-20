<?php
if (isset($_POST['find_nearest'])) {
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();
    include 'Connect.php';
    
    $response = ['success' => false, 'message' => ''];

    // ตรวจสอบว่ามีพิกัดส่งมาจาก GPS หรือไม่
    if (!isset($_POST['lat']) || !isset($_POST['lng'])) {
        $response['message'] = 'ไม่พบพิกัด GPS ส่งมาจากหน้าบ้าน';
    } else if ($conn->connect_error) {
        $response['message'] = 'Database Connection Failed';
    } else {
        // รับค่าพิกัดจริงจาก GPS (แปลงเป็น float เพื่อความปลอดภัยของข้อมูล)
        $targetLat = (float)$_POST['lat'];
        $targetLng = (float)$_POST['lng'];
        
        // รัศมีค้นหา (กิโลเมตร) ขยายเป็น 100 กม. เผื่อผู้ใช้อยู่ในพื้นที่ห่างไกล
        $maxDistanceKm = 100; 

        // ใช้สูตร Haversine คำนวณหาจุดที่ใกล้ที่สุดจากพิกัด GPS ปัจจุบัน
        $sql = "SELECT Site_Name, Site_ID, Site_Latitude, Site_Longitude,
                (6371 * acos(
                    cos(radians($targetLat)) 
                    * cos(radians(CAST(Site_Latitude AS DECIMAL(10,6)))) 
                    * cos(radians(CAST(Site_Longitude AS DECIMAL(10,6))) - radians($targetLng)) 
                    + sin(radians($targetLat)) 
                    * sin(radians(CAST(Site_Latitude AS DECIMAL(10,6))))
                )) AS distance 
                FROM site_tb 
                HAVING distance <= $maxDistanceKm 
                ORDER BY distance ASC 
                LIMIT 1";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            $response['success'] = true;
            $response['name'] = $row['Site_Name'];
            $response['site_id'] = $row['Site_ID'];
            $response['distance_km'] = round($row['distance'], 2); // ระยะห่างจริงในหน่วย กม.
        } else {
            $response['message'] = "ไม่พบศูนย์ดิจิทัลชุมชนที่ใกล้เคียงในรัศมี $maxDistanceKm กิโลเมตร";
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
<html lang="en">

<?php include 'Tools/Header_index.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">


      <?php 
      include 'Tools/Sidebar_index.php'; 
      ?>


        <!-- Content Start -->
        <div class="content">
            <?php 
            include 'Tools/Navbar_Index.php'; 
            ?>


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4" id="top">
                <h1>ข้อมูลการให้บริการ</h1>
                <hr>
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-users fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการวันนี้</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการเดือนนี้</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-6">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการทั้งหมด</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">ผู้เข้าใช้บริการในแต่ละเดือน</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">การเข้าใช้บริการในแต่ละประเภท</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Top 5 ของผู้เข้าใช้บริการ</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->


            <!-- Widgets Start -->
             <br>
            <br>
            <br>

            <div class="container-fluid pt-4 px-4" id="service-section">
                <h1>การบันทึกข้อมูลเข้าใช้บริการ</h1>
                <hr>
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">ลงชื่อเข้าใช้ผ่าน QR-Code</h6>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/qr-code.png" alt="" style="width: 200px; height: 200px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">สแกน QR-Code เพื่อเข้าใช้บริการ</h6>
                                    </div>
                                    <span>กรุณาสแกน QR-Code เพื่อบันทึกข้อมูลเข้าใช้บริการของคุณ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">ลงชื่อเข้าใช้บริการ (Self Service)</h6>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-center py-3">
                                <div class="attendance-container mb-3">
                                    <button id="capture-btn" class="btn btn-primary shadow-lg btn-circle-attendance" data-bs-toggle="modal" data-bs-target="#recordModal" type="button">
                                        <div class="btn-content">
                                            <i class="fa fa-user-edit fa-2x mb-2"></i>
                                            <span>ลงชื่อเข้าใช้</span>
                                        </div>
                                    </button>
                                </div>
                                <p class="text-muted text-center small">คลิกปุ่มเพื่อกรอกข้อมูลการเข้าใช้บริการด้วยตนเอง</p>
                            </div>

                            <style>
                                .btn-circle-attendance {
                                    width: 200px;
                                    height: 200px;
                                    border-radius: 50% !important;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: bold;
                                    text-transform: uppercase;
                                    border: 6px solid rgba(255,255,255,0.5);
                                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                                    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                                }
                                .btn-circle-attendance:hover {
                                    transform: scale(1.1) rotate(5deg);
                                    box-shadow: 0 15px 30px rgba(0,123,255,0.4) !important;
                                    border-color: #fff;
                                }
                                .btn-content {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                }
                            </style>

                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


            <br>
            <br>
            <br>

            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4" id="center-section">
                <h1>ข้อมูลศูนย์ดิจิทัลชุมชน</h1>
                <hr>
                <div class="row g-4">
                                    <div class="col-sm-12 col-md-6 col-xl-8">
                                        <div class="h-100 bg-light rounded p-4">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="mb-0">ข้อมูลศูนย์ดิจิทัลชุมชน</h6>
                                                <form class="d-flex gap-2" action="" method="POST" id="searchForm">
                                                <div class="d-flex gap-2">
                                                    <select id="provinceSelect" name="provinceSelect" class="form-select form-select-sm" style="width: auto;">
                                                        <option value="">-- เลือกจังหวัด --</option>
                                                        <?php $GetSite = $conn->query("SELECT * FROM `Site_tb` GROUP BY Site_Province");
                                                        while($row = $GetSite->fetch_assoc()){
                                                            $province = $row['Site_Province'];
                                                            echo "<option value='$province'>$province</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <button type="submit" name="searchBtn" class="btn btn-sm btn-primary" id="searchBtn">ค้นหา</button>
                                                </div>
                                                </form>
                                            </div>
                                            <div id="map" style="width: 100%; height: 400px; border-radius: 5px;"></div>
                                        </div>
                                    </div>
                                    <?php 
                                        if(isset($_POST['searchBtn'])){
                                            $selectedProvince = $_POST['provinceSelect'];
                                            $GetSite = $conn->query("SELECT * FROM `Site_tb` WHERE Site_Province = '$selectedProvince'");
                                            $Result = [];
                                            while($row = $GetSite->fetch_assoc()){
                                                
                                                $lat = $row['Site_Latitude'];
                                                $long = $row['Site_Longitude'];

                                                $Result[] = [
                                                    'name' => $row['Site_Name'],
                                                    'lat' => $lat,
                                                    'long' => $long
                                                ];
                                                
  
                                            }
                                            
                                        }

                                    ?>
                                    <script>
                                        var map = L.map('map').setView([13.736717, 100.523186], 5); // ตั้งค่าพิกัดเริ่มต้นและระดับการซูม

                                        // เพิ่มแผนที่จาก OpenStreetMap
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                        }).addTo(map);

                                        // เพิ่มหมุดสำหรับแต่ละศูนย์ดิจิทัลชุมชน
                                        <?php if(isset($Result)){ 
                                            foreach($Result as $site){
                                                echo "L.marker([$site[lat], $site[long]]).addTo(map).bindPopup('$site[name]').bindTooltip('$site[name]');";
                                            }
                                        } ?>
                                    </script>
                               


                                    
                    
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">แสดงรายการที่ค้นหา</h6>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">ศูนย์ 1</h6>
                                    </div>
                                    <p class="mb-1">กรุงเทพมหานคร</p>
                                    <small>แขวงปทุมวัน</small>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-12">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">แสดงรายการที่ค้นหา</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" align="center">ลำดับ</th>
                                            <th scope="col">ชื่อศูนย์ดิจิทัลชุมชน</th>
                                            <th scope="col">ตำบล</th>
                                            <th scope="col">อำเภอ</th>
                                            <th scope="col">จังหวัด</th>
                                            <th scope="col">พิกัด</th>
                                        </tr>
                                    </thead>
                                    <?php 

                                    $ShowSite = $conn->query("SELECT * FROM `Site_tb` where Site_Province = '$selectedProvince' ORDER BY Site_ID ASC");
                                    while($row = $ShowSite->fetch_assoc()){
                                        $Site_ID = $row['Site_ID'];
                                        $Site_Name = $row['Site_Name'];
                                        $Site_Province = $row['Site_Province'];
                                        $Site_District = $row['Site_District'];
                                        $Site_SubDistrict = $row['Site_Subdistrict'];
                                        $Site_Latitude = $row['Site_Latitude'];
                                        $Site_Longitude = $row['Site_Longitude'];
                                        $LatLong = $Site_Latitude.','.$Site_Longitude;

                                            echo "
                                                <tbody>
                                                    <tr>
                                                        <td align='center'>$Site_ID</td>
                                                        <td>$Site_Name</td>
                                                        <td>$Site_SubDistrict</td>
                                                        <td>$Site_District</td>
                                                        <td>$Site_Province</td>
                                                        <td><a href='https://maps.google.com/maps?q=$LatLong' target='_blank' class='btn btn-sm btn-info'>Google Maps</a></td>
                                                    </tr>
                                                </tbody>
                                            ";
                                        }
                                        if($ShowSite->num_rows == 0){
                                            echo "
                                                <tbody>
                                                    <tr>
                                                        <td colspan='4' align='center'>ไม่มีข้อมูล</td>
                                                    </tr>
                                                </tbody>
                                            ";
                                        }  
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

<!-- 2. ส่วนของ Bootstrap Modal HTML -->
<div class="modal fade" id="recordModal" tabindex="-1" aria-labelledby="recordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            
            <div class="modal-header border-0 pt-4 px-4 pb-2" style="background: linear-gradient(to right, #ffffff, #f8f9fa);">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fas fa-edit text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="recordModalLabel" style="color: #1a202c; letter-spacing: -0.5px;">
                            บันทึกข้อมูลการเข้าใช้งาน
                        </h5>
                        <small class="text-muted">กรุณากรอกข้อมูลให้ครบถ้วนเพื่อสิทธิประโยชน์ของคุณ</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <style>
                /* Custom CSS สำหรับความสวยงาม */
                .section-label { font-size: 0.8rem; font-weight: 700; color: #4a5568; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; display: flex; align-items: center; }
                .section-label::after { content: ""; flex: 1; height: 1px; background: #edf2f7; margin-left: 10px; }
                
                .location-card { background: #ebf8ff; border: 1px solid #bee3f8; border-radius: 16px; padding: 12px 20px; margin-bottom: 24px; transition: all 0.3s ease; }
                
                .center-display-box { 
                    background: white; border: 2px solid #123a0d; border-radius: 18px; padding: 20px; 
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    position: relative; transition: transform 0.2s ease;
                }
                .center-display-box:hover { transform: translateY(-2px); }

                .btn-outline-custom {
                    border: 1px solid #e2e8f0; color: #4a5568; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); 
                    border-radius: 12px; font-size: 0.9rem; font-weight: 500; padding: 10px; background: white;
                }
                .btn-check:checked + .btn-outline-custom {
                    background-color: #123a0d !important; border-color: #123a0d !important; color: #fff !important;
                    box-shadow: 0 4px 12px rgba(18, 58, 13, 0.2); transform: scale(1.02);
                }
                .btn-outline-custom:hover:not(.btn-check:checked + .btn-outline-custom) { background-color: #f7fafc; border-color: #cbd5e0; }

                .form-control-lg-custom { 
                    border-radius: 12px; padding: 14px; border: 1px solid #e2e8f0; font-size: 1rem; background-color: #f8fafc;
                }
                .form-control-lg-custom:focus { 
                    border-color: #123a0d; box-shadow: 0 0 0 4px rgba(18, 58, 13, 0.08); background-color: #fff;
                }

                .btn-save-custom { 
                    background: linear-gradient(135deg, #123a0d 0%, #22543d 100%); 
                    color: white; border: none; padding: 14px 40px; border-radius: 14px; font-weight: 700;
                    box-shadow: 0 10px 15px -3px rgba(18, 58, 13, 0.3); transition: all 0.3s ease;
                }
                .btn-save-custom:hover { color: white; transform: translateY(-2px); box-shadow: 0 20px 25px -5px rgba(18, 58, 13, 0.4); opacity: 0.95; }
                
                .badge-location { background: #3182ce; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
                
                /* เอนิเมชันสำหรับช่องกรอกข้อมูลอื่นๆ */
                .other-input-container {
                    display: none;
                    animation: fadeIn 0.3s ease forwards;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(-5px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            </style>

            <form action="Processing" method="POST">
                <div class="modal-body p-4">
                    
                    <!-- ส่วนพิกัด -->
                    <div class="location-card d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center text-primary">
                            <i class="fas fa-map-marker-alt me-2 animate-bounce"></i>
                            <span id="modal-location-status" class="fw-bold small">กำลังระบุพิกัดปัจจุบัน...</span>
                        </div>
                        <span class="badge-location">GPS Active</span>
                        <input type="hidden" name="lat" id="modal-lat">
                        <input type="hidden" name="lng" id="modal-lng">
                    </div>

                    <!-- ศูนย์ดิจิทัลชุมชน -->
                    <div class="mb-4">
                        <label class="section-label">ศูนย์ดิจิทัลชุมชนที่ตรวจพบ</label>
                        <div class="center-display-box">
                            <div class="text-center">
                                <i class="fas fa-university mb-2" style="color: #123a0d; font-size: 1.5rem;"></i>
                                <h5 class="fw-bold mb-1" id="center_name_text" style="color: #123a0d;">กำลังค้นหาศูนย์ที่ใกล้ที่สุด...</h5>
                                <button type="button" class="btn btn-sm text-primary p-0 border-0" onclick="findNearestCenter()" id="retry-btn" style="display:none; font-size: 0.75rem;">
                                    <i class="fas fa-sync-alt me-1"></i> ตรวจสอบอีกครั้ง
                                </button>
                            </div>
                            <input type="hidden" name="Site_ID" id="community_center_input" required>
                        </div>
                    </div>
                    
                    <!-- ข้อมูลส่วนตัว & เบอร์โทรศัพท์ -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="section-label">ข้อมูลส่วนตัว</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px;"><i class="far fa-user text-muted"></i></span>
                                <input type="text" name="fullname" class="form-control form-control-lg-custom border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="ชื่อ-นามสกุล ของคุณ" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="section-label">เบอร์โทรศัพท์</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-phone-alt text-muted"></i></span>
                                <input type="text" name="phone" class="form-control form-control-lg-custom border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="08X-XXXXXXX" required>
                            </div>
                        </div>
                    </div>

                    <!-- เพศ -->
                    <div class="mb-4">
                        <span class="section-label">เพศ</span>
                        <div class="row g-2">
                            <?php 
                            $genders = ['ชาย', 'หญิง', 'ไม่ระบุ/เพศทางเลือก'];
                            foreach($genders as $idx => $gender): ?>
                                <div class="col">
                                    <input type="radio" class="btn-check" name="gender" id="gender_<?=$idx?>" value="<?=$gender?>" required>
                                    <label class="btn btn-outline-custom w-100 h-100 d-flex align-items-center justify-content-center py-2" for="gender_<?=$idx?>"><?=$gender?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- อายุ -->
                    <div class="mb-4">
                        <span class="section-label">อายุของคุณ (โดยประมาณ)</span>
                        <div class="row row-cols-2 row-cols-sm-4 g-2">
                            <?php 
                            $ages = ['น้อยกว่า 6 ปี', '6-9 ปี', '10-19 ปี', '20-29 ปี', '30-39 ปี', '40-49 ปี', '50-59 ปี', '60 ปีขึ้นไป'];
                            foreach($ages as $idx => $age): ?>
                                <div class="col">
                                    <input type="radio" class="btn-check" name="age_range" id="age_<?=$idx?>" value="<?=$age?>" required>
                                    <label class="btn btn-outline-custom w-100 h-100 d-flex align-items-center justify-content-center" for="age_<?=$idx?>"><?=$age?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- อาชีพ -->
                    <div class="mb-4">
                        <span class="section-label">อาชีพ</span>
                        <div class="row row-cols-2 row-cols-md-4 g-2 mb-2">
                            <?php 
                            $careers = ['นักเรียน/นักศึกษา', 'ข้าราชการ/รัฐวิสาหกิจ', 'พนักงานบริษัทเอกชน', 'ธุรกิจส่วนตัว/ค้าขาย', 'รับจ้างทั่วไป', 'เกษตรกร', 'พ่อบ้าน/แม่บ้าน/เกษียณ', 'อื่นๆ'];
                            foreach($careers as $idx => $career): ?>
                                <div class="col">
                                    <input type="radio" class="btn-check" name="career" id="career_<?=$idx?>" value="<?=$career?>" onchange="toggleCareerOther(this)" required>
                                    <label class="btn btn-outline-custom w-100 h-100 d-flex align-items-center justify-content-center text-center small" style="min-height: 44px; padding: 5px;" for="career_<?=$idx?>"><?=$career?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- ช่องกรอกระบุอาชีพอื่นๆ -->
                        <div id="career_other_container" class="other-input-container mt-2">
                            <input type="text" name="career_other" id="career_other_input" class="form-control form-control-lg-custom" placeholder="โปรดระบุอาชีพของคุณ">
                        </div>
                    </div>

                    <!-- ข้อมูลความพิการ -->
                    <div class="mb-4">
                        <span class="section-label">ข้อมูลความพิการ</span>
                        <div class="row row-cols-2 row-cols-md-3 g-2 mb-2">
                            <?php 
                            $disabilities = [
                                'ไม่ใช่ผู้พิการ', 
                                'ทางการมองเห็น', 
                                'ทางการได้ยินหรือสื่อความหมาย', 
                                'ทางร่างกายหรือการเคลื่อนไหว', 
                                'ทางสติปัญญา/การเรียนรู้/ออทิสติก', 
                                'อื่นๆ'
                            ];
                            foreach($disabilities as $idx => $disability): ?>
                                <div class="col">
                                    <input type="radio" class="btn-check" name="disability_status" id="dis_<?=$idx?>" value="<?=$disability?>" onchange="toggleDisabilityOther(this)" required>
                                    <label class="btn btn-outline-custom w-100 h-100 d-flex align-items-center justify-content-center text-center small py-2" style="min-height: 46px;" for="dis_<?=$idx?>"><?=$disability?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- ช่องกรอกระบุความพิการอื่นๆ -->
                        <div id="disability_other_container" class="other-input-container mt-2">
                            <input type="text" name="disability_other" id="disability_other_input" class="form-control form-control-lg-custom" placeholder="โปรดระบุข้อมูลความพิการเพิ่มเติม">
                        </div>
                    </div>

                    <!-- วัตถุประสงค์การใช้บริการ -->
                    <div class="mb-2">
                        <span class="section-label">วัตถุประสงค์การใช้บริการ</span>
                        <div class="row row-cols-2 row-cols-md-3 g-2">
                            <?php 
                            $services = ['อบรม', 'ประชุม/ขอใช้พื้นที่', 'สืบค้นข้อมูล', 'พิมพ์เอกสาร', 'การเรียนการสอน', 'สตูดิโอ', 'นันทนาการ'];
                            foreach($services as $idx => $service): ?>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="services[]" id="ser_<?=$idx?>" value="<?=$service?>">
                                    <label class="btn btn-outline-custom w-100 text-start ps-3" for="ser_<?=$idx?>">
                                        <i class="far fa-circle me-2 opacity-50"></i><?=$service?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between">
                    <input type="hidden" name="Survey" value="1">
                    <button type="submit" name="Modal_Save" class="btn btn-save-custom px-5">
                        บันทึกข้อมูล <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript ควบคุมการเปิด-ปิด ช่องกรอกระบุเพิ่มเติม -->
<script>
function toggleCareerOther(element) {
    const container = document.getElementById('career_other_container');
    const input = document.getElementById('career_other_input');
    
    if (element.value === 'อื่นๆ') {
        container.style.display = 'block';
        input.setAttribute('required', 'required');
        input.focus();
    } else {
        container.style.display = 'none';
        input.removeAttribute('required');
        input.value = ''; // เคลียร์ค่าทิ้งถ้าเปลี่ยนไปเลือกข้ออื่น
    }
}

function toggleDisabilityOther(element) {
    const container = document.getElementById('disability_other_container');
    const input = document.getElementById('disability_other_input');
    
    if (element.value === 'อื่นๆ') {
        container.style.display = 'block';
        input.setAttribute('required', 'required');
        input.focus();
    } else {
        container.style.display = 'none';
        input.removeAttribute('required');
        input.value = ''; // เคลียร์ค่าทิ้งถ้าเปลี่ยนไปเลือกข้ออื่น
    }
}
</script>

<script>
function findNearestCenter() {
    const statusText = document.getElementById('modal-location-status');
    const centerText = document.getElementById('center_name_text');
    const centerInput = document.getElementById('community_center_input');
    
    statusText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังตรวจสอบพิกัด...';
    
    if (!navigator.geolocation) {
        statusText.innerText = "เบราว์เซอร์ไม่รองรับการระบุพิกัด";
        return;
    }

    navigator.geolocation.getCurrentPosition(function(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        document.getElementById('modal-lat').value = lat;
        document.getElementById('modal-lng').value = lng;
        statusText.innerText = "พิกัดปัจจุบัน: " + lat.toFixed(6) + ", " + lng.toFixed(6);
        
        sendToSearch(lat, lng);
    }, function(error) {
        statusText.innerText = "ไม่สามารถเข้าถึงพิกัดได้ (โปรดอนุญาตสิทธิ์)";
        centerText.innerText = "กรุณาเปิด GPS และลองใหม่อีกครั้ง";
    }, { enableHighAccuracy: true });
}

function sendToSearch(lat, lng) {
    const centerText = document.getElementById('center_name_text');
    const centerInput = document.getElementById('community_center_input');
    
    const formData = new FormData();
    formData.append('find_nearest', '1');
    formData.append('lat', lat);
    formData.append('lng', lng);

    fetch(window.location.href, { method: 'POST', body: formData })
    .then(async res => {
        const text = await res.text();
        try { return JSON.parse(text); } 
        catch(e) { 
            console.error("Server Error:", text);
            throw new Error("JSON Parse Error"); 
        }
    })
    .then(data => {
        if(data.success) {
            centerText.innerHTML =  data.name;
            centerInput.value = data.site_id;
        } else {
            centerText.style.fontSize = "0.8rem";
            centerText.innerHTML = "<span class='text-danger'>" + data.message + "</span>";
        }
    })
    .catch(err => { 
        centerText.innerText = "เกิดข้อผิดพลาดในการเชื่อมต่อ"; 
    });
}

document.getElementById('recordModal').addEventListener('shown.bs.modal', findNearestCenter);
</script>


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>