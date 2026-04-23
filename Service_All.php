<?php
$PageActive = 'ServiceAll';
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'Tools/Header.php'; ?>

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
                        <h1 class="mb-0" style="color: #123a0d;" >ข้อมูลการให้บริการ</h1><br>
                        <h3 class="mb-0" style="color: #123a0d;" >ศูนย์: MS-Siam Tower</h3>
                        
                        </div>
                     </div>   
                </div>
                <br>
            </div>

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12" align="center">
                        <div class="bg-light rounded  justify-content-center p-4" style="color: #1ff308;" >
                            <span class="mb-0" >


                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <select class="form-select form-select-sm" style="width: 200px;">
                                        <option selected disabled>เลือกเดือน</option>
                                        <option value="1">มกราคม</option>
                                        <option value="2">กุมภาพันธ์</option>
                                        <option value="3">มีนาคม</option>
                                        <option value="4">เมษายน</option>
                                        <option value="5">พฤษภาคม</option>
                                        <option value="6">มิถุนายน</option>
                                        <option value="7">กรกฎาคม</option>
                                        <option value="8">สิงหาคม</option>
                                        <option value="9">กันยายน</option>
                                        <option value="10">ตุลาคม</option>
                                        <option value="11">พฤศจิกายน</option>
                                        <option value="12">ธันวาคม</option>
                                    </select>
                                    
                                    <select class="form-select form-select-sm" style="width: 200px;">
                                        <option selected disabled>เลือกปี</option>
                                        <option value="2569">2569</option>
                                        <option value="2570">2570</option>
                                        <option value="2571">2571</option>
                                    </select>
                                    
                                    <button class="btn btn-primary btn-sm">แสดงข้อมูล</button>
                                    <button class="btn btn-success btn-sm ms-auto">พิมพ์รายงาน</button>
                                </div>


                                <h5 style="color: #123a0d;">ข้อมูลการให้บริการของศูนย์ MS-Siam Tower ในเดือนกุมภาพันธ์ 2569</h5>

                                <table class="table table-bordered" width="100%" style="color: #123a0d;" >
                                        <thead>
                                            <tr align="center">
                                                <th>วันที่เข้าใช้บริการ</th>
                                                <th>ชื่อผู้เข้าใช้บริการ</th>
                                                <th>เพศ</th>
                                                <th>การใช้บริการ</th>
                                                <th>เวลาเข้าใช้บริการ</th>
                                                <th>เวลาออกเลิกใช้บริการ</th>
                                                <th>ระยะเวลาการใช้บริการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $startDate = new DateTime('2026-02-01');
                                            $endDate = new DateTime('2026-02-28');

                                            while ($startDate <= $endDate) {
                                                $date = $startDate->format('d/m/Y');
                                                $name = 'ชื่อผู้ใช้บริการ';
                                                $gender = 'ชาย';
                                                $service = 'บริการ';
                                                $startTime = '08:00 น.';
                                                $endTime = '17:00 น.';
                                                $duration = '9 ชั่วโมง';
                                                
                                                echo "<tr align='center'>
                                                    <td>$date</td>
                                                    <td>$name</td>
                                                    <td>$gender</td>
                                                    <td>$service</td>
                                                    <td>$startTime</td>
                                                    <td>$endTime</td>
                                                    <td>$duration</td>
                                                </tr>";
                                                $startDate->modify('+1 day');
                                            }
                                            ?>
                                            <!-- เพิ่มข้อมูลการปฏิบัติงานอื่นๆ ที่นี่ -->
                                        </tbody>
                                    </table>
                            </span>
                        </div> 
                     </div>   
                </div>
                <br>
            </div>
            
            <?php
            include 'Tools/Footer.php'; 
            ?>
       

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

        // Initialize Camera
        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('capture-canvas');
        const captureBtn = document.getElementById('capture-btn');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Camera error:', error);
                alert('ไม่สามารถเข้าถึงกระบวนการบันทึกเวลา: ' + error.message);
            });

        captureBtn.addEventListener('click', () => {
            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);
            console.log('Photo captured');
        });
    </script>
</body>

</html>