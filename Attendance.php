<?php
$PageActive = 'Attendance';




?>

<!DOCTYPE html>
<html lang="en">

<?php include 'Tools/Header.php';   
        $CheckInTimeToday = $_SESSION['CheckInTimeToday']; 

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
                        <h1 class="mb-0" style="color: #123a0d;" >การบันทึกเวลา เข้างาน - ออกงาน</h1><br>
                        <h6 class="mb-0" style="color: #123a0d;" >ระบบบันทึกเวลาเข้า-ออกงานด้วยใบหน้าและระบบตรวจจับพิกัด</h6><br><br>
                        <h2 id="realtime-clock" style="color: #123a0d;" ><?php echo date("d-m-Y H:i:s"); ?></h2></span> 
                        </div>
                     </div>   
                </div>
                <br>



                 <div class="row g-4" >
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" >
                            <video id="camera-feed" width="60%" height="auto" autoplay style="border-radius: 8px;"></video>

                            <select class="form-select" id="site-select" name="Login_Site" >
                                <option value="Si001" <?php if($Login_Site == "Si001") echo "selected"; ?>>สำนักงานใหญ่</option>
                                <option value="Si002" <?php if($Login_Site == "Si002") echo "selected"; ?>>โรงงาน 1</option>
                                <option value="Si003" <?php if($Login_Site == "Si003") echo "selected"; ?>>โรงงาน 2</option>
                            </select>
                        </div>
                        
                     </div>   

                     <div class="col-sm-12 col-xl-6" >
                        <form id="attendance-form" method="POST" action="Processing">
                            <input  name="Login_Site" hidden value="<?php echo $Login_Site; ?>">
                            <input  name="Login_Acc" hidden value="<?php echo $Login_Acc; ?>">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" >
                                <?php if(!isset($_SESSION['CheckInTimeToday']) || $_SESSION['CheckInTimeToday'] == "") { ?>
                                        <button id="capture-btn" class="btn btn-primary btn-lg rounded-circle" Type="submit" name="CheckIn" style="width: 240px; height: 240px; font-size: 16px;">บันทึกเข้างาน</button>
                                        <canvas id="capture-canvas" style="display:none;"></canvas>
                                <?php } else { ?>
                                        <button id="capture-btn" class="btn btn-danger btn-lg rounded-circle" Type="submit" name="CheckOut" style="width: 240px; height: 240px; font-size: 16px;">บันทึกออกงาน</button>
                                        <canvas id="capture-canvas" style="display:none;"></canvas>
                                <?php } ?>


                            </div>
                        </form>
                     </div>   
                </div>
                <br>

                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12" align="center">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" style="color: #1ff308;" >
                        <span class="mb-0" >
                            <br><br><br><br>
                                <?php if(isset($_SESSION['CheckInTimeToday'])) {
                                    echo "<h2 class='mb-0' style='color: #123a0d;' >คุณได้บันทึกเข้างานแล้วในวันนี้ เวลา: " . date("H:i", strtotime($_SESSION['CheckInTimeToday'])) . " น.</h2>";
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