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
                            <span class="mb-0" >
                                <h2 style="color: #123a0d;">เดือน กุมภาพันธ์ 2569</h2>
                            </span>



                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-lg btn-primary btn-lg-square" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            


                              

                               
                            <div class="row g-4 mt-4">
                                <div class="col-12">
                                    <div class="overflow-auto" style="scroll-behavior: smooth;" id="activityScroll">
                                        <div class="d-flex gap-4" style="min-width: min-content; padding: 10px;" id="activityCarousel">
                                           <?php 
                                                // หัวข้อวันที่

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

            <!-- Modal สำหรับเพิ่มกิจกรรม -->
            <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                            <h5 class="modal-title text-white" id="addActivityModalLabel"><i class="fa fa-plus-circle me-2"></i>เพิ่มข้อมูลกิจกรรมใหม่</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="Processing" method="POST" enctype="multipart/form-data">
                            <div class="modal-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">ชื่อกิจกรรม</label>
                                        <input type="text" name="Act_Title" class="form-control form-control-lg" placeholder="ระบุชื่อกิจกรรม" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">วันที่จัดกิจกรรม</label>
                                        <input type="date" name="Act_Date" class="form-control form-control-lg" required>
                                    </div>
                                     <div class="col-md-3">
                                        <label class="form-label fw-bold">เวลาที่จัดกิจกรรม</label>
                                        <input type="time" name="Act_Time" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">เวลาใช้เวลา</label>
                                        <select name="Act_Duration" class="form-select form-select-lg" required>
                                            <option value="" disabled selected>เลือกเวลาใช้เวลา</option>
                                            <option value="1">1 ชั่วโมง</option>
                                            <option value="2">2 ชั่วโมง</option>
                                            <option value="3">3 ชั่วโมง</option>
                                            <option value="4">4 ชั่วโมง</option>
                                            <option value="5">5 ชั่วโมง</option>
                                            <option value="6">6 ชั่วโมง</option>
                                            <option value="7">7 ชั่วโมง</option>
                                            <option value="8">8 ชั่วโมง</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">รายละเอียดกิจกรรม</label>
                                        <textarea name="Act_Detail" class="form-control" rows="6" placeholder="อธิบายรายละเอียดการดำเนินกิจกรรม..."></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold">กลุ่มเป้าหมาย</label>
                                        <input type="text" name="Act_TargetGroup" class="form-control form-control-lg" placeholder="ระบุกลุ่มเป้าหมาย เช่น นักเรียน, ชุมชน, บุคลากร..." required>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label fw-bold">จำนวนผู้เข้าร่วม</label>
                                        <input type="number" name="Act_Participants" class="form-control form-control-lg" min="2" placeholder="ระบุจำนวน" required>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label fw-bold">ระบุจำนวนเพศชาย</label>
                                        <input type="number" name="Act_Male" class="form-control form-control-lg" min="0" placeholder="เพศชาย" required>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label fw-bold">กำหนดช่วงอายุ</label>
                                        <select name="Act_AgeRange" class="form-select form-select-lg" required>
                                            <option value="" disabled selected>ช่วงอายุ</option>
                                            <option value="น้อยกว่า 6 ปี">น้อยกว่า 6 ปี</option>
                                            <option value="6-9 ปี">6-9 ปี</option>
                                            <option value="10-19 ปี">10-19 ปี</option>
                                            <option value="20-29 ปี">20-29 ปี</option>
                                            <option value="30-39 ปี">30-39 ปี</option>
                                            <option value="40-49 ปี">40-49 ปี</option>
                                            <option value="50-59 ปี">50-59 ปี</option>
                                            <option value="60 ปีขึ้นไป">60 ปีขึ้นไป</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label fw-bold">รูปแบบการจัดกิจกรรม</label>
                                         <select name="Act_Format" class="form-select form-select-lg" required>
                                            <option value="" disabled selected>เลือกรูปแบบ</option>
                                            <option value="Offline">Offline (จัดกิจกรรมเฉพาะภายในศูนย์)</option>
                                            <option value="Online">Online (จัดกิจกรรมผ่านระบบออนไลน์)</option>
                                            <option value="Online&Offline">Online & Offline (จัดกิจกรรมทั้งภายในศูนย์และผ่านระบบออนไลน์)</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <label class="form-label fw-bold">สถานที่การจัดกิจกรรม</label>
                                        <select name="Act_Location" class="form-select form-select-lg" required>
                                            <option value="" disabled selected>เลือกสถานที่จัดกิจกรรม</option>
                                            <option value="ภายในศูนย์ดิจิทัลชุมชน">ภายในศูนย์ดิจิทัลชุมชน</option>
                                            <option value="ภายในเขตของหน่วยงานหรือโรงเรียน">ภายในเขตของหน่วยงานหรือโรงเรียน</option>
                                            <option value="นอกสถานที่">นอกสถานที่</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-6">
                                        <label class="form-label fw-bold">รูปภาพกิจกรรมหลัก</label>
                                        <input type="file" name="Act_ImageA" class="form-control form-control-lg" accept="image/*" required>
                                        <small class="text-muted">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 5MB</small>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label fw-bold">รูปภาพกิจกรรมรอง</label>
                                        <input type="file" name="Act_ImageB" class="form-control form-control-lg" accept="image/*">
                                        <small class="text-muted">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 5MB</small>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label fw-bold">รูปภาพกิจกรรมที่ 3</label>
                                        <input type="file" name="Act_ImageC" class="form-control form-control-lg" accept="image/*" required>
                                        <small class="text-muted">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 5MB</small>
                                    </div>

                                   <div class="col-4">
                                        <label class="form-label fw-bold">รูปภาพกิจกรรมที่ 4</label>
                                        <input type="file" name="Act_ImageD" class="form-control form-control-lg" accept="image/*" required>
                                        <small class="text-muted">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 5MB</small>
                                    </div>

                                    <div class="col-4">
                                        <label class="form-label fw-bold">รูปภาพกิจกรรมที่ 5</label>
                                        <input type="file" name="Act_ImageE" class="form-control form-control-lg" accept="image/*">
                                        <small class="text-muted">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 5MB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" name="Save_Activity" class="btn btn-primary px-5">บันทึกข้อมูล</button>
                            </div>
                        </form>
                    </div>
                </div>
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