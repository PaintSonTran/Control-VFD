<?php
# Initialize session
session_start();

# Check if user is already logged in, If yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE) {
  echo "<script>" . "window.location.href='Trangchu.html'" . "</script>";
  exit;
}

# Include connection
//require_once "./config.php";
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "esp32_cb");

# Connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

# Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
# Define variables and initialize with empty values
$user_login_err = $user_password_err = $login_err = "";
$user_login = $user_password = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["user_login"]))) {
    $user_login_err = "Please enter your username or an email id.";
  } else {
    $user_login = trim($_POST["user_login"]);
  }

  if (empty(trim($_POST["user_password"]))) {
    $user_password_err = "Please enter your password.";
  } else {
    $user_password = trim($_POST["user_password"]);
  }

  # Validate credentials 
  if (empty($user_login_err) && empty($user_password_err)) {
    # Prepare a select statement
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      # Bind variables to the statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_user_login, $param_user_login);

      # Set parameters
      $param_user_login = $user_login;

      # Execute the statement
      if (mysqli_stmt_execute($stmt)) {
        # Store result
        mysqli_stmt_store_result($stmt);

        # Check if user exists, If yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          # Bind values in result to variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            # Check if password is correct
            if (password_verify($user_password, $hashed_password)) {

              # Store data in session variables
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["loggedin"] = TRUE;

              # Redirect user to index page
              echo "<script>" . "window.location.href='Trangchu.html'" . "</script>";
              exit;
            } else {
              # If password is incorrect show an error message
              $login_err = "The email or password you entered is incorrect.";
            }
          }
        } else {
          # If user doesn't exists show an error message
          $login_err = "Invalid username or password.";
        }
      } else {
        echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php'" . "</script>";
        exit;
      }

      # Close statement
      mysqli_stmt_close($stmt);
    }
  }

  # Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>User login system</title>
  <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
  <script defer src="javascript/script.js"></script> 
 <!--<script>
  // Toggle password visibility
    const userPasswordEl = document.querySelector("#password");
    const togglePasswordEl = document.querySelector("#togglePassword");

    togglePasswordEl.addEventListener("click", function () {
      if (this.checked === true) {
        userPasswordEl.setAttribute("type", "text");
      } else {
        userPasswordEl.setAttribute("type", "password");
      }
    });
</script>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@400;500;600;700&display=swap");

    body {
      font-family: "Barlow Semi Condensed", sans-serif;
    }

    .alert {
      padding: 0.5rem;
    }

    .form-wrap h1,
    .form-wrap .form-label {
      font-weight: 600;
    }
</style>-->
 <style>
        body {
            background: url('img/spkt_baner.jpg') top;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .form-wrap{                 
            background-color: rgba(255, 255, 255, 0.8); /* Màu nền hộp */           
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);   
        }
         #iconImageTK {
            width: 35px;
            height: 35px;
            margin-right: 5px; /* Giảm khoảng cách giữa hình và ô nhập liệu */
            margin-bottom: 3px;
        }
        #iconImageMK {
            width: 30px;
            height: 30px;
            margin-right: 10px; /* Giảm khoảng cách giữa hình và ô nhập liệu */
            margin-bottom: 5px;
        }
 </style>
</head>

<body>
  <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
      <div class="col-lg-5">
        <?php
        if (!empty($login_err)) {
          echo "<div class='alert alert-danger'>" . $login_err . "</div>";
        }
        ?>
        <div class="form-wrap border rounded p-4">
          <h1 style="text-align: center;">Log In</h1>
          <p style="text-align: center;">Please login to continue</p>
          <!-- form starts here -->
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
              <img src="img/icon_dn.png" id="iconImageTK">
              <label for="user_login" class="form-label">Email or username</label>
              <input type="text" class="form-control" placeholder="Email or username:" name="user_login" id="user_login" value="<?= $user_login; ?>">
              <small class="text-danger"><?= $user_login_err; ?></small>
            </div>
            <div class="mb-2">
              <img src="img/icon_mk.png" id="iconImageMK">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" placeholder="Password:" name="user_password" id="password">
              <small class="text-danger"><?= $user_password_err; ?></small>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="togglePassword">
              <label for="togglePassword" class="form-check-label">Show Password</label>
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Log In">
            </div>
            <p class="mb-0">Don't have an account ? <a href="register.php">Sign Up</a></p>
          </form>
          <!-- form ends here -->
        </div>
      </div>
    </div>



  </div>
</body>

</html>