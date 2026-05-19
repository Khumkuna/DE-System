<?php
$PageActive = 'Activity';
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'Tools/Header.php'; ?>

<style>
    /* เอฟเฟกต์การยื่นเมาส์เหนือการ์ดกิจกรรม */
    .activity-card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.155) !important;
        transition: all 0.3s ease;
    }
    /* ควบคุมไม่ให้หัวข้อกิจกรรมที่ยาวเกินไปดันสัดส่วนการ์ดเสีย */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

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
                        <div class="bg-light rounded justify-content-center p-4" style="color: #1ff308;" >
                            <span class="mb-0" >
                                <h2 style="color: #123a0d;">เดือน กุมภาพันธ์ 2569</h2>
                            </span>

                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-lg btn-primary btn-lg-square" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <?php 
                                $sql_Activity = "SELECT * FROM survey_tb WHERE Site_ID = '$Login_Site' AND Sur_Type = 'Activity' ORDER BY Sur_Date DESC";
                                $result_Activity = mysqli_query($conn, $sql_Activity);

                                // เริ่มต้น Row สำหรับแสดงสไตล์ Grid การ์ดกิจกรรม
                                echo "<div class='row g-4 mt-2 text-start'>";

                                while ($row_Activity = mysqli_fetch_array($result_Activity)) {
                                    $Act_ID = $row_Activity['Sur_ID'];
                                    $Act_Title = $row_Activity['Sur_Name'];
                                    $Act_Date = date('d-m-Y', strtotime($row_Activity['Sur_Date']));
                                    $Act_Time = date('H:i', strtotime($row_Activity['Sur_TimeIn']));
                                    $Act_Detail = !empty($row_Activity['Sur_Remark']) ? $row_Activity['Sur_Remark'] : 'ไม่มีรายละเอียดเพิ่มเติม';
                                    $Act_TargetGroup = $row_Activity['Sur_Target'];
                                    $Act_Format = $row_Activity['Sur_TypeACT'];
                                    $Act_Location = $row_Activity['Sur_Location'];
                                    $Act_Participants = $row_Activity['Sur_QTY'];
                                    
                                    $Act_ImageA = $row_Activity['Sur_ImageA'];
                                    $Act_ImageB = $row_Activity['Sur_ImageB'];
                                    $Act_ImageC = $row_Activity['Sur_ImageC'];
                                    $Act_ImageD = $row_Activity['Sur_ImageD'];
                                    $Act_ImageE = $row_Activity['Sur_ImageE'];
                                    
                                    // กรองเฉพาะรูปที่มีชื่อไฟล์อยู่จริงในฐานข้อมูลและมีไฟล์อยู่จริงบนเซิร์ฟเวอร์
                                    $imageNames = array_filter([$Act_ImageA, $Act_ImageB, $Act_ImageC, $Act_ImageD, $Act_ImageE]);
                                    $validImages = [];

                                    foreach ($imageNames as $imgName) {
                                        $imgPath = './Upload/Activity_Images/' . $imgName;
                                        if (!empty($imgName) && file_exists($imgPath)) {
                                            $validImages[] = $imgPath;
                                        }
                                    }

                                    // กำหนดภาพหน้าปกการ์ดหลัก
                                    $coverImg = !empty($validImages) ? $validImages[0] : 'https://placehold.co/600x400?text=No+Image';
                            ?>
                                    <!-- การ์ดกิจกรรมแต่ละรายการ (Responsive Grid) -->
                                    <div class='col-sm-12 col-md-6 col-xl-4'>
                                        <div class='card h-100 shadow-sm border-0 rounded-3 position-relative d-flex flex-column activity-card-item' style='overflow: hidden;'>
                                            <span class="badge bg-success position-absolute top-0 end-0 m-3 fs-6"><?php echo $Act_Format; ?></span>
                                            <img src='<?php echo $coverImg; ?>' class='card-img-top' alt='Activity Cover' style='height: 220px; object-fit: cover;'>
                                            
                                            <div class='card-body d-flex flex-column bg-white p-4'>
                                                <h5 class='card-title text-truncate-2' style='color: #123a0d; font-weight: bold; min-height: 48px;'><?php echo $Act_Title; ?></h5>
                                                
                                                <div class='card-text my-3 text-muted' style='font-size: 14px;'>
                                                    <div class="mb-1"><i class="fa fa-calendar-alt me-2 text-success"></i> <strong>วันที่:</strong> <?php echo $Act_Date . " (" . $Act_Time . " น.)"; ?></div>
                                                    <div class="mb-1 text-truncate"><i class="fa fa-map-marker-alt me-2 text-danger"></i> <strong>สถานที่:</strong> <?php echo $Act_Location; ?></div>
                                                    <div class="mb-1"><i class="fa fa-users me-2 text-primary"></i> <strong>ผู้เข้าร่วม:</strong> <?php echo $Act_Participants; ?> คน</div>
                                                </div>
                                                
                                                <!-- ปุ่มสำหรับคลิกเพื่อเรียกดูรูปภาพสไลด์และรายละเอียดแบบจัดเต็ม -->
                                                <button type='button' class='btn btn-outline-success w-100 mt-auto rounded-pill fw-bold' data-bs-toggle='modal' data-bs-target='#viewActivityModal_<?php echo $Act_ID; ?>'>
                                                    <i class="fa fa-eye me-2"></i>ดูรายละเอียดภาพและข้อมูล
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- หน้าต่างป๊อปอัป (Modal) แสดงรายละเอียดเจาะลึกประจำกิจกรรมนั้น ๆ -->
                                    <div class="modal fade" id="viewActivityModal_<?php echo $Act_ID; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                                <div class="modal-header bg-dark text-white p-3">
                                                    <h5 class="modal-title text-white"><i class="fa fa-info-circle me-2 text-success"></i>รายละเอียดข้อมูลกิจกรรม</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0 text-start">
                                                    <div class="row g-0">
                                                        <!-- ฝั่งซ้าย: แสดงสไลด์รูปภาพทั้งหมด (Bootstrap Carousel) -->
                                                        <div class="col-lg-7 bg-light d-flex align-items-center justify-content-center" style="min-height: 400px; max-height: 550px;">
                                                            <?php if (!empty($validImages)): ?>
                                                                <div id="carousel_<?php echo $Act_ID; ?>" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                                                                    <div class="carousel-inner h-100">
                                                                        <?php foreach ($validImages as $index => $imgSrc): ?>
                                                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?> h-100">
                                                                                <img src="<?php echo $imgSrc; ?>" class="d-block w-100" style="height: 500px; object-fit: contain; background: #1a1a1a;" alt="Activity Image">
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                    <?php if (count($validImages) > 1): ?>
                                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $Act_ID; ?>" data-bs-slide="prev">
                                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $Act_ID; ?>" data-bs-slide="next">
                                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <img src="https://placehold.co/600x400?text=No+Image" class="img-fluid" alt="No image available">
                                                            <?php endif; ?>
                                                        </div>
                                                        
                                                        <!-- ฝั่งขวา: รายละเอียดเนื้อหาข้อมูล -->
                                                        <div class="col-lg-5 p-4 d-flex flex-column bg-white">
                                                            <span class="badge bg-success align-self-start mb-2"><?php echo $Act_Format; ?></span>
                                                            <h3 class="fw-bold mb-3" style="color: #123a0d;"><?php echo $Act_Title; ?></h3>
                                                            
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-borderless fs-6">
                                                                    <tr>
                                                                        <td width="35%" class="text-muted fw-bold"><i class="fa fa-calendar text-secondary me-2"></i>วันที่จัด:</td>
                                                                        <td><?php echo $Act_Date; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-muted fw-bold"><i class="fa fa-clock text-secondary me-2"></i>เวลาจัด:</td>
                                                                        <td><?php echo $Act_Time; ?> น.</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-muted fw-bold"><i class="fa fa-map-marked text-secondary me-2"></i>สถานที่:</td>
                                                                        <td><span class="text-wrap"><?php echo $Act_Location; ?></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-muted fw-bold"><i class="fa fa-bullseye text-secondary me-2"></i>กลุ่มเป้าหมาย:</td>
                                                                        <td><?php echo $Act_TargetGroup; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-muted fw-bold"><i class="fa fa-users text-secondary me-2"></i>ผู้เข้าร่วม:</td>
                                                                        <td><span class="badge bg-light text-dark px-2 py-1"><?php echo $Act_Participants; ?> คน</span></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            
                                                            <hr class="my-2">
                                                            <div class="flex-grow-1 overflow-auto pe-1" style="max-height: 200px;">
                                                                <h6 class="fw-bold text-dark mb-1"><i class="fa fa-file-alt me-2 text-secondary"></i>รายละเอียดเพิ่มเติม:</h6>
                                                                <p class="text-muted small text-break" style="text-indent: 20px; line-height: 1.6;"><?php echo nl2br($Act_Detail); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light p-2">
                                                    <button type="button" class="btn btn-secondary px-4 rounded-pill btn-sm" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php 
                                } // ปิด While Loop บรรทัดนี้
                                echo "</div>"; // ปิด Row กิจกรรมหลัก
                            ?>

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
                                        <input type="hidden" name="Site_ID" value="<?php echo $Login_Site; ?>">
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
                                        <input type="file" name="Act_ImageC" class="form-control form-control-lg" accept="image/*" >
                                        <small class="text-muted">รองรับไฟล์ .jpg, .png ขนาดไม่เกิน 5MB</small>
                                    </div>

                                   <div class="col-4">
                                        <label class="form-label fw-bold">รูปภาพกิจกรรมที่ 4</label>
                                        <input type="file" name="Act_ImageD" class="form-control form-control-lg" accept="image/*" >
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

        if (video) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(error => {
                    console.error('Camera error:', error);
                    alert('ไม่สามารถเข้าถึงกระบวนการบันทึกเวลา: ' + error.message);
                });
        }

        if (captureBtn && canvas && video) {
            captureBtn.addEventListener('click', () => {
                const ctx = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0);
                console.log('Photo captured');
            });
        }
    </script>

</body>

</html>