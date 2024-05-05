// Khai báo kết nối với firebase
var firebaseConfig = {
    apiKey: "AIzaSyBpeYSvFKN8PmcWBpav9i7lY_KFhysh3Bw",
    authDomain: "esp32-led-c7072.firebaseapp.com",
    databaseURL: "https://esp32-led-c7072-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "esp32-led-c7072",
    storageBucket: "esp32-led-c7072.appspot.com",
    messagingSenderId: "691617982485",
    appId: "1:691617982485:web:3ced77ac5851487f79861c"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

var database = firebase.database();

//******************************************* */
// đưa dữ liệu từ firebase lên web
/* Voltage data*/
database.ref("/voltage").on("value", function (snapshot) {
    var voltage = snapshot.val();
    document.getElementById("voltage-id").innerHTML = voltage + " " + "(V)";
});

/* Ampe data*/
database.ref("/ampe").on("value", function (snapshot) {
    var ampe = snapshot.val();
    document.getElementById("ampe-id").innerHTML = ampe + " " + "(A)";
});

/* Frequency data*/
database.ref("/frequency").on("value", function (snapshot) {
    var frequency = snapshot.val();
    document.getElementById("fre-id").innerHTML = frequency + " " + "(Hz)";
});

/* Frequency inverter data*/
database.ref("/frequency").on("value", function (snapshot) {
    var freInverter = snapshot.val();
    document.getElementById("fre-inverter-id").innerHTML = freInverter ;
});

/* Rpm data*/
database.ref("/rpm").on("value", function (snapshot) {
    var rpm = snapshot.val();
    document.getElementById("rpm-id").innerHTML = rpm + " " + "(v/p)";
});

/* Alarm data*/
database.ref("alarm").on("value", function (snapshot) {
    var alarm = snapshot.val();
    document.getElementById("Alarm-Display").innerHTML = alarm;
    if (alarm !== '0.0') {
        var warningBox = document.createElement('div');
        warningBox.classList.add('warning-box');
        warningBox.style.display = 'block';

        var warningIcon = document.createElement('span');
        warningIcon.classList.add('warning-icon');
        warningIcon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>'; // Set the icon content

        var warningHeading = document.createElement('h1');
        warningHeading.classList.add('warning-heading');
        warningHeading.textContent = 'WARNING!'; // Set the heading text

        var warningMessage = document.createElement('p');
        warningMessage.classList.add('warning-message');
        warningMessage.textContent = "Your inverter has tripped. Let's check!"; // Set the message text

        // Add the elements to the warningBox
        warningBox.appendChild(warningIcon);
        warningBox.appendChild(warningHeading);
        warningBox.appendChild(warningMessage);

        // Append warningBox to the document body
        document.body.appendChild(warningBox);
    }
});

//************************************************************************/
// gửi dữ liệu từ web về firebase

/* Operation mode */

var btnAuto = document.getElementById("button_auto");
var btnMan = document.getElementById("button_man");
/* Chế độ Auto*/
btnAuto.onclick = function () {
    document.getElementById("button_auto").style.backgroundColor = "#FFDFB7"; 
    document.getElementById("button_man").style.backgroundColor = "#E5E5E5"; 
    document.getElementById("man-signal").style.display = "none";
    database.ref("/Write").update({
        "mode": 1
    });
}
/* Khi load trang lại vẫn hiển thị button sáng*/
database.ref("/Write/mode").on("value", function (snapshot) {
    var mode = snapshot.val();
    if (mode == 1) {
        document.getElementById("button_auto").style.backgroundColor = "#FFDFB7";
        document.getElementById("button_man").style.backgroundColor = "#E5E5E5";
        document.getElementById("man-signal").style.display = "none";
    }
    else if (mode == 0){
        document.getElementById("button_man").style.backgroundColor = "#FFDFB7";
        document.getElementById("button_auto").style.backgroundColor = "#E5E5E5";
        document.getElementById("man-signal").style.display = "block";
    }
});

/* Chế độ Man */
btnMan.onclick = function () {
    document.getElementById("button_man").style.backgroundColor = "#FFDFB7";
    document.getElementById("button_auto").style.backgroundColor = "#E5E5E5";
    document.getElementById("man-signal").style.display = "block";
    database.ref("/Write").update({
        "mode": 0
    });
}

/*************************************************************************************/
/* Operation status */

var btnRun = document.getElementById("button_run");
var btnStop = document.getElementById("button_stop");
/* Trạng thái ON*/
btnRun.onclick = function () {
    document.getElementById("button_run").style.backgroundColor = "#71BC68";
    document.getElementById("button_stop").style.backgroundColor = "#E5E5E5";
    document.getElementById("run-signal").style.display = "block";
    document.getElementById("pwr-signal").style.display = "none";
    document.getElementById("Status-Keyword").textContent = "RUNNING";
    document.getElementById("Status-Keyword").style.backgroundColor = "#71BC68";
    database.ref("/Write").update({
        "status": 1
    });
}
/* Trạng thái OFF*/
btnStop.onclick = function () {
    document.getElementById("button_stop").style.backgroundColor = "#FF160C";
    document.getElementById("button_run").style.backgroundColor = "#E5E5E5";
    document.getElementById("pwr-signal").style.display = "block";
    document.getElementById("run-signal").style.display = "none";
    document.getElementById("Status-Keyword").textContent = "STOPPING";
    document.getElementById("Status-Keyword").style.backgroundColor = "#FF160C";
    database.ref("/Write").update({
        "status": 0
    });
}
/* Khi load trang lại vẫn hiển thị button sáng*/
database.ref("/Write/status").on("value", function (snapshot) {
    var status = snapshot.val();
    if (status == 1) {
        document.getElementById("button_run").style.backgroundColor = "#71BC68";
        document.getElementById("button_stop").style.backgroundColor = "#E5E5E5";
        document.getElementById("run-signal").style.display = "block";
        document.getElementById("pwr-signal").style.display = "none";
        document.getElementById("Status-Keyword").textContent = "RUNNING";
        document.getElementById("Status-Keyword").style.backgroundColor = "#71BC68";
    }
    else if (status == 0) {
        document.getElementById("button_stop").style.backgroundColor = "#FF160C";
        document.getElementById("button_run").style.backgroundColor = "#E5E5E5";
        document.getElementById("pwr-signal").style.display = "block";
        document.getElementById("run-signal").style.display = "none";
        document.getElementById("Status-Keyword").textContent = "STOPPING";
        document.getElementById("Status-Keyword").style.backgroundColor = "#FF160C";
    }
});
/***************************************************************************************** */
/* Motor Direction */

var btnFor = document.getElementById("button_thuan");
var btnRev = document.getElementById("button_nghich");
/* Chế độ chạy thuận */
btnRev.onclick = function () {
    document.getElementById("button_nghich").style.backgroundColor = "#FFDFB7";
    document.getElementById("button_thuan").style.backgroundColor = "#E5E5E5";

    database.ref("/Write").update({
        "direction": 1
    });
}
/* Chế độ chạy nghịch */
btnFor.onclick = function () {
    document.getElementById("button_thuan").style.backgroundColor = "#FFDFB7";
    document.getElementById("button_nghich").style.backgroundColor = "#E5E5E5";

    database.ref("/Write").update({
        "direction": 0
    });
}
/* Khi load trang lại vẫn hiển thị button sáng*/
database.ref("/Write/direction").on("value", function (snapshot) {
    var direction = snapshot.val();
    if (direction == 1) {
        document.getElementById("button_nghich").style.backgroundColor = "#FFDFB7";
        document.getElementById("button_thuan").style.backgroundColor = "#E5E5E5";
    }
    else if (direction == 0) {
        document.getElementById("button_thuan").style.backgroundColor = "#FFDFB7";
        document.getElementById("button_nghich").style.backgroundColor = "#E5E5E5";
    }
});
/*********************************************************************************************/
/* Write cài đặt tần số gửi lên firebase */
//var setHzInput = document.getElementById("set-hz");
//var btnSetHz = document.getElementById("button_tanso");
///* Set tần số hoạt động*/
//btnSetHz.onclick = function () {
//    var GiaTriHz = Number(setHzInput.value);
//    database.ref("/Write").update({
//        "setHz": GiaTriHz
//    });
//    btnSetHz.style.backgroundColor = "#71BC68";
//    setTimeout(function () {
//        btnSetHz.style.backgroundColor = "#E5E5E5";
//    }, 200);
//}
var setHzInput = document.getElementById("set-hz");
var btnSetHz = document.getElementById("button_tanso");

/* Set tần số hoạt động*/
btnSetHz.onclick = function () {
    // Lấy giá trị từ trường nhập
    var giaTriChuoi = setHzInput.value;

    // Kiểm tra nếu giá trị là một số hoặc có thể chuyển đổi thành số
    if (!isNaN(giaTriChuoi)) {
        // Chuyển đổi giá trị thành số
        var GiaTriHz = Number(giaTriChuoi);

        // Gửi giá trị lên Firebase
        database.ref("/Write").update({
            "setHz": GiaTriHz
        });

        // Giao diện người dùng (nếu cần)
        btnSetHz.style.backgroundColor = "#71BC68";
        setTimeout(function () {
            btnSetHz.style.backgroundColor = "#E5E5E5";
        }, 200);
    } else {
        // Xử lý lỗi nếu giá trị không phải là số
        alert("Vui lòng nhập một giá trị số hợp lệ!");
    }
};

/* Set tần số max */

var setHzmax = document.getElementById("set-hz-max");
var btnSetHzmax = document.getElementById("button_max");

btnSetHzmax.onclick = function () {
    var GiaTriHzmax = parseInt(setHzmax.value);
    database.ref("/Write").update({
        "setHz-max": GiaTriHzmax
    });
    btnSetHzmax.style.backgroundColor = "#71BC68";
    setTimeout(function () {
        btnSetHzmax.style.backgroundColor = "#E5E5E5";
    }, 200);
}

