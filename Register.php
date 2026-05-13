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
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index"><img src="img/BDE-Logo.png" alt="Logo" style="height: 50px;"></a>
                            <h3>Register</h3>
                        </div>
                        
                        <form id="registerForm" method="POST" action="Processing">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="Name" placeholder="Full Name" required>
                                <label>ชื่อ - นามสกุล</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="Email" placeholder="Email" required>
                                <label>Email address</label>
                            </div>
                            
                            <!-- Username Section -->
                            <div class="form-floating mb-1">
                                <input type="text" class="form-control" id="floatingUsername" name="User" placeholder="Username" required>
                                <label>Username (ภาษาอังกฤษเท่านั้น)</label>
                            </div>
                            <div class="mb-3">
                                <small id="usernameStatus" class="fw-bold"></small>
                            </div>

                            <!-- Password Section -->
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="Password" placeholder="Password" required>
                                <label>Password</label>
                            </div>
                            <div class="form-floating mb-1">
                                <input type="password" class="form-control" id="floatingConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password" required>
                                <label>Confirm Password</label>
                            </div>
                            <div class="mb-4">
                                <small id="passwordStatus" class="fw-bold"></small>
                            </div>

                            <button type="submit" id="btnRegister" class="btn btn-primary py-3 w-100 mb-4" name="register">Register</button>
                            <p class="text-center mb-0">Already have an Account? <a href="index">Sign In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const usernameInput = document.getElementById('floatingUsername');
        const passwordInput = document.getElementById('floatingPassword');
        const confirmInput = document.getElementById('floatingConfirmPassword');
        const btnRegister = document.getElementById('btnRegister');

        // ฟังก์ชันตรวจสอบสถานะปุ่ม Register
        function validateForm() {
            const isUsernameOk = usernameInput.classList.contains('is-valid');
            const isPasswordValid = passwordInput.value.length >= 6;
            const isPasswordMatch = (passwordInput.value === confirmInput.value) && passwordInput.value !== "";
            
            btnRegister.disabled = !(isUsernameOk && isPasswordMatch && isPasswordValid);
        }

        // 1. ตรวจสอบ Username (อังกฤษเท่านั้น + เช็คซ้ำ)
        usernameInput.addEventListener('input', function() {
            let username = this.value.trim();
            let status = document.getElementById('usernameStatus');
            const englishRegex = /^[A-Za-z0-9_]+$/; // อนุญาตเฉพาะ อังกฤษ, ตัวเลข, _

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

        // 2. ตรวจสอบ Password Match
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