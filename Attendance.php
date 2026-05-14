<?php
$PageActive = 'Attendance';
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'Tools/Header.php';   

$DateToday = date('Y-m-d');        
$GetAttendance = "SELECT * FROM `attendance_tb` WHERE `Site_ID` = '$Login_Site' AND ATT_Date = '$DateToday'";
$ResultAttendance = $conn->query($GetAttendance);
$AttendanceData = $ResultAttendance->fetch_assoc();
$CheckInTimeToday = $AttendanceData['ATT_TimeIn'];
$CheckInImageToday = $AttendanceData['ATT_Image'];
$CheckInLatitudeToday = $AttendanceData['ATT_Latitude'];
$CheckInLongitudeToday = $AttendanceData['ATT_Longitude'];
$CheckInDeviceToday = $AttendanceData['ATT_Device'];





?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
    <?php include 'Tools/Sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
            
        <?php include 'Tools/Navbar.php'; ?>


            <!-- Button Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12" align="center">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" style="color: #1ff308;" >
                        <span class="mb-0" >
                        <h1 class="mb-0" style="color: #123a0d;" >การบันทึกเวลา เข้างาน - ออกงาน <?php echo $DateToday ?></h1><br>
                        <h6 class="mb-0" style="color: #123a0d;" >ระบบบันทึกเวลาเข้า-ออกงานด้วยใบหน้าและระบบตรวจจับพิกัด</h6><br><br>
                        <h2 id="realtime-clock" style="color: #123a0d;" ><?php echo date("d-m-Y H:i:s"); ?></h2></span> 
                        </div>
                     </div>   
                </div>
                <br>


                <form id="attendance-form" method="POST" action="Processing">
                 <div class="row g-4" >
                    <div class="col-sm-12 col-xl-6">
                        <!-- เพิ่ม flex-column เพื่อให้ status อยู่บน video -->
                        <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center p-4" style="min-height: 400px;">
                            
                            <!-- ส่วนแสดงสถานะกล้อง (จะอยู่ด้านบนเสมอ) -->
                            <?php if($CheckInImageToday=="") { ?>
                            <div id="camera-status" class="mb-3" style="text-align: center; font-size: 1.1rem;">
                                กำลังตรวจสอบกล้อง...
                            </div>
                            <?php } ?>


                            <?php 
                            if($CheckInImageToday=="")
                            { ?>
                            <!-- ส่วนของวิดีโอ -->
                            <video id="camera-feed" width="90%" height="auto" autoplay 
                                style="border-radius: 15px; border: 3px solid #eee; background-color: #000;">
                            </video>

                            <?php } else { ?>
                                <div class="text-center">
                                    <h4 style="color: #123a0d;">คุณได้บันทึกเข้างานแล้วในวันนี้</h4>
                                    <img src="attendance_pics/attendance_images/<?php echo $CheckInImageToday; ?>" alt="Check-in Image" style="max-width: 100%; border-radius: 15px; border: 3px solid #eee;">
                                </div> 
                                <?php } ?> 
                            
                        </div>
                    </div>

                     <div class="col-sm-12 col-xl-6" >
                        
                            <input  name="Login_Site" hidden value="<?php echo $Login_Site; ?>">
                            <input  name="Login_Acc" hidden value="<?php echo $Login_Acc; ?>">
                            <!-- พิกัด -->
                            <input hidden id="lat" name="lat">
                            <input hidden id="lng" name="lng">
                            <!-- อุปกรณ์ -->
                            <input hidden id="device_info" name="device_info">

                            <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" >
                            <?php if($CheckInTimeToday == "-"|| $CheckInTimeToday == null || $CheckInTimeToday == "") { ?>
                                <h2 class="mb-0" style="color: #123a0d;" >โปรดทำการบันทึกเวลาเข้าปฏิบัติงาน</h2>
                            <?php } else { ?>
                                <h5 class="mb-0" style="color: #123a0d;" >กรุณาเลือกประเภทการปฏิบัติงานของคุณในวันนี้</h5>
                            <?php } ?>
                            </div>



                               <?php if($CheckInTimeToday == "-" || $CheckInTimeToday == null || $CheckInTimeToday == "") { ?>
    <!-- โหมดบันทึกเข้างาน -->
    <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center p-4" style="min-height: 500px;">
        <div class="text-center mb-4">
            <i class="fas fa-user-clock fa-3x mb-3" style="color: #123a0d;"></i>
            <h4 style="color: #123a0d;">พร้อมบันทึกเข้างาน</h4>
        </div>
        
        <button id="capture-btn" class="btn btn-primary shadow-lg btn-attendance" type="button" name="CheckIn" disabled>
            บันทึกเข้างาน
        </button>

        
        <canvas id="capture-canvas" style="display:none;"></canvas>
    </div>

    <script>
        document.getElementById('capture-btn').addEventListener('click', function() {
            const canvas = document.getElementById('capture-canvas');
            const video = document.getElementById('camera-feed');
            const ctx = canvas.getContext('2d');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);
            
            const imageData = canvas.toDataURL('image/jpeg');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'camera_capture';
            input.value = imageData;
            
            document.getElementById('attendance-form').appendChild(input);
            const checkInInput = document.createElement('input');
            checkInInput.type = 'hidden';
            checkInInput.name = 'CheckIn';
            checkInInput.value = '1';
            document.getElementById('attendance-form').appendChild(checkInInput);
            
            document.getElementById('attendance-form').submit();
        });
    </script>

<?php } else { ?>
    <!-- โหมดบันทึกออกงาน -->
    <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center p-4" style="min-height: 500px;">
        
        <div class="w-100 px-4 mb-4">
            <!-- <label class="form-label fw-bold" style="color: #123a0d;">ประเภทการปฏิบัติงานวันนี้:</label> -->
            <select class="form-select form-select-lg shadow-sm" id="site-select" name="CheckOut_Remark" required>
                <option value="" disabled selected>--- กรุณาเลือกรายการ ---</option>
                <option value="การเปิด-ปิด และดูแลความเรียบร้อยของสถานที่ให้บริการ">การเปิด-ปิด และดูแลความเรียบร้อยฯ</option>
                <option value="การลงทะเบียนและจัดเก็บสถิติผู้เข้าใช้บริการภายในศูนย์ฯ">การลงทะเบียนและจัดเก็บสถิติฯ</option>
                <option value="การให้บริการคำแนะนำการใช้งานคอมพิวเตอร์และอินเทอร์เน็ตพื้นฐาน">การให้คำแนะนำด้านไอทีพื้นฐาน</option>
                <option value="การสนับสนุนและช่วยสอนการเข้าใช้งานแอปพลิเคชันหรือสวัสดิการจากภาครัฐ">ช่วยสอนแอปฯ/สวัสดิการรัฐ</option>
                <option value="การจัดการฝึกอบรมหลักสูตรความรู้เท่าทันเทคโนโลยีและดิจิทัล (Digital Literacy)">จัดอบรม Digital Literacy</option>
                <option value="การส่งเสริมและให้คำปรึกษาด้านการตลาดออนไลน์ (E-commerce) ให้กับสินค้าชุมชน">ส่งเสริม E-commerce ชุมชน</option>
                <option value="การผลิตสื่อประชาสัมพันธ์และแจ้งข่าวสารชุมชนผ่านสื่อสังคมออนไลน์">ผลิตสื่อประชาสัมพันธ์ออนไลน์</option>
                <option value="การตรวจสอบและบำรุงรักษาอุปกรณ์คอมพิวเตอร์และอุปกรณ์ต่อพ่วง">บำรุงรักษาอุปกรณ์คอมพิวเตอร์</option>
                <option value="การดูแลและบริหารจัดการระบบโครงข่ายอินเทอร์เน็ต (Wi-Fi)">ดูแลระบบเครือข่าย Wi-Fi</option>
                <option value="การแก้ไขปัญหาด้านซอฟต์แวร์พื้นฐานและการป้องกันไวรัส">แก้ปัญหาซอฟต์แวร์/ไวรัส</option>
                <option value="การจัดทำรายงานผลการปฏิบัติงานประจำเดือนและสรุปภาพรวม">จัดทำรายงานและสรุปผล</option>
                <option value="การประสานงานกับหน่วยงานต้นสังกัดและผู้นำชุมชน">ประสานงานหน่วยงาน/ชุมชน</option>
                <option value="การสำรวจความต้องการและทัศนคติด้านเทคโนโลยี">สำรวจความต้องการเทคโนโลยี</option>
                <option value="การดูแลรักษาความสะอาดและจัดระเบียบพื้นที่">ดูแลความสะอาดและจัดระเบียบ</option>
                <option value="การปฏิบัติงานตามนโยบายพิเศษหรือโครงการเร่งด่วน">งานนโยบายพิเศษ/งานเร่งด่วน</option>
            </select>
        </div>

        <button class="btn btn-danger shadow-lg btn-attendance" type="submit" name="CheckOut">
            บันทึกออกงาน
        </button>
        
        <canvas id="capture-canvas" style="display:none;"></canvas>
    </div>
<?php } ?>

<style>
    /* CSS เพิ่มเติมเพื่อให้ปุ่มสมดุล */
    .btn-attendance {
        width: 260px;
        height: 260px;
        border-radius: 50% !important;
        font-size: 1.5rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 8px solid rgba(255,255,255,0.3);
        transition: all 0.3s ease;
    }
    
    .btn-attendance:hover:not(:disabled) {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .btn-attendance:disabled {
        background-color: #6c757d;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    /* ปรับแต่ง Select ให้เข้ากับ UI */
    .form-select-lg {
        font-size: 1rem;
        border-radius: 12px;
    }
</style>
                            </div>
                        </form>
                     </div>   
                </div>
                <br>

                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12" align="center">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" style="color: #1ff308;" >
                        <span class="mb-0" >
                                <?php if($CheckInTimeToday != "-" && $CheckInTimeToday != null && $CheckInTimeToday != "") {
                                    echo "
                                    <h2 class='mb-0' style='color: #123a0d;' >คุณได้บันทึกเข้างานแล้วในวันนี้ </h2> <br> 

                                    <h4  style='color: #123a0d;'> เวลา: " . date("H:i", strtotime($_SESSION['CheckInTimeToday'])) . " น. </h4> 
                                    <h4  style='color: #123a0d;'> พิกัดการ: " . $CheckInLatitudeToday . "," . $CheckInLongitudeToday . "</h4> 
                                    <h4  style='color: #123a0d;'> อุปกรณ์: " . $CheckInDeviceToday . "</h4>";


                                } else {
                                    echo "<h2 class='mb-0' style='color: #123a0d;' >คุณยังไม่ได้บันทึกเข้างานในวันนี้</h2>";
                                }
                                ?>

                            <br><br><br><br>
                        

                        </div>
                     </div>   
                </div>





            </div>
            <!-- Button End -->
  

        <!-- Back to Top -->
        <!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a> -->

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
    <script>
        function updateClock() {
            var now = new Date();
            var day = String(now.getDate()).padStart(2, '0');
            var month = String(now.getMonth() + 1).padStart(2, '0');
            var year = now.getFullYear();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');
            var timeString = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds;
            document.getElementById('realtime-clock').textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        
    </script>
    


    <script>
// ส่วนจัดการกล้อง
const video = document.getElementById('camera-feed');
const btn = document.getElementById('capture-btn');
const status = document.getElementById('camera-status');

// ขออนุญาตใช้กล้อง
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
        // ถ้ากล้องติด ให้เปิดปุ่มบันทึก
        btn.disabled = false; 
        status.innerHTML = "● กล้องพร้อมใช้งาน";
        status.style.color = "green";
    })
    .catch(err => {
        // ถ้ากล้องไม่ติด หรือโดนบล็อก
        status.innerHTML = "⚠️ กรุณาอนุญาตให้เข้าถึงกล้อง";
        status.style.color = "red";
        btn.disabled = true;
        console.error("Camera error:", err);
    });
</script>

<script>
    document.getElementById('capture-btn').addEventListener('click', function() {
    const canvas = document.getElementById('capture-canvas');
    const video = document.getElementById('camera-feed');
    const form = document.getElementById('attendance-form');
    const ctx = canvas.getContext('2d');
    
    // 1. ตั้งค่าขนาด Canvas ให้เท่ากับวิดีโอจริงที่แสดงผล
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0);
    
    // 2. แปลงรูปจาก Canvas เป็น Base64 (คุณภาพ 0.8 เพื่อประหยัดพื้นที่)
    const imageData = canvas.toDataURL('image/jpeg', 0.8);
    
    // 3. สร้าง Hidden Input เพื่อเก็บข้อมูลรูปภาพ
    // ลบ input เดิมที่มีชื่อเดียวกันทิ้งก่อน (ถ้ามี) เพื่อป้องกันข้อมูลซ้ำ
    const oldInput = document.querySelector('input[name="camera_capture"]');
    if (oldInput) oldInput.remove();

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'camera_capture';
    input.value = imageData;
    form.appendChild(input);

    // 4. สร้าง Hidden Input เพื่อบอก Processing ว่านี่คือการ CheckIn
    const checkInInput = document.createElement('input');
    checkInInput.type = 'hidden';
    checkInInput.name = 'CheckIn';
    checkInInput.value = '1';
    form.appendChild(checkInInput);
    
    // 5. ส่งฟอร์มไปยัง Processing.php
    form.submit();
});
</script>


<script>
// ฟังก์ชันดึงพิกัดแบบละเอียด (High Accuracy)
function getFineLocation() {
    const status = document.getElementById('camera-status');
    
    if (!navigator.geolocation) {
        status.innerHTML = "⚠️ เบราว์เซอร์ไม่รองรับ GPS";
        return;
    }

    const options = {
        enableHighAccuracy: true, // บังคับใช้ความแม่นยำสูง (GPS)
        timeout: 10000,           // รอพิกัดไม่เกิน 10 วินาที
        maximumAge: 0             // ไม่เอาพิกัดเก่าที่ค้างใน Cache
    };

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy; // ความแม่นยำ (เมตร)

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

            status.innerHTML = `● กล้องพร้อม | 📍 พิกัดแม่นยำ +/- ${accuracy.toFixed(0)} ม.`;
            status.style.color = "green";
            
            // เปิดปุ่มบันทึกเมื่อได้พิกัดแล้ว
            document.getElementById('capture-btn').disabled = false;
        },
        (error) => {
            let msg = "";
            switch(error.code) {
                case error.PERMISSION_DENIED: msg = "⚠️ โปรดอนุญาตสิทธิ์เข้าถึงพิกัด"; break;
                case error.POSITION_UNAVAILABLE: msg = "⚠️ ไม่สามารถระบุพิกัดได้"; break;
                case error.TIMEOUT: msg = "⚠️ การขอพิกัดหมดเวลา"; break;
            }
            status.innerHTML = msg;
            status.style.color = "red";
        }, 
        options
    );
}

// เรียกใช้ฟังก์ชันทันทีที่โหลดหน้า หรือเมื่อเปิดกล้อง
window.onload = getFineLocation;
</script>


<script>
function checkDevice() {
    const ua = navigator.userAgent;
    let device = "Unknown Device";

    if (/tablet|ipad|playbook|silk/i.test(ua)) {
        device = "Tablet";
    } else if (/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/i.test(ua)) {
        device = "Mobile";
    } else {
        device = "Desktop/PC";
    }

    // ดึงชื่อ Browser เพิ่มเติม (ตัวเลือกเสริม)
    let browser = "Unknown Browser";
    if (ua.indexOf("Chrome") > -1) browser = "Google Chrome";
    else if (ua.indexOf("Safari") > -1) browser = "Safari";
    else if (ua.indexOf("Firefox") > -1) browser = "Firefox";
    else if (ua.indexOf("MSIE") > -1 || !!document.documentMode) browser = "IE";

    document.getElementById('device_info').value = device + " (" + browser + ")";
}

// เรียกใช้พร้อมกับการดึงพิกัด
window.onload = function() {
    checkDevice();
    getFineLocation(); // ฟังก์ชัน GPS ที่ทำไว้ก่อนหน้า
};
</script>

         
</body>
</html>