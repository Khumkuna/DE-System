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

                            <form method="POST" action="">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                
                                    <select class="form-select form-select-sm" name="MonthSelect" style="width: 200px;">
                                        <option selected disabled>เลือกเดือน</option>
                                        <option value="01">มกราคม</option>
                                        <option value="02">กุมภาพันธ์</option>
                                        <option value="03">มีนาคม</option>
                                        <option value="04">เมษายน</option>
                                        <option value="05">พฤษภาคม</option>
                                        <option value="06">มิถุนายน</option>
                                        <option value="07">กรกฎาคม</option>
                                        <option value="08">สิงหาคม</option>
                                        <option value="09">กันยายน</option>
                                        <option value="10">ตุลาคม</option>
                                        <option value="11">พฤศจิกายน</option>
                                        <option value="12">ธันวาคม</option>
                                    </select>
                                    
                                    <select class="form-select form-select-sm" name="YearSelect" style="width: 200px;">
                                        <option selected disabled>เลือกปี</option>
                                        <option value="2026">2569</option>
                                        <option value="2027">2570</option>
                                        <option value="2028">2571</option>
                                    </select>
                                    
                                    <button type="submit" class="btn btn-primary btn-sm" name="Search">แสดงข้อมูล</button>
                                
                                </form>
                                </div>

                           
<?php 
                                            if(isset($_POST['Search']))
                                            {
                                                $SelectedMonth = $_POST['MonthSelect'];
                                                $SelectedYear = $_POST['YearSelect'];
                                                
                                                $ShowMonth = $SelectedYear.'-'.$SelectedMonth;
                                            }
                                            else
                                            {
                                                $SelectedMonth = date('m');
                                                $SelectedYear = date('Y');
                                                $ShowMonth = $SelectedYear.'-'.$SelectedMonth;
                                            }

                                            $MonthThai = array(
                                                '01' => 'มกราคม',
                                                '02' => 'กุมภาพันธ์',
                                                '03' => 'มีนาคม',
                                                '04' => 'เมษายน',
                                                '05' => 'พฤษภาคม',
                                                '06' => 'มิถุนายน',
                                                '07' => 'กรกฎาคม',
                                                '08' => 'สิงหาคม',
                                                '09' => 'กันยายน',
                                                '10' => 'ตุลาคม',
                                                '11' => 'พฤศจิกายน',
                                                '12' => 'ธันวาคม'
                                            );
                                            $MonthName = $MonthThai[$SelectedMonth];

                                            $YearThai = array(
                                                '2026' => '2569',
                                                '2027' => '2570',
                                                '2028' => '2571'
                                            );
                                            $YearName = $YearThai[$SelectedYear];
?>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="mb-0" style="color: #123a0d;">ข้อมูลการให้บริการในเดือน <?php echo $MonthName . ' ' . $YearName; ?></h5>
                                    <form method="POST" action="">
                                        <input type="hidden" name="MonthSelect" value="<?php echo $SelectedMonth; ?>">
                                        <input type="hidden" name="YearSelect" value="<?php echo $SelectedYear; ?>">
                                        <button type="submit" class="btn btn-success btn-sm shadow-sm" name="PrintPDF">
                                            <i class="fa fa-print me-1"></i> พิมพ์รายงาน (PDF)
                                        </button>
                                    </form>
                                   
                                </div>

                                <table class="table table-bordered" width="100%" style="color: #123a0d;" >
                                        <thead>
                                            <tr align="center">
                                                <th>ลำดับ</th>
                                                <th>วันที่เข้าใช้บริการ</th>
                                                <th>ชื่อผู้เข้าใช้บริการ</th>
                                                <th>เพศ</th>
                                                <th>การใช้บริการ</th>
                                                <th>เวลาเข้าใช้บริการ</th>
                                                <th>เวลาออกเลิกใช้บริการ</th>
                                                <th>ระยะเวลาการใช้บริการ</th>
                                                <th>เครื่องมือ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $limit = 20; // จำนวนแถวต่อหน้า
                                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                            $start = ($page - 1) * $limit;

                                            // หาจำนวนแถวทั้งหมดเพื่อคำนวณหน้า
                                            $totalResult = $conn->query("SELECT COUNT(*) as total FROM Survey_tb WHERE Site_ID = '$Login_Site' AND Sur_MonthYear='$ShowMonth' ");
                                            $totalRows = $totalResult->fetch_assoc()['total'];
                                            $totalPages = ceil($totalRows / $limit);

                                            $GetServiceData = $conn->query("SELECT * FROM Survey_tb WHERE Site_ID = '$Login_Site' AND Sur_MonthYear='$ShowMonth' ORDER BY Sur_ID DESC LIMIT $start, $limit");
                                            
                                            $maxRowsDisplay = 15; // แถวขั้นต่ำที่ต้องการโชว์ในตาราง
                                            $counter = $start + 1;
                                            $rowCount = 0;

                                            if ($GetServiceData->num_rows > 0) {
                                                while ($row = $GetServiceData->fetch_assoc()) { 
                                                    $rowCount++;
                                                    $TimeOut = $row['Sur_TimeOut'];
                                                    if ($TimeOut == '-') {
                                                        $TimeOut = date('H:i:s');
                                                    }   
                                                    
                                                    ?>
                                                    <tr align="center">
                                                        <td><?php echo $counter++; ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['Sur_Date'])); ?></td>
                                                        <td><?php echo $row['Sur_Name']; ?></td>
                                                        <td><?php echo $row['Sur_Gender']; ?></td>
                                                        <td><?php echo $row['Sur_Subject']; ?></td>
                                                        <td><?php echo date('H:i:s', strtotime($row['Sur_TimeIn'])); ?></td>
                                                        <td><?php echo date('H:i:s', strtotime($TimeOut)); ?></td>
                                                        <td>
                                                            <?php
                                                            $timeIn = strtotime($row['Sur_TimeIn']);
                                                            $timeOut = strtotime($TimeOut);
                                                            $duration = $timeOut - $timeIn;
                                                            echo gmdate('H:i:s', $duration);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="ServiceDetail.php?Sur_ID=<?php echo $row['Sur_ID']; ?>" class="btn btn-primary btn-sm">ดูรายละเอียด</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                
                                                // เพิ่มแถวว่างเพื่อให้ตารางดูเต็มและสวยงาม
                                                $remainingRows = $maxRowsDisplay - $rowCount;
                                                for ($i = 0; $i < $remainingRows; $i++) {
                                                    echo "<tr style='height: 45px;'>
                                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                          </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='9' align='center' style='color: #123a0d; height: 100px; vertical-align: middle;'>ไม่พบข้อมูลการใช้บริการในเดือนนี้</td></tr>";
                                                for ($i = 0; $i < $maxRowsDisplay; $i++) {
                                                    echo "<tr style='height: 45px;'>
                                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                          </tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <!-- ส่วนควบคุมการแบ่งหน้า -->
                                <nav aria-label="Page navigation" class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">ย้อนกลับ</a>
                                        </li>
                                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">ถัดไป</a>
                                        </li>
                                    </ul>
                                </nav>


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