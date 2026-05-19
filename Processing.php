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

if(isset($_POST['Modal_Save'])) {

  $SiteID = $_POST['Site_ID'];
  $fullname = $_POST['fullname'];
  $phone = $_POST['phone'];
  $age_range = $_POST['age_range'];
  $services = $_POST['services'];
  $services = implode(", ", $services); // แปลง array เป็น string โดยใช้คอมม่าและช่องว่างเป็นตัวคั่น
  $career = $_POST['career'];
  $career_other = $_POST['career_other'];
  if($career_other != "") {
    $career = $career . " - " . $career_other;
  }



  $gender = $_POST['gender'];
  $TimeNow = date('H:i');
  $DateNow = date('Y-m-d');
  $MonthYearNow = date('Y-m');
  
  $disability_status = $_POST['disability_status'];
  $disability_other = $_POST['disability_other'];

  if($disability_other != "") {
    $disability_detail = $disability_status . " - " . $disability_other;
  } else {
    $disability_detail = $disability_status;
  }




  if($DateNow > '2026-05-01' && $DateNow <= '2026-10-28'){$SurWork = 'งวดงานที่ 08';} 
  else if($DateNow > '2026-10-28' && $DateNow <= '2027-04-26'){$SurWork = 'งวดงานที่ 09';} 
  else if($DateNow > '2027-04-26' && $DateNow <= '2027-10-23'){$SurWork = 'งวดงานที่ 10';} 
  else{$SurWork = 'งวดงานที่ 11';} 

  if($gender == 'ชาย') {
    $Sur_GenderMan = '1';
    $Sur_GenderWoman = '0';
    $Sur_GenderNone = '0';
  } else if($gender == 'หญิง') {
    $Sur_GenderMan = '0';
    $Sur_GenderWoman = '1';
    $Sur_GenderNone = '0';
  } else {
    $Sur_GenderMan = '0';
    $Sur_GenderWoman = '0';
    $Sur_GenderNone = '1';
  }


  $sql_Center = "INSERT INTO survey_tb (Sur_Work, Sur_Date, Sur_MonthYear, Sur_TimeIn, Sur_TimeOut, Sur_Name, Sur_National_ID, Sur_Tel, Sur_Age, Sur_GenderMan,Sur_GenderWoman,Sur_GenderNone, Sur_Disperson, Sur_DispersonDetail, Sur_QTY, Sur_Type, Sur_Subject, Sur_Remark, Sur_Job,Site_ID) 
  VALUES ('$SurWork', '$DateNow', '$MonthYearNow', '$TimeNow', '-', '$fullname', '-', '$phone', '$age_range', '$Sur_GenderMan', '$Sur_GenderWoman', '$Sur_GenderNone', '$disability_detail', '-', '1', 'Person', '$services', '', '$career', '$SiteID')";
  if ($conn->query($sql_Center) === TRUE) {
    echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'บันทึกข้อมูลศูนย์สำเร็จ!',
                              text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                              icon: 'success',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
    header("refresh:2; url=index");
  }
}

if(isset($_SESSION['Acc_ID'])=="" && $_POST['Survey']=="") {
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

if(isset($_POST['Save_Activity'])){
  $Act_Title = $_POST['Act_Title'];
  $Act_Date = $_POST['Act_Date'];
  $Act_Time = $_POST['Act_Time'];
  $Act_Duration = $_POST['Act_Duration'];
  $Act_Participants = $_POST['Act_Participants'];
  $Act_Detail = $_POST['Act_Detail'];
  $Act_TargetGroup = $_POST['Act_TargetGroup'];
  $Act_Format = $_POST['Act_Format'];
  $Act_Location = $_POST['Act_Location'];
  $Act_ImageA = $_FILES['Act_ImageA'];
  $Act_ImageB = $_FILES['Act_ImageB'];
  $Act_ImageC = $_FILES['Act_ImageC'];
  $Act_ImageD = $_FILES['Act_ImageD'];
  $Act_ImageE = $_FILES['Act_ImageE'];
  $Act_AgeRange = $_POST['Act_AgeRange'];
  $Act_Male = $_POST['Act_Male'];
  $SiteID = $_POST['Site_ID'];

  $ChangeDateFormat = date('Ymd', strtotime($Act_Date));
  $ChangeTimeFormat = date('His', strtotime($Act_Time));
  $DateGenerate = $ChangeDateFormat . $ChangeTimeFormat;


  $Sur_GenderMan = $Act_Male;
  $Sur_GenderWoman = $Act_Participants-$Act_Male;



  $Act_MonthYear = date('Y-m', strtotime($Act_Date));

  $Act_TimeOut = date('H:i', strtotime($Act_Time) + ($Act_Duration * 3600));
  
  if($Act_Date > '2026-05-01' && $Act_Date <= '2026-10-28'){$SurWork = 'งวดงานที่ 08';} 
  else if($Act_Date > '2026-10-28' && $Act_Date <= '2027-04-26'){$SurWork = 'งวดงานที่ 09';} 
  else if($Act_Date > '2027-04-26' && $Act_Date <= '2027-10-23'){$SurWork = 'งวดงานที่ 10';} 
  else{$SurWork = 'งวดงานที่ 11';} 

  $PatchImage = "D:/Upload/Activity_Images/";
  
  // เช็ค extension และสร้างชื่อไฟล์ใหม่
  $imageFiles = ['Act_ImageA' => $Act_ImageA, 'Act_ImageB' => $Act_ImageB, 'Act_ImageC' => $Act_ImageC, 'Act_ImageD' => $Act_ImageD, 'Act_ImageE' => $Act_ImageE];
  $imageNames = [];
  $imageSuffix = ['Act_ImageA' => 'A', 'Act_ImageB' => 'B', 'Act_ImageC' => 'C', 'Act_ImageD' => 'D', 'Act_ImageE' => 'E'];
  
  foreach($imageFiles as $key => $image){
    if(!empty($image['name'])){
      $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
      $newName = $SiteID .'_' . $DateGenerate . '_' . $imageSuffix[$key] . '.' . $ext;
      move_uploaded_file($image['tmp_name'], $PatchImage . $newName);
      $imageNames[$key] = $newName;
    } else {
      $imageNames[$key] = '';
    }
  }

  if(count($imageNames) > 0){
     $Act_ImageA = $imageNames['Act_ImageA'];
     $Act_ImageB = $imageNames['Act_ImageB'];
     $Act_ImageC = $imageNames['Act_ImageC'];
     $Act_ImageD = $imageNames['Act_ImageD'];
     $Act_ImageE = $imageNames['Act_ImageE'];
  } else {
     $Act_ImageA = '';
     $Act_ImageB = '';
     $Act_ImageC = '';
     $Act_ImageD = '';
     $Act_ImageE = '';
  }

  $sql_Center = "INSERT INTO survey_tb (Sur_Work, Sur_Date, Sur_MonthYear, Sur_TimeIn, Sur_TimeOut, Sur_Name, Sur_GenderMan, Sur_GenderWoman, Sur_GenderNone, Sur_QTY, Sur_Type, Sur_Subject, Sur_Remark, Sur_Job,Site_ID,Sur_Target,Sur_TypeACT,Sur_Location ,Sur_ImageA,Sur_ImageB,Sur_ImageC,Sur_ImageD,Sur_ImageE) 
  VALUES ('$SurWork', '$Act_Date', '$Act_MonthYear', '$Act_Time', '$Act_TimeOut', '[กิจกรรม] $Act_Title', '$Sur_GenderMan', '$Sur_GenderWoman','0', '$Act_Participants','Activity', 'จัดกิจกรรม', '$Act_Detail', 'Group Activity', '$SiteID', '$Act_TargetGroup','$Act_Format' ,'$Act_Location', '$Act_ImageA', '$Act_ImageB', '$Act_ImageC', '$Act_ImageD', '$Act_ImageE')";
  if ($conn->query($sql_Center) === TRUE) {
    echo "
                    <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                          $(document).ready(function(){
                            Swal.fire({
                              title:'บันทึกข้อมูลศูนย์สำเร็จ!',
                              text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                              icon: 'success',
                              timer: 2000,
                              showConfirmButton: false
                            });
                          });
                          </script>";
    header("refresh:2; url=Activity");
  }






}

?>