 <?php 
 $PageActive = $_SESSION['PageActive'];

?>
 
 
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
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="Home" class="nav-item nav-link" <?php echo ($PageActive == 'Home') ? 'active' : ''; ?>><i class="fa fa-tachometer-alt me-2"></i>Dashboard <?php echo $PageActive ; ?></a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?php echo ($PageActive == 'Attendance') ? 'show active' : ''; ?>  " data-bs-toggle="dropdown"><i class="fa fa-calendar me-2"></i>การปฏิบัติงาน</a>
                        <div class="dropdown-menu bg-transparent border-0 show">
                            <a href="Attendance" class="dropdown-item" <?php echo ($PageActive == 'Attendance') ? 'active' : ''; ?>>บันทึกเวลา</a>
                            <a href="blank.html" class="dropdown-item">ปฏิบัติงานทั้งหมด</a>
                            <a href="blank.html" class="dropdown-item">รายงาน</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-users me-2"></i>การให้บริการ</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="Attendance" class="dropdown-item">ผู้เข้าใช้บริการเดือนนี้</a>
                            <a href="blank.html" class="dropdown-item">ผู้เข้าใช้บริการทั้งหมด</a>
                            <a href="blank.html" class="dropdown-item">รายงาน</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-graduation-cap me-2"></i>ข้อมูลกิจกรรม</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="Attendance" class="dropdown-item">กิจกรรมเดือนนี้</a>
                            <a href="blank.html" class="dropdown-item">กิจกรรมทั้งหมด</a>
                            <a href="blank.html" class="dropdown-item">รายงาน</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-cogs me-2"></i>การแจ้งซ่อม</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="Attendance" class="dropdown-item">แจ้งซ่อมเดือนนี้</a>
                            <a href="blank.html" class="dropdown-item">แจ้งซ่อมทั้งหมด</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Upload รายงาน</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="Attendance" class="dropdown-item">Upload รายงานเดือนนี้</a>
                            <a href="blank.html" class="dropdown-item">Upload รายงานทั้งหมด</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->