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
                        </div>
                     </div>   

                     <div class="col-sm-12 col-xl-6" >
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" >
                            <button id="capture-btn" class="btn btn-primary btn-lg rounded-circle" style="width: 240px; height: 240px; font-size: 16px;">บันทึกเข้างาน</button>
                            <canvas id="capture-canvas" style="display:none;"></canvas>

                        </div>
                     </div>   

                      
                </div>
            </div>
            <!-- Button End -->

                <?php #include 'Tools/Footer.php'; ?>

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