<?php
//Creates new record as per request
    //Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "esp32_cb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
  
   //if(!empty($_POST['voltage']) && !empty($_POST['ampe']) && !empty($_POST['frequency']) && !empty($_POST['rpm']))
   if(!empty($_POST['voltage']) && !empty($_POST['ampe']))
    {
       // $id = $_POST['id'];
    	$voltage = $_POST['voltage'];
    	$ampe = $_POST['ampe'];
        $frequency = $_POST['frequency'];
        $rpm = $_POST['rpm'];
    	$alarm = $_POST['alarm'];
        //$timeupdate = $_POST['timeupdate'];

	    $sql = "INSERT INTO esp32_inverter (voltage, ampe, frequency, rpm ,alarm)
		
		VALUES ('".$voltage."', '".$ampe."', '".$frequency."', '".$rpm."', '".$alarm."')";

		if ($conn->query($sql) === TRUE) {
		    echo "Gửi dữ liệu thành công";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	$conn->close();
?>