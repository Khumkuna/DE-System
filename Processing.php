<?php 
include 'Connect.php';

if(isset($_POST['login'])) {
    $User = $_POST['User'];
    $Password = $_POST['Password'];

    $salt = "1234a1%2F8{}&*%#@!";
    $Password = hash('sha256', $Password . $salt);

    $sql = "SELECT * FROM account_tb WHERE Acc_User='$User' AND Acc_Password='$Password'";
    $result = $conn->query($sql);
    $AccID = $result->fetch_assoc()['Acc_ID'];
    $_SESSION['Acc_ID'] = $AccID;

    if ($result->num_rows > 0) {
        
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
                          header("refresh:2; url=Home");

    } else {
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
    }
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



?>