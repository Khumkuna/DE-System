
<!DOCTYPE html>
<html lang="en">

<?php include 'Tools/Header_index.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">


      <?php 
      include 'Tools/Sidebar_index.php'; 
      ?>


        <!-- Content Start -->
        <div class="content">
            <?php 
            include 'Tools/Navbar_Index.php'; 
            ?>


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4" id="top">
                <h1>ข้อมูลการให้บริการ</h1>
                <hr>
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-users fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการวันนี้</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการเดือนนี้</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-6">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">ผู้เข้าใช้บริการทั้งหมด</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">ผู้เข้าใช้บริการในแต่ละเดือน</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">การเข้าใช้บริการในแต่ละประเภท</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Top 5 ของผู้เข้าใช้บริการ</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>01 Jan 2045</td>
                                    <td>INV-0123</td>
                                    <td>Jhon Doe</td>
                                    <td>$123</td>
                                    <td>Paid</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->


            <!-- Widgets Start -->
             <br>
            <br>
            <br>

            <div class="container-fluid pt-4 px-4" id="service-section">
                <h1>การบันทึกข้อมูลเข้าใช้บริการ</h1>
                <hr>
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">ลงชื่อเข้าใช้ผ่าน QR-Code</h6>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/qr-code.png" alt="" style="width: 200px; height: 200px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">สแกน QR-Code เพื่อเข้าใช้บริการ</h6>
                                    </div>
                                    <span>กรุณาสแกน QR-Code เพื่อบันทึกข้อมูลเข้าใช้บริการของคุณ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">ลงชื่อเข้าใช้บริการ (Self Service)</h6>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-center py-3">
                                <div class="attendance-container mb-3">
                                    <button id="capture-btn" class="btn btn-primary shadow-lg btn-circle-attendance" type="button">
                                        <div class="btn-content">
                                            <i class="fa fa-user-edit fa-2x mb-2"></i>
                                            <span>ลงชื่อเข้าใช้</span>
                                        </div>
                                    </button>
                                </div>
                                <p class="text-muted text-center small">คลิกปุ่มเพื่อกรอกข้อมูลการเข้าใช้บริการด้วยตนเอง</p>
                            </div>

                            <style>
                                .btn-circle-attendance {
                                    width: 200px;
                                    height: 200px;
                                    border-radius: 50% !important;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: bold;
                                    text-transform: uppercase;
                                    border: 6px solid rgba(255,255,255,0.5);
                                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                                    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                                }
                                .btn-circle-attendance:hover {
                                    transform: scale(1.1) rotate(5deg);
                                    box-shadow: 0 15px 30px rgba(0,123,255,0.4) !important;
                                    border-color: #fff;
                                }
                                .btn-content {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                }
                            </style>

                            <script>
                                document.getElementById('capture-btn').addEventListener('click', function() {
                                    window.location.href = 'ServiceForm.php';
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


            <br>
            <br>
            <br>

            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4" id="center-section">
                <h1>ข้อมูลศูนย์ดิจิทัลชุมชน</h1>
                <hr>
                <div class="row g-4">
                                    <div class="col-sm-12 col-md-6 col-xl-8">
                                        <div class="h-100 bg-light rounded p-4">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="mb-0">ข้อมูลศูนย์ดิจิทัลชุมชน</h6>
                                                <form class="d-flex gap-2" action="" method="POST" id="searchForm">
                                                <div class="d-flex gap-2">
                                                    <select id="provinceSelect" name="provinceSelect" class="form-select form-select-sm" style="width: auto;">
                                                        <option value="">-- เลือกจังหวัด --</option>
                                                        <?php $GetSite = $conn->query("SELECT * FROM `Site_tb` GROUP BY Site_Province");
                                                        while($row = $GetSite->fetch_assoc()){
                                                            $province = $row['Site_Province'];
                                                            echo "<option value='$province'>$province</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <button type="submit" name="searchBtn" class="btn btn-sm btn-primary" id="searchBtn">ค้นหา</button>
                                                </div>
                                                </form>
                                            </div>
                                            <div id="map" style="width: 100%; height: 400px; border-radius: 5px;"></div>
                                        </div>
                                    </div>
                                    <?php 
                                        if(isset($_POST['searchBtn'])){
                                            $selectedProvince = $_POST['provinceSelect'];
                                            $GetSite = $conn->query("SELECT * FROM `Site_tb` WHERE Site_Province = '$selectedProvince'");
                                            $Result = [];
                                            while($row = $GetSite->fetch_assoc()){
                                                
                                                $latlong = $row['Site_latLong'];
                                                $Getlatlong = explode('-',$latlong);
                                                $lat = $Getlatlong[0];
                                                $long = $Getlatlong[2];
                                                $Result[] = [
                                                    'name' => $row['Site_Name'],
                                                    'lat' => $lat,
                                                    'long' => $long
                                                ];

                                                                                         



                                                // <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                                                // <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                                                // <script>
                                                //     var map = L.map('map').setView([13.7563, 100.5018], 6);
                                                //     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                //         attribution: '© OpenStreetMap contributors'
                                                //     }).addTo(map);

                                                //     // 10 markers in Yannawa district (13.71-13.73, 100.49-100.51)
                                                //     var markers = [
                                                //         {lat: 13.7150, lng: 100.4950, name: 'ศูนย์ 1'},
                                                //         {lat: 13.7165, lng: 100.4980, name: 'ศูนย์ 2'},
                                                //         {lat: 13.7180, lng: 100.5010, name: 'ศูนย์ 3'},
                                                //         {lat: 13.7195, lng: 100.5030, name: 'ศูนย์ 4'},
                                                //         {lat: 13.7210, lng: 100.4970, name: 'ศูนย์ 5'},
                                                //         {lat: 13.7225, lng: 100.5000, name: 'ศูนย์ 6'},
                                                //         {lat: 13.7240, lng: 100.5020, name: 'ศูนย์ 7'},
                                                //         {lat: 13.7255, lng: 100.4960, name: 'ศูนย์ 8'},
                                                //         {lat: 13.7270, lng: 100.4990, name: 'ศูนย์ 9'},
                                                //         {lat: 13.7285, lng: 100.5010, name: 'ศูนย์ 10'}
                                                //     ];

                                                //     markers.forEach(function(markerData) {
                                                //         L.marker([markerData.lat, markerData.lng]).addTo(map)
                                                //             .bindPopup(markerData.name);
                                                //     });

                                                //     document.getElementById('searchBtn').addEventListener('click', function() {
                                                //         var selectedValue = document.getElementById('provinceSelect').value;
                                                //         if (selectedValue) {
                                                //             var coords = selectedValue.split(',');
                                                //             var lat = parseFloat(coords[0]);
                                                //             var lng = parseFloat(coords[1]);
                                                //             var zoom = parseInt(coords[2]);
                                                //             map.setView([lat, lng], zoom);
                                                //         }
                                                //     });
                                                // </script>
                                            }
                                            
                                        }

                                    ?>

                                    
                    
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">แสดงรายการที่ค้นหา</h6>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">ศูนย์ 1</h6>
                                    </div>
                                    <p class="mb-1">กรุงเทพมหานคร</p>
                                    <small>แขวงปทุมวัน</small>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-12">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">แสดงรายการที่ค้นหา</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" align="center">ลำดับ</th>
                                            <th scope="col">ชื่อศูนย์ดิจิทัลชุมชน</th>
                                            <th scope="col">ตำบล</th>
                                            <th scope="col">อำเภอ</th>
                                            <th scope="col">จังหวัด</th>
                                            <th scope="col">พิกัด</th>
                                        </tr>
                                    </thead>
                                    <?php 

                                    $ShowSite = $conn->query("SELECT * FROM `Site_tb` where Site_Province = '$selectedProvince' ORDER BY Site_ID ASC");
                                    while($row = $ShowSite->fetch_assoc()){
                                        $Site_ID = $row['Site_ID'];
                                        $Site_Name = $row['Site_Name'];
                                        $Site_Province = $row['Site_Province'];
                                        $Site_District = $row['Site_District'];
                                        $Site_SubDistrict = $row['Site_Subdistrict'];
                                        $Site_LatLong = $row['Site_latLong'];

                                        $Getlatlong = explode('-',$Site_LatLong);
                                        $lat1 = $Getlatlong[0]+0.001;
                                        $lat2 = $Getlatlong[1]+0.001;
                                        $long1 = $Getlatlong[2]+0.001;
                                        $long2 = $Getlatlong[3]+0.001;
                                        if($lat1 == $lat2){$lat=$lat1-0.001;}
                                        else{$lat=$lat1;}

                                        if($long1 == $long2){$long=$long1-0.001;}
                                        else{$long=$long1;}
                                        $LatLong = $lat.','.$long ;

                                            echo "
                                                <tbody>
                                                    <tr>
                                                        <td align='center'>$Site_ID</td>
                                                        <td>$Site_Name</td>
                                                        <td>$Site_SubDistrict</td>
                                                        <td>$Site_District</td>
                                                        <td>$Site_Province</td>
                                                        <td><a href='https://maps.google.com/maps?q=$LatLong' target='_blank' class='btn btn-sm btn-info'>Google Maps</a></td>
                                                    </tr>
                                                </tbody>
                                            ";
                                        }
                                        if($ShowSite->num_rows == 0){
                                            echo "
                                                <tbody>
                                                    <tr>
                                                        <td colspan='4' align='center'>ไม่มีข้อมูล</td>
                                                    </tr>
                                                </tbody>
                                            ";
                                        }  
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


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