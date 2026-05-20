<?php
$PageActive = 'AttendanceCheck';


?>

<!DOCTYPE html>
<html lang="en">

<?php include 'Tools/Header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
    <?php include 'Tools/Sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
            
        <?php include 'Tools/Navbar.php'; ?>


            <!-- Button Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12" align="center">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" style="color: #1ff308;" >
                        <span class="mb-0" >
                        <h1 class="mb-0" style="color: #123a0d;" >ข้อมูลการขอเข้าใช้งานระบบ</h1><br>
                        </div>
                     </div>   
                </div>
                <br>
            </div>

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12" align="center">
                        <div class="bg-light rounded  justify-content-center p-4" style="color: #1ff308;" >
                            <span class="mb-0">
                                <h5 style="color: #123a0d;">ข้อมูลการปฏิบัติงานของเจ้าหน้าที่ประจำศูนย์ MS-Siam Tower ในเดือน  <?php echo $MonthName.' '.$GetYears; ?></h5>
                                <table class="table table-bordered" width="100%" style="color: #123a0d;">
                                    <thead>
                                        <tr align="center">
                                            <th>#</th>
                                            <th>วันที่</th>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>สถานะ Account</th>
                                            <th>Line-ID</th>
                                            <th>เบอร์ติดต่อ</th>
                                            <th>ชื่อศูนย์</th>
                                            <th>ตำบล</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>เครื่องมือ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowsPerPage = 20;
                                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $rowsPerPage;
                                        
                                        $GetAccount = "Select * From account_tb Where Acc_Active = 'Waiting_Active' LIMIT $rowsPerPage OFFSET $offset";
                                        $ResultGetAccount = $conn->query($GetAccount);
                                        
                                        $rowCount = 0;
                                        if ($ResultGetAccount->num_rows > 0) {
                                            while($row = $ResultGetAccount->fetch_assoc()) {
                                                echo "<tr align='center'>";
                                                echo "<td>".($offset + $rowCount + 1)."</td>";
                                                echo "<td>".date('d/m/Y H:i', strtotime($row['Acc_DateCreate']))."</td>";
                                                echo "<td>".$row['Acc_Fullname']."</td>";
                                                echo "<td>".$row['Acc_Role']."</td>";
                                                echo "<td>".$row['Acc_LineID']."</td>";
                                                echo "<td>".$row['Acc_Phone']."</td>";
                                               
                                                $SiteID = $row['Site_ID'];
                                                $GetSiteInfo = "SELECT Site_Name,Site_Subdistrict, Site_District, Site_Province FROM Site_tb WHERE Site_ID = '$SiteID'";
                                                $ResultGetSiteInfo = $conn->query($GetSiteInfo);
                                                if ($ResultGetSiteInfo->num_rows > 0) {
                                                    $SiteInfo = $ResultGetSiteInfo->fetch_assoc();
                                                    echo "<td>".$SiteInfo['Site_Name']."</td>";
                                                    echo "<td>".$SiteInfo['Site_Subdistrict']."</td>";
                                                    echo "<td>".$SiteInfo['Site_District']."</td>";
                                                    echo "<td>".$SiteInfo['Site_Province']."</td>";
                                                } else {
                                                    echo "<td>-</td><td>-</td><td>-</td><td>-</td>";
                                                }
                                                
                                                echo "<td>
                                                        <button class='btn btn-success btn-sm ApproveBtn' data-id='".$row['Acc_ID']."'>อนุมัติ</button>
                                                        <button class='btn btn-danger btn-sm RejectBtn' data-id='".$row['Acc_ID']."'>ปฏิเสธ</button>
                                                      </td>";
                                                echo "</tr>";
                                                $rowCount++;
                                            }
                                            
                                            // Add empty rows if data doesn't fill the page
                                            for ($i = $rowCount; $i < $rowsPerPage; $i++) {
                                                echo 
                                                "<tr align='center'>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='10' align='center'>ไม่มีข้อมูลการปฏิบัติงานในเดือนนี้</td></tr>";
                                            // Add empty rows for consistency
                                            for ($i = 1; $i < $rowsPerPage; $i++) {
                                                echo "<tr align='center'><td colspan='10'>&nbsp;</td></tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                                <!-- Pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        $CountQuery = "Select COUNT(*) as total From account_tb Where Acc_Active = 'Waiting_Active'";
                                        $CountResult = $conn->query($CountQuery);
                                        $CountRow = $CountResult->fetch_assoc();
                                        $totalPages = ceil($CountRow['total'] / $rowsPerPage);
                                        
                                        if ($page > 1) {
                                            echo "<li class='page-item'><a class='page-link' href='?page=1'>หน้าแรก</a></li>";
                                            echo "<li class='page-item'><a class='page-link' href='?page=".($page-1)."'>ก่อนหน้า</a></li>";
                                        }
                                        
                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
                                        }
                                        
                                        if ($page < $totalPages) {
                                            echo "<li class='page-item'><a class='page-link' href='?page=".($page+1)."'>ถัดไป</a></li>";
                                            echo "<li class='page-item'><a class='page-link' href='?page=$totalPages'>หน้าสุดท้าย</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                <br><br><br><br><br>
                            </span>
                        </div> 
                     </div>   
                </div>
                <br>
            </div>
            
            <?php
            include 'Tools/Footer.php'; 
            ?>
       

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>