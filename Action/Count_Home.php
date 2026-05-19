<?php
include 'connect.php';
$Login_Name = $_SESSION['Login_Name'];
$Login_Site = $_SESSION['Login_Site'];
$Login_Acc = $_SESSION['Login_Acc'];
$Login_Role = $_SESSION['Login_Role'];


$Today = date('Y-m-d');
$CountServiceToday = $conn->query("SELECT sum(Sur_QTY) AS TotalServiceToday FROM Survey_tb WHERE Site_ID = '$Login_Site' and Sur_Date = '$Today'")->fetch_assoc();
$TotalServiceToday = $CountServiceToday['TotalServiceToday'];


$MonthlyService = $conn->query("SELECT sum(Sur_QTY) AS TotalMonthlyService FROM Survey_tb WHERE Site_ID = '$Login_Site' and MONTH(Sur_Date) = MONTH(CURRENT_DATE()) AND YEAR(Sur_Date) = YEAR(CURRENT_DATE())")->fetch_assoc();
$TotalMonthlyService = $MonthlyService['TotalMonthlyService'];

$TotalService = $conn->query("SELECT sum(Sur_QTY) AS TotalService FROM Survey_tb WHERE Site_ID = '$Login_Site'")->fetch_assoc();
$TotalService = $TotalService['TotalService'];


$TotalLastMonthService_1 = 0;
$TotalLastMonthService_2 = 0;
$TotalLastMonthService_3 = 0;
$TotalLastMonthService_4 = 0;
$TotalLastMonthService_5 = 0;

$GetLastMonth_1 = date('Y-m', strtotime('-1 month'));
$LastMonthService_1 = $conn->query("SELECT sum(Sur_QTY) AS TotalLastMonthService_1 FROM Survey_tb WHERE Site_ID = '$Login_Site' and DATE_FORMAT(Sur_Date, '%Y-%m') = '$GetLastMonth_1'")->fetch_assoc();
$TotalLastMonthService_1 = $LastMonthService_1['TotalLastMonthService_1'];

$GetLastMonth_2 = date('Y-m', strtotime('-2 month'));
$LastMonthService_2 = $conn->query("SELECT sum(Sur_QTY) AS TotalLastMonthService_2 FROM Survey_tb WHERE Site_ID = '$Login_Site' and DATE_FORMAT(Sur_Date, '%Y-%m') = '$GetLastMonth_2'")->fetch_assoc();
$TotalLastMonthService_2 = $LastMonthService_2['TotalLastMonthService_2'];

$GetLastMonth_3 = date('Y-m', strtotime('-3 month'));
$LastMonthService_3 = $conn->query("SELECT sum(Sur_QTY) AS TotalLastMonthService_3 FROM Survey_tb WHERE Site_ID = '$Login_Site' and DATE_FORMAT(Sur_Date, '%Y-%m') = '$GetLastMonth_3'")->fetch_assoc();
$TotalLastMonthService_3 = $LastMonthService_3['TotalLastMonthService_3'];

$GetLastMonth_4 = date('Y-m', strtotime('-4 month'));
$LastMonthService_4 = $conn->query("SELECT sum(Sur_QTY) AS TotalLastMonthService_4 FROM Survey_tb WHERE Site_ID = '$Login_Site' and DATE_FORMAT(Sur_Date, '%Y-%m') = '$GetLastMonth_4'")->fetch_assoc();
$TotalLastMonthService_4 = $LastMonthService_4['TotalLastMonthService_4'];

$GetLastMonth_5 = date('Y-m', strtotime('-5 month'));
$LastMonthService_5 = $conn->query("SELECT sum(Sur_QTY) AS TotalLastMonthService_5 FROM Survey_tb WHERE Site_ID = '$Login_Site' and DATE_FORMAT(Sur_Date, '%Y-%m') = '$GetLastMonth_5'")->fetch_assoc();
$TotalLastMonthService_5 = $LastMonthService_5['TotalLastMonthService_5'];





?>