<?php 
$PageActive= 'Home';
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



              <?php include 'Action/Count_Home.php'; ?>
              <?php include 'Action/CheckOut.php'; ?>
              
              

            <div class="container-fluid pt-4 px-4" id="top">
                <h1>ข้อมูลการให้บริการ</h1>
                <hr>
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-users fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการวันนี้</p>
                                <h6 class="mb-0 counter-value" data-target="<?php echo $TotalServiceToday; ?>">0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการเดือนนี้</p>
                                <h6 class="mb-0 counter-value" data-target="<?php echo $TotalMonthlyService; ?>">0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-6">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการทั้งหมด</p>
                                <h6 class="mb-0 counter-value" data-target="<?php echo $TotalService; ?>">0</h6>
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
                            </div>
                            <div style="height: 350px;">
                                <canvas id="service-monthly-line"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">สถิติการใช้บริการแยกตามประเภท (ย้อนหลัง 5 เดือน)</h6>
                            </div>
                            <div style="height: 350px;">
                                <canvas id="service-subject-bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            

            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">ข้อมูลการเข้าใช้บริการ</h6>
                            </div>
                            <div class="d-flex align-items-center  py-2">
                                <div class="w-100 ms-3">
                                    <?php 
                                    $GetDateNow = date('Y-m-d');
                                    $Getname = "SELECT * FROM survey_tb WHERE Site_ID = '$Login_Site' AND Sur_Date = '$GetDateNow' ORDER BY Sur_TimeIn DESC LIMIT 5";
                                    $NameResult = $conn->query($Getname);
                                    while($row = $NameResult->fetch_assoc()) {
                                        $Sur_Name = $row['Sur_Name'];
                                        $Sur_Subject = $row['Sur_Subject'];
                                        $Sur_TimeIn = $row['Sur_TimeIn'];
                                        $Sur_TimeOut = $row['Sur_TimeOut'];

                                        if ($Sur_TimeOut == '-') {
                                            $Sur_TimeOut = date('H:i:s');
                                        }

                                        $TimeIn = new DateTime($Sur_TimeIn);
                                        $TimeOut = new DateTime($Sur_TimeOut);
                                        $Duration = $TimeOut->getTimestamp() - $TimeIn->getTimestamp();

                                        $Now = new DateTime();
                                        $Diff = $Now->getTimestamp() - $TimeIn->getTimestamp();
                                        
                                        if ($Diff < 60) {
                                            $TimeDisplay = "เมื่อสักครู่";
                                        } else {
                                            $Hours = floor($Diff / 3600);
                                            $Minutes = floor(($Diff % 3600) / 60);
                                            
                                            $TimeDisplay = ($Hours > 0) ? $Hours . " ชั่วโมง " : "";
                                            $TimeDisplay .= $Minutes . " นาทีที่ผ่านมา";
                                        }

                                        echo "<div class='d-flex w-100 align-items-center justify-content-between'>
                                                <h6 class='mb-0'>$Sur_Subject</h6>
                                                <small>$TimeDisplay</small>
                                            </div>
                                            <span>โดย $Sur_Name | เวลาเข้า: $Sur_TimeIn</span>
                                            <br><hr>
                                            ";
                                            
                                    }
                                    ?>
                                    
                                </div>
                             </div>   
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">ข้อมูลกิจกรรม</h6>
                            </div>
                            <div class="d-flex align-items-center  py-2">
                                <div class="w-100 ms-3">
                                   
                                </div>
                             </div>   

                            
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">สถานะการส่งรายงาน</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <span>1</span>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>รายงานการปฏิบัติงาน</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <span>2</span>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>รายงานการให้บริการประชาชน + กิจกรรม</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <span>3</span>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span><del>รายงานการตรวจสอบอุปกรณ์ (Checklist)</del></span>
                                        <button class="btn btn-sm text-primary"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <span>4</span>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>รายงานการทดสอบอินเตอร์เน็ต Speedtest</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-2">
                                <span>5</span>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>ใบเสร็จรับเงินค่าสนับสนุนค่าไฟฟ้า</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


           <?php
            include 'Tools/Footer.php'; 
            ?>
        </div>
        <!-- Content End -->


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
        $(document).ready(function() {
            $('.counter-value').each(function() {
                var $this = $(this);
                var countTo = $this.attr('data-target');
                $({ countNum: $this.text() }).animate({
                    countNum: countTo
                },
                {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum.toLocaleString());
                    }
                });
            });
        });

        // Service Monthly Line Chart
        var ctx1 = $("#service-monthly-line").get(0).getContext("2d");
        var myChart1 = new Chart(ctx1, {
            type: "line",
            data: {
                labels: [
                "<?php echo date('M-Y', strtotime('-5 month')); ?>",
                "<?php echo date('M-Y', strtotime('-4 month')); ?>",
                "<?php echo date('M-Y', strtotime('-3 month')); ?>",
                "<?php echo date('M-Y', strtotime('-2 month')); ?>", 
                "<?php echo date('M-Y', strtotime('-1 month')); ?>", 
                "<?php echo date('M-Y'); ?>"],
                datasets: [{
                    label: "ผู้เข้าใช้บริการ",
                    data: [
                        <?php echo $TotalLastMonthService_5; ?>, 
                        <?php echo $TotalLastMonthService_4; ?>, 
                        <?php echo $TotalLastMonthService_3; ?>, 
                        <?php echo $TotalLastMonthService_2; ?>, 
                        <?php echo $TotalLastMonthService_1; ?>, 
                        <?php echo $TotalMonthlyService; ?>],
                    backgroundColor: "rgba(0, 156, 255, .5)",
                    fill: true,
                    borderColor: "#009CFF",
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Service Subject Bar Chart
        <?php
        $Months = [];
        for ($i = 4; $i >= 0; $i--) {
            $Months[] = date('Y-m', strtotime("-$i month"));
        }
        
        $Subjects = ['อบรม', 'ประชุม/ขอใช้พื้นที่', 'สืบค้นข้อมูล', 'พิมพ์เอกสาร', 'การเรียนการสอน', 'สตูดิโอ', 'นันทนาการ'];
        $Dataset = [];
        
        $Colors = [
            "rgba(0, 156, 255, .8)", "rgba(40, 167, 69, .8)", "rgba(255, 193, 7, .8)", 
            "rgba(220, 53, 69, .8)", "rgba(108, 117, 125, .8)", "rgba(23, 162, 184, .8)", "rgba(102, 16, 242, .8)"
        ];

        foreach($Subjects as $index => $sub) {
            $dataPoints = [];
            foreach($Months as $m) {
                $res = $conn->query("SELECT COUNT(*) as total FROM Survey_tb WHERE Site_ID = '$Login_Site' AND Sur_Subject LIKE '%$sub%' AND Sur_MonthYear = '$m'")->fetch_assoc();
                $dataPoints[] = $res['total'];
            }
            $Dataset[] = [
                'label' => $sub,
                'data' => $dataPoints,
                'backgroundColor' => $Colors[$index]
            ];
        }
        
        $MonthLabels = [];
        foreach($Months as $m) { $MonthLabels[] = date('M-Y', strtotime($m)); }
        ?>

        var ctx2 = $("#service-subject-bar").get(0).getContext("2d");
        var myChart2 = new Chart(ctx2, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($MonthLabels); ?>,
                datasets: <?php echo json_encode($Dataset); ?>
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    x: {
                        stacked: false
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>