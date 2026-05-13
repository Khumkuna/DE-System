<?php
// filepath: c:\AppServ\www\DE-System\Test.php

include 'Connect.php';

$sql = "
    UPDATE attendance_tb
    SET ATT_Work = CASE
        WHEN ATT_Date BETWEEN '2026-05-02' AND '2026-10-28' THEN 'งวดงานที่ 08'
        WHEN ATT_Date BETWEEN '2026-10-29' AND '2027-04-26' THEN 'งวดงานที่ 09'
        WHEN ATT_Date BETWEEN '2027-04-27' AND '2027-10-23' THEN 'งวดงานที่ 10'
        WHEN ATT_Date BETWEEN '2027-10-24' AND '2028-01-21' THEN 'งวดงานที่ 11'
        ELSE ATT_Work
    END
";

if ($conn->query($sql)) {
    echo "Update completed successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>