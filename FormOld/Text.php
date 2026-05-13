-- 1. ตั้งค่าความลึกของการเรียกซ้ำให้เพียงพอ (มากกว่า 1127) Si_ID
SET @@cte_max_recursion_depth = 2000;

-- 2. รันคำสั่ง INSERT เพื่อเพิ่มข้อมูลทั้งหมด 563,500 แถว
INSERT INTO de_system_db.attendance_tb (ATT_ID, Site_ID, ATT_Day, ATT_Date, ATT_MonthYear, ATT_TimeIN, ATT_TimeOut, ATT_Work)
-- 1. สร้างชุดวันที่ทั้งหมด
WITH RECURSIVE
    DateSeries AS (
        SELECT DATE('2026-05-15') AS ATT_Date_Generated
        UNION ALL
        SELECT DATE_ADD(ATT_Date_Generated, INTERVAL 1 DAY)
        FROM DateSeries
        WHERE ATT_Date_Generated < DATE('2028-01-21')
    ),
-- 2. สร้างชุด Site_ID ทั้งหมด (Si001 ถึง Si457)
    SiSeries AS (
        SELECT 1 AS Si_Num
        UNION ALL
        SELECT Si_Num + 1
        FROM SiSeries
        WHERE Si_Num < 457
    )
-- 3. รวมชุดวันที่และ Site_ID เข้าด้วยกัน (CROSS JOIN) เพื่อสร้างข้อมูล
SELECT
    CONCAT(
        'Si', 
        LPAD(S.Si_Num, 3, '0'), 
        DATE_FORMAT(D.ATT_Date_Generated, '%Y%m%d')
    ) AS ATT_ID,
    CONCAT('Si', LPAD(S.Si_Num, 3, '0')) AS Site_ID,
    DAYNAME(D.ATT_Date_Generated) AS ATT_Day,
    D.ATT_Date_Generated AS ATT_Date,
    DATE_FORMAT(D.ATT_Date_Generated, '%Y-%m') AS ATT_MonthYear,
    '-' AS ATT_TimeIN,
    '-' AS ATT_TimeOut,
    'งวดงานที่ X' AS ATT_Work
FROM 
    DateSeries D
CROSS JOIN 
    SiSeries S
ORDER BY 
    Site_ID, ATT_Date;

-- 3. (ทางเลือก) รีเซ็ตกลับไปเป็นค่าเริ่มต้นหลังเสร็จสิ้น
-- SET @@cte_max_recursion_depth = 1000;