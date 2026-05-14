<?php 
include 'Connect.php';

if(isset($_POST['login'])) {
    $User = $_POST['User'];
    $Password = $_POST['Password'];

    $salt = "1234a1%2F8{}&*%#@!";
    $Password = hash('sha256', $Password . $salt);

    $sql = "SELECT * FROM account_tb WHERE Acc_User='$User' AND Acc_Password='$Password'";
    $result = $conn->query($sql);
    $AccResult = $result->fetch_assoc();
    $AccID = $AccResult['Acc_ID'];
    $AccActive = $AccResult['Acc_Active'];
    $_SESSION['Acc_ID'] = $AccID;
   

    
    if ($result->num_rows > 0) 
      {
            if ($AccActive == 'Yes') {

                              echo "
                                        <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                        <script>
                                              $(document).ready(function(){
                                                Swal.fire({
                                                  title:'Login Successfully!',
                                                  icon: 'success',
                                                  timer: 2000,
                                                  showConfirmButton: false
                                                });
                                              });
                                              </script>";
                                              header("refresh:2; url=Session");
              
          }
          else
            {  
                            echo "
                                        <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                        <script>
                                              $(document).ready(function(){
                                                Swal.fire({
                                                  title:'Account Not Activated!',
                                                  text: 'Your account is not activated yet. Please wait for activation.',
                                                  icon: 'warning',
                                                  timer: 3000,
                                                  showConfirmButton: false
                                                });
                                              });
                                              </script>";
                            session_destroy();
                            header("refresh:3; url=index");
                            exit();
                          
                  }

    } 
    else 
    {
        echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'Login Failed!',
                              text: 'Invalid username or password.',
                              icon: 'error',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
                              session_destroy();
                              header("refresh:2; url=index");
    }
}

if(isset($_POST['CheckIn'])) {
  $Login_Site = $_POST['Login_Site'];
  $Login_Acc = $_POST['Login_Acc'];
  $CheckInTime = date('Y-m-d H:i');
  $ATT_ID = $Login_Site.date('Ymd');
  $TimeNow = date('H:i');

  $Lattitude = $_POST['lat'];
  $Longitude = $_POST['lng'];
  $device_info = $_POST['device_info'];

   // รับค่ารูปภาพจากฟอร์ม (สมมติว่าใช้ input type="hidden" ชื่อ 'camera_capture' เพื่อเก็บค่า Base64)
  $image_data = $_POST['camera_capture']; 

    if (!empty($image_data)) {
        // --- ส่วนการจัดการบันทึกไฟล์ลง Drive D ---
        
        // 1. กำหนดโฟลเดอร์ปลายทางใน Drive D (ต้องใช้เครื่องหมาย / หรือ \\)
        $folderPath = "D:/Upload/Attendance_Images/"; 
        
        // 2. ตรวจสอบว่าโฟลเดอร์มีอยู่จริงหรือไม่ ถ้าไม่มีให้สร้างใหม่
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        
        // 3. จัดการ Base64
        $image_parts = explode(";base64,", $image_data);
        $image_base64 = base64_decode($image_parts[1]);
        
        // 4. ตั้งชื่อไฟล์
        $fileName = "IN_" . date('Ymd_His') . "_" . $Login_Acc . ".jpg";
        $fileFullCheck = $folderPath . $fileName;

        // 5. บันทึกไฟล์
        if (file_put_contents($fileFullCheck, $image_base64)) {
        }
    } 





  if($TimeNow > '08:35'){$Status = 'Late';} else {$Status = 'On Time';}

  $sql_Checkin = "UPDATE `de_system_db`.`attendance_tb` SET `ATT_TimeIn` = '$TimeNow', `Acc_ID` = '$Login_Acc', `ATT_Status` = '$Status', `ATT_Image` = '$fileName', `ATT_Latitude` = '$Lattitude', `ATT_Longitude` = '$Longitude', `ATT_Device` = '$device_info' WHERE (`ATT_ID` = '$ATT_ID')";
  if ($conn->query($sql_Checkin) === TRUE) {

  $_SESSION['CheckInTimeToday'] = $CheckInTime;
    echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'Check-In Successful!',
                              text: 'Your attendance has been recorded.',
                              icon: 'success',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
    header("refresh:2; url=Attendance");
  }
} 

if(isset($_POST['CheckOut'])) {
  $Login_Site = $_POST['Login_Site'];
  $Login_Acc = $_POST['Login_Acc'];
  $CheckOut_Remark = $_POST['CheckOut_Remark'];
  $CheckOutTime = date('Y-m-d H:i');
  $ATT_ID = $Login_Site.date('Ymd');
  $TimeNow = date('H:i');

  $sql_Checkout = "UPDATE `de_system_db`.`attendance_tb` SET `ATT_TimeOut` = '$TimeNow', `ATT_Remark` = '$CheckOut_Remark' WHERE (`ATT_ID` = '$ATT_ID')";
  if ($conn->query($sql_Checkout) === TRUE) {
    $_SESSION['CheckInTimeToday']= $CheckOutTime;
    echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'Check-Out Successful!',
                              text: 'Your attendance has been recorded.',
                              icon: 'success',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
    header("refresh:2; url=Attendance");
  }
}
    



if(isset($_SESSION['Acc_ID'])=="") {

  echo "
  <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script>
      $(document).ready(function(){
        Swal.fire({
          title:'Session มีปัญหาโปรด Login เข้าระบบใหม่อีกครั้ง',
          icon: 'error',
          timer: 2000,
          showConfirmButton: false
        });
      });
      </script>";
  header("refresh:2; url=index");
  exit();

}

if(isset($_POST['logout'])) {
     echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'Logout Successfully!',
                              text: 'You have been logged out.',
                              icon: 'success',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
    session_destroy();
    unset($_SESSION['Acc_ID']);
    header("refresh:2; url=index");
}

if(isset($_POST['register'])) {
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $User = $_POST['User'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $RegisterDate = date('Y-m-d H:i:s');
    


    $salt = "1234a1%2F8{}&*%#@!";
    $Password = hash('sha256', $Password . $salt);

    $sql = "INSERT INTO account_tb (Acc_Fullname, Acc_Email, Acc_Phone, Acc_User, Acc_Password, Acc_Role ,Acc_Active, Acc_RegisterDate) VALUES ('$Name', '$Email', '$Phone', '$User', '$Password', 'User', 'Registered', '$RegisterDate')";
    if ($conn->query($sql) === TRUE) {
        echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'Registration Successful!',
                              text: 'Your account has been created.',
                              icon: 'success',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
        header("refresh:2; url=index");
    } else {
        echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'Registration Failed!',
                              text: 'An error occurred while creating your account.',
                              icon: 'error',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
        header("refresh:2; url=Register");
    }
}



?>