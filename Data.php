<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Dữ liệu hoạt động</title>
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
    
      <!--   #c4ytable {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 70%;
            margin : 0px auto;
        }

        #c4ytable td, #c4ytable th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #c4ytable tr:nth-child(even){background-color: #f2f2f2;}

        #c4ytable tr:hover {background-color: #ddd;}

        #c4ytable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #00A8A9;
            color: white;
        } -->

<style>
   #table_filter
   {
       margin-bottom: 20px;
       width: 500px;
   }
   label input{
       width: 250px;
       height: 25px;
   }

   .col-md-12{
      width:1000px;
      margin: 0px auto;
   }
   .card-title{
        text-align: center;
        color: #284F8F;
        margin-top: 20px;
        margin-bottom: 20px;
        border: 2px solid #ff6a00;
        padding: 10px;
        border-radius: 10px;
        display: block;   
   }
   #table tr:nth-child(even){background-color: #f2f2f2;}

   #table tr:hover {background-color: #ddd;}
   #table td, #table th {
            border: 1px solid #ddd;
            padding: 9px;
            text-align: center;
        }
</style>
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
               dom: 'frtip'

            });
        });
    </script>

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

            <!-- moniter data-->
            <div class="col-md-12">        
         <div class="card card-success">
              <div class="card-header">
                <h2 class="card-title">MOTOR PARAMETER DATA STORAGE TABLE</h2>             
              </div>            
                <div class="card-body">
                  <div class="row">
                     <div class="col-md-12">
                <table id="table" class="table table-bordered table-hover"> 
                               
                    <thead style="background:#A4D8F9;">
          <tr>
                            <td>ID</td>
                            <td>VOLTAGE</td>
                            <td>AMPE</td>
                            <td>FREQUENCY</td>
                            <td>RPM</td>
                            <td>ALARM</td> 
                            <td>TIMEUPDATE</td>                                         
                        </tr>
                    </thead>
                    <tbody>

              <?php 
              
               //include_once "php/connect.php";
               //include_once "php/getData.php";
               //$data=getdata();
              // echo var_dump ($data);
              $conn = mysqli_connect('localhost','root','','esp32_cb');
                if (!$conn) {
                  die('Could not connect to database ' . mysqli_error($conn));
                }

                //Fetch the data from tables
                $sql="SELECT * FROM esp32_inverter ORDER BY id DESC";

                if ($result=mysqli_query($conn,$sql))
                  {
                  // Fetch one and one row
                //  echo "<TABLE id='c4ytable'>";
                 // echo "<TR><TH>ID</TH><TH>VOLTAGE</TH><TH>AMPE</TH><TH>FREQUENCY</TH><TH>RPM</TH><TH>TIME</TH><TH>DATE</TH></TR>";
                  while ($row=mysqli_fetch_row($result))
                  {
                    echo "<TR>";
                    echo "<TD>".$row[0]."</TD>";
                    echo "<TD>".$row[1]."</TD>";
                    echo "<TD>".$row[2]."</TD>";
                    echo "<TD>".$row[3]."</TD>";
                    echo "<TD>".$row[4]."</TD>";
                    echo "<TD>".$row[5]."</TD>"; 
                    echo "<TD>".$row[6]."</TD>"; 
                    echo "</TR>";
                  }
                  echo "</TABLE>";
                  // Free result set
                  mysqli_free_result($result);
                            }

            mysqli_close($conn);

                 ?>
                </tbody>
                        </table>
                    </div>
                      </div>       
                        </div>            
                        </div> 
                         </div>

            <!-- end main-content -->
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