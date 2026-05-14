<?php
$PageActive = 'AttendanceAll';


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
                        <h1 class="mb-0" style="color: #123a0d;" >ข้อมูลการปฏิบัติงานทั้งหมด</h1><br>
                        <h3 class="mb-0" style="color: #123a0d;" >ชื่อ: <?php echo $Login_Name ;?></h3><br>
                        <h3 class="mb-0" style="color: #123a0d;" >เจ้าหน้าที่ประจำศูนย์: MS-Siam Tower</h3>
                        
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
                                    <form method="POST" action="Attendance-All" class="d-flex align-items-center gap-2 mb-3">
                                        <select class="form-select form-select-sm" name="MonthSearch" style="width: 200px;" >
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
                                        
                                        <select class="form-select form-select-sm" name="YearSearch" style="width: 200px;" >
                                            <option selected disabled>เลือกปี</option>
                                            <option value="2026">2569</option>
                                            <option value="2027">2570</option>
                                            <option value="2028">2571</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" type="submit" name="Search">แสดงข้อมูล</button>
                                    </form>

                                    




                                    <button class="btn btn-success btn-sm ms-auto">พิมพ์รายงาน</button>


                                </div>

                                <?php 
                                        if(isset($_POST['Search']))
                                        {
                                            $MonthSearch = $_POST['MonthSearch'];
                                            $YearSearch = $_POST['YearSearch'];
                                            $MonthShow = $YearSearch.'-'.$MonthSearch;
                                            if($MonthSearch == "" || $YearSearch = "")
                                                {
                                                    $MonthShow = date('Y-m');
                                                }
                                        }
                                        else
                                        {
                                            $MonthShow = date('Y-m');
                                        }

                                    
                                    $ShowDatetime = "Select * from `de_system_db`.`attendance_tb` where  ATT_MonthYear = '$MonthShow' and Site_ID = '$Login_Site'";
                                    $ResultShowDatetime = $conn->query($ShowDatetime);
                                    $GetMonth = date("m",strtotime($MonthShow));
                                    $GetYears = date("Y",strtotime($MonthShow)) + 543;


                                    $ThaiYears = array(
                                        '01' => 'มกราคม','02' => 'กุมภาพันธ์','03' => 'มีนาคม','04' => 'เมษายน','05' => 'พฤษภาคม','06' => 'มิถุนายน',
                                        '07' => 'กรกฎาคม','08' => 'สิงหาคม','09' => 'กันยายน','10' => 'ตุลาคม','11' => 'พฤศจิกายน','12' => 'ธันวาคม'
                                    );
                                    $MonthName = $ThaiYears[$GetMonth];
                                ?>


                                <h5 style="color: #123a0d;">ข้อมูลการปฏิบัติงานของเจ้าหน้าที่ประจำศูนย์ MS-Siam Tower ในเดือน  <?php echo $MonthName.' '.$GetYears; ?></h5>

                                <table class="table table-bordered" width="100%" style="color: #123a0d;" >
                                        <thead>
                                            <tr align="center">
                                                <th>วันที่</th>
                                                <th>วัน</th>
                                                <th>เวลาที่เข้างาน</th>
                                                <th>เวลาที่ออกงาน</th>
                                                <th>ข้อมูการปฏิบัติงาน</th>
                                                <th>หมายเหตุ</th>
                                                <th>ภาพถ่าย</th>
                                                <th>พิกัดการลงเวลา</th>
                                                <th>อุปกรณ์</th>
                                                <th>งวดงาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                               
                                                if($ResultShowDatetime->num_rows > 0) {
                                                    while($DataShowDatetime = $ResultShowDatetime->fetch_assoc()) {
                                                        $ThaiDays = array(
                                                            'Monday' => 'จันทร์','Tuesday' => 'อังคาร', 'Wednesday' => 'พุธ','Thursday' => 'พฤหัสบดี','Friday' => 'ศุกร์','Saturday' => 'เสาร์', 'Sunday' => 'อาทิตย์'
                                                        );
                                                        
                                                        $DayName = $ThaiDays[date("l", strtotime($DataShowDatetime['ATT_Date']))];
                                                        $isHoliday = ($DataShowDatetime['ATT_Status'] == 'วันหยุด') ? 'background-color: #ffcccc;' : '';
                                                        $dayOfWeek = date("l", strtotime($DataShowDatetime['ATT_Date']));
                                                        $isWeekend = ($dayOfWeek == 'Saturday' || $dayOfWeek == 'Sunday') ? 'color: red;' : '';
                                                        $Status = $DataShowDatetime['ATT_Status']; 
                                                            if($Status == 'Late') {$Status = "<span style='color: red;'>สาย</span>";} 
                                                            else if ($Status == 'On Time') {$Status = "<span style='color: green;'>ตรงเวลา</span>";} 
                                                            else if ($Status == 'วันหยุด') {$Status = "<span style='color: blue;'>วันหยุด</span>";}
                                                            else{$Status = "<span style='color: #123a0d;'>-</span>";}
                                                        $TimeIn = $DataShowDatetime['ATT_TimeIn'];
                                                        
                                                        echo "<tr align='center' style='" . $isHoliday . $isWeekend . "'>";
                                                        echo "<td>". date("d", strtotime($DataShowDatetime['ATT_Date'])).' ' . $MonthName . ' ' . $GetYears . "</td>";
                                                        echo "<td>" . $DayName . "</td>";
                                                        echo "<td>" . $DataShowDatetime['ATT_TimeIn']. "</td>";
                                                        echo "<td>" . $DataShowDatetime['ATT_TimeOut']. "</td>";
                                                        echo "<td>" . $Status . "</td>";
                                                        echo "<td>" . $DataShowDatetime['ATT_Remark'] . "</td>";
                                                        if ($DataShowDatetime['ATT_Image'] != null && $DataShowDatetime['ATT_Image'] != "") {
                                                        echo "<td><img src='attendance_pics/attendance_images/" . $DataShowDatetime['ATT_Image'] . "' alt='ภาพถ่าย' width='25'></td>";
                                                        echo "<td>" . $DataShowDatetime['ATT_Latitude'] . "," . $DataShowDatetime['ATT_Longitude'] . "</td>";
                                                        echo "<td>" . $DataShowDatetime['ATT_Device'] . "</td>";
                                                        } else {
                                                            echo "<td>-</td>";
                                                            echo "<td>-</td>";
                                                            echo "<td>-</td>";
                                                        }
                                                        echo "<td>" . $DataShowDatetime['ATT_Work'] . "</td>";
                                                        
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10' align='center' style='color: #123a0d;'>ไม่พบข้อมูล</td></tr>";
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
</body>

</html>