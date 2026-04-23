 <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
 
  <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="Home" class="navbar-brand mx-4 mb-3 d-none d-lg-block">
                    <img src="img/BDE-Logo.png" alt="Logo" style="width: 200px; height: 80px;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Jhon Doe</h6>
                        <span><?php echo $PageActive; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="Home" class="nav-item nav-link <?php if($PageActive == 'Home') echo 'active'; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown" >
                        <a  class="nav-link dropdown-toggle <?php if($PageActive == 'Attendance' || $PageActive == 'AttendanceAll' || $PageActive == 'AttendanceReport') echo 'active'; ?>" data-bs-toggle="dropdown" ><i class="fa fa-calendar me-2"></i>การปฏิบัติงาน</a>
                        <div class="dropdown-menu bg-transparent border-0 <?php if($PageActive == 'Attendance' || $PageActive == 'AttendanceAll' || $PageActive == 'AttendanceReport') echo 'show'; ?>" >
                            <a href="Attendance" class="dropdown-item <?php if($PageActive == 'Attendance') echo 'active'; ?>" >บันทึกเวลา</a>
                            <a href="Attendance_All" class="dropdown-item <?php if($PageActive == 'AttendanceAll') echo 'active'; ?>">ปฏิบัติงานทั้งหมด</a>
                            <!-- <a href="blank.html" class="dropdown-item <?php if($PageActive == 'AttendanceReport') echo 'active'; ?>">รายงาน</a> -->
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?php if($PageActive == 'Service' || $PageActive == 'ServiceAll' || $PageActive == 'ServiceReport') echo 'active'; ?>" data-bs-toggle="dropdown"><i class="fa fa-users me-2"></i>การให้บริการ</a>
                        <div class="dropdown-menu bg-transparent border-0 <?php if($PageActive == 'Service' || $PageActive == 'ServiceAll' || $PageActive == 'ServiceReport') echo 'show'; ?>">
                            <a href="Service" class="dropdown-item <?php if($PageActive == 'Service') echo 'active'; ?>">ผู้เข้าใช้บริการเดือนนี้</a>
                            <a href="Service_All" class="dropdown-item <?php if($PageActive == 'ServiceAll') echo 'active'; ?>">ผู้เข้าใช้บริการทั้งหมด</a>
                            <a href="Service_Report" class="dropdown-item <?php if($PageActive == 'ServiceReport') echo 'active'; ?>">รายงาน</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?php if($PageActive == 'Activity' || $PageActive == 'ActivityAll' || $PageActive == 'ActivityReport') echo 'active'; ?>" data-bs-toggle="dropdown"><i class="fa fa-graduation-cap me-2"></i>ข้อมูลกิจกรรม</a>
                        <div class="dropdown-menu bg-transparent border-0 <?php if($PageActive == 'Activity' || $PageActive == 'ActivityAll' || $PageActive == 'ActivityReport') echo 'show'; ?>">
                            <a href="Activity" class="dropdown-item <?php if($PageActive == 'Activity') echo 'active'; ?>">กิจกรรมเดือนนี้</a>
                            <a href="Activity_All" class="dropdown-item <?php if($PageActive == 'ActivityAll') echo 'active'; ?>">กิจกรรมทั้งหมด</a>
                            <a href="Activity_Report" class="dropdown-item <?php if($PageActive == 'ActivityReport') echo 'active'; ?>">รายงาน</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?php if($PageActive == 'Repair' || $PageActive == 'RepairAll') echo 'active'; ?>" data-bs-toggle="dropdown"><i class="fa fa-cogs me-2"></i>การแจ้งซ่อม</a>
                        <div class="dropdown-menu bg-transparent border-0 <?php if($PageActive == 'Repair' || $PageActive == 'RepairAll') echo 'show'; ?>">
                            <a href="Repair" class="dropdown-item <?php if($PageActive == 'Repair') echo 'active'; ?>">แจ้งซ่อมเดือนนี้</a>
                            <a href="Repair_All" class="dropdown-item <?php if($PageActive == 'RepairAll') echo 'active'; ?>">แจ้งซ่อมทั้งหมด</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?php if($PageActive == 'Upload' || $PageActive == 'UploadAll') echo 'active'; ?>" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Upload รายงาน</a>
                        <div class="dropdown-menu bg-transparent border-0 <?php if($PageActive == 'Upload' || $PageActive == 'UploadAll') echo 'show'; ?>">
                            <a href="Attendance" class="dropdown-item <?php if($PageActive == 'Upload') echo 'active'; ?>">Upload รายงานเดือนนี้</a>
                            <a href="blank.html" class="dropdown-item <?php if($PageActive == 'UploadAll') echo 'active'; ?>">Upload รายงานทั้งหมด</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->