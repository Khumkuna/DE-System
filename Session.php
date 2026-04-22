<?php
include('Connect.php');

if($_SESSION['Acc_ID']!="")
{
  $AccIDLogin = $_SESSION['Acc_ID'];


    $result_Acc=mysqli_query($conn, "SELECT * FROM account_tb WHERE Acc_ID='$AccIDLogin'");
    $Acc_Result=mysqli_fetch_array($result_Acc);
    $Login_Name = $Acc_Result['Acc_Fullname'];
    $Login_User = $Acc_Result['Acc_Username'];
    $Login_Password = $Acc_Result['Acc_Password'];
    $Login_Rule = $Acc_Result['Acc_Rule'];
    $Login_Team = $Acc_Result['Acc_Team'];

    $_SESSION['Login_Name'] = $Login_Name;
    header("refresh:1; url=Home");
}
else
{
      echo "
            <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                  $(document).ready(function(){
                    Swal.fire({
                      title:'Session หมดอายุ โปรด Login เข้าระบบใหม่อีกครั้ง',
                      icon: 'error',
                      timer: 2000,
                      showConfirmButton: false
                    });
                  });
                  </script>";

        unset($_SESSION['Acc_ID']);
        header("refresh:3; url=index");
        exit();
}
// $Acc_ID = $_SESSION['Acc_ID'];
  
// $result_Acc=mysqli_query($conn, "SELECT * FROM account_tb WHERE Acc_ID='$Acc_ID'");
// $Acc_Result=mysqli_fetch_array($result_Acc);
// $Login_Name = $Acc_Result['Acc_Fullname'];
// $Login_User = $Acc_Result['Acc_Username'];
// $Login_Password = $Acc_Result['Acc_Password'];
// $Login_Rule = $Acc_Result['Acc_Rule'];
// $Login_Team = $Acc_Result['Acc_Team'];

//   $Acc_RuleAccount = $Acc_Result['Acc_RuleAccount'];
//   $ACC_RuleSite = $Acc_Result['ACC_RuleSite'];
//   $Acc_RuleService = $Acc_Result['Acc_RuleService'];
//   $Acc_RuleCallcenter = $Acc_Result['Acc_RuleCallcenter'];
//   $Acc_RuleProfile = $Acc_Result['Acc_RuleProfile'];

//   $_SESSION['Login_Name'] = $Login_Name;

//   header("refresh:4; url=Home");

//   session_destroy();
//   unset($_SESSION['Acc_ID']);
//   header("refresh:4; url=index");
// }
// else
// {
//   echo "
//   <script src='https://code.jquery.com/jquery-3.6.4.js'></script>
//   <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//   <script>
//       $(document).ready(function(){
//         Swal.fire({
//           title:'Session ผิดปกติโปรด Login เข้าระบบใหม่อีกครั้ง',
//           icon: 'error',
//           timer: 5000,
//           showConfirmButton: false
//         });
//       });
//       </script>";
  
//   exit();


// }
// if($_SESSION['Acc_ID']=="")
// {  

// }





?>