<?php 
include 'connect.php';

$Login_Site = $_SESSION['Login_Site'];

    $CheckBlank = "SELECT Sur_TimeIn, Sur_Date, Sur_ID FROM survey_tb WHERE Sur_TimeOut ='-' and Site_ID = '$Login_Site'";
    $CheckBlankResult = $conn->query($CheckBlank);
     while($Gettmein = $CheckBlankResult->fetch_assoc()) {
        $TimeIn = $Gettmein['Sur_TimeIn'];
        $SurDate = $Gettmein['Sur_Date'];
        $SurID = $Gettmein['Sur_ID'];
    if ($SurDate < date('Y-m-d')) {
        // สุ่มเวลาการใช้งานระหว่าง 45 นาที ถึง 3 ชั่วโมง (180 นาที)
        $randomMinutes = rand(45, 180);
        $TimeOut = date('H:i', strtotime($TimeIn . ' + ' . $randomMinutes . ' minutes'));
        $UpdateCheckOut = "UPDATE survey_tb SET Sur_TimeOut = '$TimeOut' WHERE Sur_ID = '$SurID'";
        $conn->query($UpdateCheckOut);
    }


    }
?>