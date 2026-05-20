<?php 
include 'Connect.php'; 

// --- ส่วนของการจัดการ Request ตรวจสอบ Username (AJAX) ---
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['username'])) {
    $Username = trim($input['username']);
    
    $stmt = $conn->prepare("SELECT Acc_User FROM account_tb WHERE Acc_User = ?");
    $stmt->bind_param("s", $Username);
    $stmt->execute();
    $result = $stmt->get_result();

    header('Content-Type: application/json');
    echo json_encode(['exists' => ($result->num_rows > 0)]);
    $stmt->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DE-System - Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .staff-type-box {
            border: 2px solid #e4e6fc;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .form-check-input:checked ~ .form-check-label .staff-type-box {
            border-color: #0d6efd;
            background-color: #f0f5ff;
        }
        /* สไตล์สำหรับกรอบวงกลม Preview รูปโปรไฟล์ */
        .profile-preview-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #dee2e6;
            overflow: hidden;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-10 col-md-9 col-lg-7 col-xl-6">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a href="index"><img src="img/BDE-Logo.png" alt="Logo" style="height: 50px;"></a>
                            <h3 class="mb-0">Register Staff</h3>
                        </div>
                        
                        <!-- เพิ่ม enctype="multipart/form-data" เพื่อรองรับการอัปโหลดไฟล์รูปภาพ -->
                        <form id="registerForm" method="POST" action="Processing" enctype="multipart/form-data">
                            
                            <!-- ================= ส่วนที่ 1: เลือกประเภทเจ้าหน้าที่ก่อน ================= -->
                            <h6 class="mb-3 text-primary border-bottom pb-2"><i class="fas fa-user-shield me-2"></i>ขั้นตอนที่ 1: เลือกประเภทเจ้าหน้าที่</h6>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <input class="form-check-input d-none" type="radio" name="Staff_Type" id="typeCenter" value="center">
                                    <label class="form-check-label w-100" for="typeCenter">
                                        <div class="p-3 rounded text-center staff-type-box">
                                            <i class="fas fa-building fa-2x mb-2 text-primary"></i>
                                            <div class="fw-bold">เจ้าหน้าที่ศูนย์</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-check-input d-none" type="radio" name="Staff_Type" id="typeTemporary" value="temporary">
                                    <label class="form-check-label w-100" for="typeTemporary">
                                        <div class="p-3 rounded text-center staff-type-box">
                                            <i class="fas fa-user-clock fa-2x mb-2 text-warning"></i>
                                            <div class="fw-bold">เจ้าหน้าที่ชั่วคราว</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- ================= ส่วนที่ 2: เลือกข้อมูลหน่วยงาน / ศูนย์ที่สังกัด ================= -->
                            <div id="locationSection" style="display: none;">
                                <h6 class="mb-3 text-primary border-bottom pb-2"><i class="fas fa-map-marker-alt me-2"></i>ขั้นตอนที่ 2: ข้อมูลหน่วยงาน / ศูนย์ที่สังกัด</h6>
                                
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="selectProvince" name="Province" disabled required>
                                        <option value="" selected disabled>-- เลือกจังหวัด --</option>
                                        <?php
                                        $prov_query = mysqli_query($conn, "SELECT Site_Province FROM Site_tb GROUP BY Site_Province ORDER BY Site_Province ASC");
                                        while($prov = mysqli_fetch_assoc($prov_query)){
                                            echo "<option value='".htmlspecialchars($prov['Site_Province'], ENT_QUOTES)."'>".$prov['Site_Province']."</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="selectProvince">จังหวัด</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" id="selectAmphure" name="Amphure" disabled required>
                                        <option value="" selected disabled>-- เลือกอำเภอ (โปรดเลือกจังหวัดก่อน) --</option>
                                    </select>
                                    <label for="selectAmphure">อำเภอ</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" id="selectTambon" name="Tambon" disabled required>
                                        <option value="" selected disabled>-- เลือกตำบล (โปรดเลือกอำเภอก่อน) --</option>
                                    </select>
                                    <label for="selectTambon">ตำบล</label>
                                </div>

                                <div class="form-floating mb-4">
                                    <select class="form-select" id="selectCenter" name="Center_ID" disabled required>
                                        <option value="" selected disabled>-- เลือกศูนย์ (โปรดเลือกตำบลก่อน) --</option>
                                    </select>
                                    <label for="selectCenter" class="fw-bold text-success">ศูนย์ที่ต้องการลงทะเบียน</label>
                                </div>
                            </div>

                            <!-- ================= ส่วนที่ 3: กำหนดระยะเวลาปฏิบัติงาน (แสดงเฉพาะชั่วคราว) ================= -->
                            <div id="temporarySection" style="display: none;">
                                <h6 class="mb-3 text-warning border-bottom pb-2"><i class="fas fa-calendar-alt me-2"></i>กรอบระยะเวลาปฏิบัติงานชั่วคราว</h6>
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="startDate" name="Start_Date">
                                            <label for="startDate">วันที่เริ่มดำเนินการ</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="endDate" name="End_Date">
                                            <label for="endDate">วันสิ้นสุดการดำเนินการ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= ส่วนที่ 4: ข้อมูลส่วนตัวและบัญชีผู้ใช้ ================= -->
                            <div id="accountSection" style="display: none;">
                                <h6 class="mb-3 text-primary border-bottom pb-2"><i class="fas fa-user me-2"></i>ขั้นตอนที่ 3: ข้อมูลส่วนตัวและบัญชีผู้ใช้</h6>

                                <!-- ส่วนอัปโหลดรูปโปรไฟล์พร้อม Preview ตัวอย่าง -->
                                <div class="d-flex flex-column align-items-center mb-4">
                                    <div class="profile-preview-container mb-2">
                                        <img id="profilePreview" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 24 24' fill='%23ccc'><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5-4-8-4z'/></svg>" alt="Profile Preview">
                                    </div>
                                    <div class="w-100 px-3">
                                        <label for="inputProfile" class="form-label small text-muted fw-bold">รูปถ่ายโปรไฟล์ (รองรับเฉพาะ JPG, JPEG, PNG)</label>
                                        <input class="form-control form-control-sm" type="file" id="inputProfile" name="Profile_Pic" accept="image/jpeg, image/jpg, image/png">
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="inputName" name="Name" placeholder="Full Name">
                                    <label>ชื่อ - นามสกุล</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="inputEmail" name="Email" placeholder="Email">
                                    <label>Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="inputLineID" name="LineID" placeholder="Line-ID">
                                    <label>Line-ID</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="inputPhone" name="Phone" placeholder="Phone">
                                    <label>เบอร์ติดต่อ</label>
                                </div>
                                
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="floatingUsername" name="User" placeholder="Username">
                                    <label>Username (ภาษาอังกฤษเท่านั้น)</label>
                                </div>
                                <div class="mb-3">
                                    <small id="usernameStatus" class="fw-bold"></small>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" name="Password" placeholder="Password">
                                    <label>Password</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="password" class="form-control" id="floatingConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password">
                                    <label>Confirm Password</label>
                                </div>
                                <div class="mb-4">
                                    <small id="passwordStatus" class="fw-bold"></small>
                                </div>

                                <button type="submit" id="btnRegister" class="btn btn-primary py-3 w-100 mb-4" name="register" disabled>Register</button>
                            </div>
                            
                            <p class="text-center mb-0 mt-3">Already have an Account? <a href="index">Sign In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements ประเภทเจ้าหน้าที่
        const radioCenter = document.getElementById('typeCenter');
        const radioTemporary = document.getElementById('typeTemporary');
        
        // DOM Elements กลุ่มฟอร์ม ซ่อน / แสดง
        const locationSection = document.getElementById('locationSection');
        const temporarySection = document.getElementById('temporarySection');
        const accountSection = document.getElementById('accountSection');
        
        // DOM Elements ชุดวันที่ปฏิบัติงาน
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        // DOM Elements อัปโหลดรูปภาพ
        const inputProfile = document.getElementById('inputProfile');
        const profilePreview = document.getElementById('profilePreview');

        // DOM Elements Dropdown สถานที่
        const selectProvince = document.getElementById('selectProvince');
        const selectAmphure = document.getElementById('selectAmphure');
        const selectTambon = document.getElementById('selectTambon');
        const selectCenter = document.getElementById('selectCenter');

        // DOM Elements ข้อมูลบัญชีผู้ใช้
        const inputName = document.getElementById('inputName');
        const inputEmail = document.getElementById('inputEmail');
        const usernameInput = document.getElementById('floatingUsername');
        const passwordInput = document.getElementById('floatingPassword');
        const confirmInput = document.getElementById('floatingConfirmPassword');
        const btnRegister = document.getElementById('btnRegister');

        // --- ระบบแสดง Preview รูปภาพโปรไฟล์ทันทีเมื่อเลือกไฟล์ ---
        inputProfile.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // ตรวจสอบขนาดไฟล์เบื้องต้น (ไม่ควรเกิน 2MB เพื่อความเสถียรของเซิร์ฟเวอร์)
                if (file.size > 2 * 1024 * 1024) {
                    alert('❌ ขนาดไฟล์ใหญ่เกินไป! โปรดเลือกรูปภาพที่มีขนาดไม่เกิน 2MB');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                // หากไม่ได้เลือกไฟล์ ให้เซ็ตกลับเป็น SVG ไอคอนเริ่มต้น
                profilePreview.src = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 24 24' fill='%23ccc'><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5-4-8-4z'/></svg>";
            }
        });

        // --- ฟังก์ชันควบคุมการซ่อน/แสดงกลุ่มฟอร์ม ---
        function toggleStaffType() {
            if (radioCenter.checked || radioTemporary.checked) {
                locationSection.style.display = 'block';
                accountSection.style.display = 'block'; 
                selectProvince.disabled = false;
                
                inputName.required = true;
                inputEmail.required = true;
                usernameInput.required = true;
                passwordInput.required = true;
                confirmInput.required = true;
                
                if (radioTemporary.checked) {
                    temporarySection.style.display = 'block';
                    startDate.required = true;
                    endDate.required = true;
                } else {
                    temporarySection.style.display = 'none';
                    startDate.required = false;
                    endDate.required = false;
                    startDate.value = "";
                    endDate.value = "";
                }
            } else {
                locationSection.style.display = 'none';
                temporarySection.style.display = 'none';
                accountSection.style.display = 'none';
            }
            validateForm();
        }

        radioCenter.addEventListener('change', toggleStaffType);
        radioTemporary.addEventListener('change', toggleStaffType);

        // --- ฟังก์ชันตรวจสอบความถูกต้องของฟอร์มรวม ---
        function validateForm() {
            let isLocationOk = selectCenter.value !== "" && selectCenter.value !== null;
            
            let isDateOk = true;
            if (radioTemporary.checked) {
                isDateOk = startDate.value !== "" && endDate.value !== "";
            }

            let isInfoOk = inputName.value.trim() !== "" && inputEmail.value.trim() !== "";
            const isUsernameOk = usernameInput.classList.contains('is-valid');
            const isPasswordValid = passwordInput.value.length >= 6;
            const isPasswordMatch = (passwordInput.value === confirmInput.value) && passwordInput.value !== "";
            
            btnRegister.disabled = !(isLocationOk && isDateOk && isInfoOk && isUsernameOk && isPasswordMatch && isPasswordValid);
        }

        inputName.addEventListener('input', validateForm);
        inputEmail.addEventListener('input', validateForm);
        startDate.addEventListener('change', validateForm);
        endDate.addEventListener('change', validateForm);

        // ================= ระบบ Chained Dropdown สถานที่ =================
        selectProvince.addEventListener('change', function() {
            const provinceName = this.value;
            resetDropdown(selectAmphure, '-- เลือกอำเภอ --');
            resetDropdown(selectTambon, '-- โปรดเลือกอำเภอก่อน --');
            resetDropdown(selectCenter, '-- โปรดเลือกตำบลก่อน --');

            if(provinceName) {
                fetch(`GetLocation.php?type=amphures&name=${encodeURIComponent(provinceName)}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        let opt = document.createElement('option');
                        opt.value = item.Site_District; 
                        opt.textContent = item.Site_District; 
                        selectAmphure.appendChild(opt);
                    });
                    selectAmphure.disabled = false;
                });
            }
            validateForm();
        });

        selectAmphure.addEventListener('change', function() {
            const districtName = this.value;
            const provinceName = selectProvince.value;
            resetDropdown(selectTambon, '-- เลือกตำบล --');
            resetDropdown(selectCenter, '-- โปรดเลือกตำบลก่อน --');

            if(districtName) {
                fetch(`GetLocation.php?type=districts&province=${encodeURIComponent(provinceName)}&district=${encodeURIComponent(districtName)}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        let opt = document.createElement('option');
                        opt.value = item.Site_Subdistrict; 
                        opt.textContent = item.Site_Subdistrict; 
                        selectTambon.appendChild(opt);
                    });
                    selectTambon.disabled = false;
                });
            }
            validateForm();
        });

        selectTambon.addEventListener('change', function() {
            const subdistrictName = this.value;
            const provinceName = selectProvince.value;
            const districtName = selectAmphure.value;
            resetDropdown(selectCenter, '-- เลือกศูนย์ --');

            if(subdistrictName) {
                fetch(`GetLocation.php?type=centers&province=${encodeURIComponent(provinceName)}&district=${encodeURIComponent(districtName)}&Site_Subdistrict=${encodeURIComponent(subdistrictName)}`)
                .then(res => res.json())
                .then(data => {
                    if(data.length === 0) {
                        let opt = document.createElement('option');
                        opt.value = "";
                        opt.textContent = "❌ ไม่พบศูนย์ในตำบลนี้";
                        selectCenter.appendChild(opt);
                    } else {
                        data.forEach(item => {
                            let opt = document.createElement('option');
                            opt.value = item.Site_ID; 
                            opt.textContent = item.Site_Name; 
                            selectCenter.appendChild(opt);
                        });
                    }
                    selectCenter.disabled = false;
                });
            }
            validateForm();
        });

        selectCenter.addEventListener('change', validateForm);

        function resetDropdown(element, placeholderText) {
            element.innerHTML = `<option value="" selected disabled>${placeholderText}</option>`;
            element.disabled = true;
        }

        // ================= ระบบตรวจสอบ Account (Username / Password) =================
        usernameInput.addEventListener('input', function() {
            let username = this.value.trim();
            let status = document.getElementById('usernameStatus');
            const englishRegex = /^[A-Za-z0-9_]+$/;

            if (username === "") {
                status.textContent = "";
                this.classList.remove('is-valid', 'is-invalid');
                return;
            }

            if (!englishRegex.test(username)) {
                status.textContent = "❌ ต้องเป็นภาษาอังกฤษและตัวเลขเท่านั้น";
                status.className = "text-danger";
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                validateForm();
                return;
            }

            fetch('Register.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ username: username })
            })
            .then(res => res.json())
            .then(data => {
                if (data.exists) {
                    status.textContent = "❌ Username นี้ถูกใช้ไปแล้ว";
                    status.className = "text-danger";
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    status.textContent = "✅ Username นี้ใช้งานได้";
                    status.className = "text-success";
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                }
                validateForm();
            });
        });

        function checkPassword() {
            const pStatus = document.getElementById('passwordStatus');
            if (confirmInput.value === "") {
                pStatus.textContent = "";
                return;
            }

            if (passwordInput.value.length < 6) {
                pStatus.textContent = "❌ รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
                pStatus.className = "text-danger";
                validateForm();
                return;
            }

            if (passwordInput.value === confirmInput.value) {
                pStatus.textContent = "✅ รหัสผ่านตรงกัน";
                pStatus.className = "text-success";
                confirmInput.classList.add('is-valid');
                confirmInput.classList.remove('is-invalid');
            } else {
                pStatus.textContent = "❌ รหัสผ่านไม่ตรงกัน";
                pStatus.className = "text-danger";
                confirmInput.classList.add('is-invalid');
                confirmInput.classList.remove('is-valid');
            }
            validateForm();
        }

        passwordInput.addEventListener('keyup', checkPassword);
        confirmInput.addEventListener('keyup', checkPassword);
    </script>
</body>
</html>