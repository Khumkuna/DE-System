<!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav ms-auto">
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </div>
            </nav>
            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="loginModalLabel">เข้าสู่ระบบ</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="Processing.php">
                        <div class="modal-body">

                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Username</label>
                                    <input type="text" name="User" class="form-control" id="loginEmail" placeholder="กรุณากรอก Username">
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">รหัสผ่าน</label>
                                    <input type="password" name="Password" class="form-control" id="loginPassword" placeholder="กรุณากรอกรหัสผ่าน">
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        จำฉันไว้
                                    </label>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" name="login" class="btn btn-primary">เข้าสู่ระบบ</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <!-- Navbar End -->