<?php
$PageActive = 'Activity';
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
                        <h1 class="mb-0" style="color: #123a0d;" >ข้อมูลกิจกรรม</h1><br>
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
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-lg btn-primary btn-lg-square" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
                                        <div class="modal-header" style="background-color: #123a0d; border-bottom: none;">
                                            <h5 class="modal-title" id="addActivityLabel" style="color: #fff;">เพิ่มข้อมูลกิจกรรม</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="activityDate" class="form-label" style="color: #123a0d;">วันที่</label>
                                                    <input type="date" class="form-control" id="activityDate">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="activityName" class="form-label" style="color: #123a0d;">ชื่อผู้ใช้บริการ</label>
                                                    <input type="text" class="form-control" id="activityName">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="activityGender" class="form-label" style="color: #123a0d;">เพศ</label>
                                                    <select class="form-control" id="activityGender">
                                                        <option>เลือก</option>
                                                        <option>ชาย</option>
                                                        <option>หญิง</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #dee2e6;">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="button" class="btn btn-primary" style="background-color: #123a0d; border-color: #123a0d;">บันทึก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                <h5 style="color: #123a0d;">ข้อมูลการให้บริการของศูนย์ MS-Siam Tower ในเดือนกุมภาพันธ์ 2569</h5>

                               
                            <div class="row g-4 mt-4">
                                <h5 style="color: #123a0d;">ภาพกิจกรรม</h5>
                                <div class="col-12">
                                    <div class="overflow-auto" style="scroll-behavior: smooth;" id="activityScroll">
                                        <div class="d-flex gap-3" style="min-width: min-content;" id="activityCarousel">
                                            <?php
                                            $images = [
                                                ['title' => 'กิจกรรม A', 'image' => 'img/activity1.jpg'],
                                                ['title' => 'กิจกรรม B', 'image' => 'img/activity2.jpg'],
                                                ['title' => 'กิจกรรม C', 'image' => 'img/activity3.jpg'],
                                                ['title' => 'กิจกรรม D', 'image' => 'img/activity4.jpg'],
                                                ['title' => 'กิจกรรม E', 'image' => 'img/activity5.jpg'],
                                            ];
                                            
                                            foreach ($images as $index => $image) {
                                                echo "
                                                <div class='activity-card' style='flex: 0 0 250px; transition: all 0.3s ease;' data-index='{$index}'>
                                                    <div class='card shadow-sm border-0 rounded' style='overflow: hidden; height: 100%; cursor: pointer;'>
                                                        <img src='{$image['image']}' class='card-img-top' style='height: 250px; object-fit: cover;' alt='{$image['title']}'>
                                                        <div class='card-body' style='background-color: #f8f9fa;'>
                                                            <h5 class='card-title' style='color: #123a0d;'>{$image['title']}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                ";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                            const carousel = document.getElementById('activityCarousel');
                            const scrollContainer = document.getElementById('activityScroll');
                            let isDown = false;
                            let startX;
                            let scrollLeft;

                            scrollContainer.addEventListener('mousedown', (e) => {
                                isDown = true;
                                startX = e.pageX - scrollContainer.offsetLeft;
                                scrollLeft = scrollContainer.scrollLeft;
                            });

                            scrollContainer.addEventListener('mouseleave', () => {
                                isDown = false;
                            });

                            scrollContainer.addEventListener('mouseup', () => {
                                isDown = false;
                            });

                            scrollContainer.addEventListener('mousemove', (e) => {
                                if (!isDown) return;
                                e.preventDefault();
                                const x = e.pageX - scrollContainer.offsetLeft;
                                const walk = (x - startX) * 1;
                                scrollContainer.scrollLeft = scrollLeft - walk;
                            });

                            carousel.addEventListener('mousemove', (e) => {
                                const cards = document.querySelectorAll('.activity-card');
                                const scrollCenter = scrollContainer.scrollLeft + scrollContainer.clientWidth / 2;
                                
                                cards.forEach(card => {
                                    const cardCenter = card.offsetLeft + card.offsetWidth / 2;
                                    const distance = Math.abs(cardCenter - scrollCenter);
                                    const maxDistance = scrollContainer.clientWidth;
                                    const scale = Math.max(0.8, 1 - (distance / maxDistance) * 0.2);
                                    
                                    card.style.transform = `scale(${scale})`;
                                    card.style.opacity = Math.max(0.6, 1 - (distance / maxDistance) * 0.4);
                                });
                            });

                            carousel.dispatchEvent(new MouseEvent('mousemove'));
                            scrollContainer.addEventListener('scroll', () => {
                                carousel.dispatchEvent(new MouseEvent('mousemove'));
                            });
                            </script>


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