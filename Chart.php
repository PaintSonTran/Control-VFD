<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Biểu đồ</title>
    <link href="css/main.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script>
     $(document).ready(function () {
         $(window).scroll(function () {
             if ($(this).scrollTop()) {
                 $('header').addClass('sticky');
             } else {
                 $('header').removeClass('sticky');
             }
         });
     });
    </script>
    <script>
     $(document).ready(function () {
         // Lấy đường dẫn trang hiện tại
         var currentPath = window.location.pathname;

         // Nếu đường dẫn kết thúc bằng '/' (ví dụ: "/Trangchu.html"), loại bỏ '/'
         if (currentPath.slice(-1) === '/') {
             currentPath = currentPath.slice(0, -1);
         }

         // Lấy tất cả các mục menu
         var menuItems = $('#main-menu li a');

         // Xác định mục menu tương ứng với trang hiện tại và thêm lớp 'active'
         menuItems.each(function () {
             var href = $(this).attr('href');

             // Kiểm tra xem href của mục menu có phù hợp với đường dẫn hiện tại hay không
             if (currentPath.endsWith(href)) {
                 // Thêm lớp 'active' cho mục menu tương ứng
                 $(this).addClass('active');
             }
         });
     });
    </script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
    h2 {
        text-align: center;
        color: #284F8F;
        border: 2px solid #ff6a00;
        padding: 10px;
        border-radius: 10px;
        display: block; 
        width:800px;
        margin-top: 30px;
        margin-left: 350px;
     }
     .chart {
        margin: 50px auto;
        max-width: 1000px;
        border: 2px solid #545851;
     }
    </style>
</head>
<body>
    <form id="form1" runat="server">
        <div id="wrapper">
            <header>
                <div class="inner-header container">
                    <a href="" id="logo">Đồ Án Tốt Nghiệp</a>
                    <nav>
                        <ul id="main-menu">
                            <li><a href="Trangchu.html"> Giới Thiệu </a></li>
                            <li><a href="Control.html"> Điều khiển & Giám Sát </a></li>
                            <li><a href="Data.php"> Dữ liệu </a></li>
                            <li><a href="Chart.php"> Biểu đồ </a></li>
                            <li><a href="logout.php"> Đăng Xuất </a></li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div id="banner">

            </div>
            <!-- end header -->
            <!-- Chart -->
                   <?php                  
             $conn = mysqli_connect('localhost','root','','esp32_cb');
             if (!$conn) {
             die('Could not connect to database ' . mysqli_error($conn));
             }

            $sql = "SELECT id, voltage, ampe, frequency, rpm, TimeStamp FROM esp32_inverter order by TimeStamp desc limit 40";

            $result = $conn->query($sql);

            while ($data = $result->fetch_assoc()){
                $sensor_data[] = $data;
            }

            $readings_time = array_column($sensor_data, 'TimeStamp');
            $voltage = json_encode(array_reverse(array_column($sensor_data, 'voltage')), JSON_NUMERIC_CHECK);
            $ampe = json_encode(array_reverse(array_column($sensor_data, 'ampe')), JSON_NUMERIC_CHECK);
            $frequency = json_encode(array_reverse(array_column($sensor_data, 'frequency')), JSON_NUMERIC_CHECK);
            $rpm = json_encode(array_reverse(array_column($sensor_data, 'rpm')), JSON_NUMERIC_CHECK);
            $reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);
                 ?>
                     <h2>CHART OF INVERTER PARAMETER</h2>
                    <div id="chart-voltage" class="chart"></div>
                    <div id="chart-ampe" class="chart"></div>
                    <div id="chart-frequency" class="chart"></div>
                    <div id="chart-rpm" class="chart"></div>
                <script>

                var voltage = <?php echo $voltage; ?>;
                var ampe = <?php echo $ampe; ?>;
                var frequency = <?php echo $frequency; ?>;
                var rpm = <?php echo $rpm; ?>;
                var reading_time = <?php echo $reading_time; ?>;
                // biểu đồ volatge
                var chartV = new Highcharts.Chart({
                  chart:{ renderTo : 'chart-voltage' },
                  title: { text: 'VOLTAGE CHART' , style: { color: '#F2B400', }  },
                  series: [{
                    showInLegend: false,
                    data: voltage
                  }],
                  plotOptions: {
                    line: { animation: false,
                      dataLabels: { enabled: true }
                    },
                    series: { color: '#059e8a' }
                  },
                  xAxis: { 
                    type: 'datetime',
                    categories: reading_time
                  },
                  yAxis: {
                    title: { text: 'Voltage (V)' }
                    //title: { text: 'Temperature (Fahrenheit)' }
                  },
                  credits: { enabled: false }
                });
                // biểu đồ ampe
                var chartA = new Highcharts.Chart({
                  chart:{ renderTo:'chart-ampe' },
                  title: { text: 'AMPE CHART', style: { color: '#B22B27', } },
                  series: [{
                    showInLegend: false,
                    data: ampe
                  }],
                  plotOptions: {
                    line: { animation: false,
                      dataLabels: { enabled: true }
                    }
                  },
                  xAxis: {
                    type: 'datetime',
                    //dateTimeLabelFormats: { second: '%H:%M:%S' },
                    categories: reading_time
                  },
                  yAxis: {
                    title: { text: 'Ampe (A)' }
                  },
                  credits: { enabled: false }
                });
                // biểu đồ frequency
                var chartF = new Highcharts.Chart({
                  chart:{ renderTo:'chart-frequency' },
                  title: { text: 'FREQUENCY CHART' , style: { color: '#574524', }  },
                  series: [{
                    showInLegend: false,
                    data: frequency
                  }],
                  plotOptions: {
                    line: { animation: false,
                      dataLabels: { enabled: true }
                    },
                    series: { color: '#18009c' }
                  },
                  xAxis: {
                    type: 'datetime',
                    categories: reading_time
                  },
                  yAxis: {
                    title: { text: 'Frequency (Hz)' }
                  },
                  credits: { enabled: false }
                });
                // biểu đồ rpm
                var chartR = new Highcharts.Chart({
                  chart:{ renderTo:'chart-rpm' },
                  title: { text: 'RPM CHART'  , style: { color: '#A908B5', } },
                  series: [{
                    showInLegend: false,
                    data: rpm
                  }],
                  plotOptions: {
                    line: { animation: false,
                      dataLabels: { enabled: true }
                    },
                    series: { color: '#CC7E5B' }
                  },
                  xAxis: {
                    type: 'datetime',
                    categories: reading_time
                  },
                  yAxis: {
                    title: { text: 'rpm (rpm)' }
                  },
                  credits: { enabled: false }
                });

                </script>
                <!-- End Chart -->
            <!-- fotter -->
            <div id="fotter">
                <div class="row">
                    <div class="col-md-3">
                        <p style="font-weight: bold; margin-left: 60px; font-size:20px; margin-top:10px;">Team Info</p>
                        <p style=" width: 200px; margin-left: 60px; margin-top: 10px;">
                            Trần Ngọc Sơn<br>
                            Huỳnh Dương Minh Hiếu<br>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p style="font-weight: bold; margin-left: 60px; font-size: 20px; margin-top: 10px;">Support</p>
                        <p style=" width: 200px; margin-left: 60px; margin-top: 10px;">
                            Hỗ trợ trực tuyến: 24/7<br>
                            0981738643
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p style="font-weight: bold; margin-left: 60px; font-size: 20px; margin-top: 10px; ">Contact Info</p>
                        <a href="https://www.facebook.com/ngocson.tran.562114/">
                            <img src="img/Facebook_Logo.png" alt="Logo Facebook" style="  margin-left: 50px; margin-top: 10px; height: 40px;">
                        </a>
                        <a href="https://zalo.me/g/hdspxr275">
                            <img src="img/Zalo_Logo.png" alt="Logo Zalo" style=" margin-left: 50px; margin-top: 10px; height: 40px;">
                        </a>
                    </div>
                </div>
            </div>
            <!-- end fotter -->
        </div>
    </form>
</body>
</html>