<?php
$PageActive = 'ActivityAll';
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

                        <div class="mb-3 d-flex gap-2 align-items-center justify-content-center">
                            <label for="monthFilter" class="form-label mb-0" style="color: #123a0d;">เลือกเดือน:</label>
                            <input type="month" class="form-control" id="monthFilter" style="width: 200px;">
                            <button class="btn btn-primary" style="background-color: #123a0d; border-color: #123a0d;" onclick="filterByMonth()">ค้นหา</button>
                            <button class="btn btn-secondary" onclick="resetFilter()">รีเซ็ต</button>
                        </div>

                        <script>
                        function filterByMonth() {
                            const monthInput = document.getElementById('monthFilter').value;
                            if (!monthInput) {
                                alert('กรุณาเลือกเดือน');
                                return;
                            }
                            
                            const cards = document.querySelectorAll('.activity-card');
                            cards.forEach(card => {
                                const dateText = card.querySelector('[style*="position: absolute"]')?.parentElement.textContent || '';
                                if (dateText.includes(monthInput.split('-')[1])) {
                                    card.style.display = 'flex';
                                } else {
                                    card.style.display = 'none';
                                }
                            });
                        }

                        function resetFilter() {
                            document.getElementById('monthFilter').value = '';
                            const cards = document.querySelectorAll('.activity-card');
                            cards.forEach(card => {
                                card.style.display = 'flex';
                            });
                        }
                        </script>

                            <span class="mb-0" >
                                <H6>ค้นหาเดือน: </H6>

                            <div class="row g-4 mt-4">
                                <div class="col-12">
                                    <div class="overflow-auto" style="scroll-behavior: smooth;" id="activityScroll">
                                        <div class="d-flex gap-4" style="min-width: min-content; padding: 10px;" id="activityCarousel">
                                            <?php
                                            $images = [
                                                ['title' => 'กิจกรรม A', 'image' => 'img/Uploaded/Act-1.jpg', 'date' => '15 ก.พ. 2569'],
                                                ['title' => 'กิจกรรม B', 'image' => 'img/Uploaded/Act-2.jpg', 'date' => '16 ก.พ. 2569'],
                                                ['title' => 'กิจกรรม C', 'image' => 'img/Uploaded/Act-3.jpg', 'date' => '17 ก.พ. 2569'],
                                                ['title' => 'กิจกรรม D', 'image' => 'img/Uploaded/Act-4.jpg', 'date' => '18 ก.พ. 2569'],
                                                ['title' => 'กิจกรรม E', 'image' => 'img/Uploaded/Act-5.jpg', 'date' => '19 ก.พ. 2569'],
                                                 ['title' => 'กิจกรรม F', 'image' => 'img/Uploaded/Act-6.jpg', 'date' => '20 ก.พ. 2569'],
                                            ];
                                            
                                            foreach ($images as $index => $image) {
                                                echo "
                                                <div class='activity-card' style='flex: 0 0 280px; transition: all 0.3s ease;' data-index='{$index}'>
                                                    <div class='card shadow-lg border-0 rounded-3' style='overflow: hidden; height: 100%; cursor: pointer; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);'>
                                                        <div style='position: relative; overflow: hidden;'>
                                                            <img src='{$image['image']}' class='card-img-top' style='height: 280px; object-fit: cover; transition: transform 0.3s ease;' alt='{$image['title']}'>
                                                            <div style='position: absolute; top: 10px; right: 10px; background-color: #123a0d; color: white; padding: 8px 12px; border-radius: 20px; font-size: 12px;'>
                                                                <i class='fa fa-calendar'></i> {$image['date']}
                                                            </div>
                                                        </div>
                                                        <div class='card-body' style='padding: 20px; background-color: #ffffff;'>
                                                            <h5 class='card-title' style='color: #123a0d; font-weight: 600; margin-bottom: 10px;'>{$image['title']}</h5>
                                                            <p style='color: #666; font-size: 14px; margin: 0;'>MS-Siam Tower</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                ";
                                            }
                                            ?>
                                            <div class='activity-card' style='flex: 0 0 280px; transition: all 0.3s ease;'>
                                                <div class='card shadow-lg border-0 rounded-3 d-flex align-items-center justify-content-center' style='overflow: hidden; height: 100%; cursor: pointer; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);'>
                                                    <div class='text-center' style='padding: 40px;'>
                                                        <i class='fa fa-ellipsis-h' style='font-size: 48px; color: #123a0d; margin-bottom: 15px; display: block;'></i>
                                                        <button class='btn btn-primary' style='background-color: #123a0d; border-color: #123a0d;'>ดูเพิ่มเติม</button>
                                                    </div>
                                                </div>
                                            </div>
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