<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBank</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="site-wrap">

  <header class="site-navbar js-sticky-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-xl-2">
          <h1 class="mb-0 site-logo"><a href="index.php" class="h2 mb-0">MyBank<span class="text-primary">.</span></a></h1>
        </div>
      </div>
    </div>
  </header>

  <?php
  session_start();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Establish a database connection (replace with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Add your actual database password
    $dbname = "mybank";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL query
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      // Successful authentication
      $_SESSION["email"] = $email; // Store user data in the session if needed
      header("Location: user.php"); // Redirect to index.php
      exit();
    } else {
      // Failed authentication
      $error_message = "Invalid email or password. Please try again.";
    }

    $conn->close();
  }
  ?>

  <div class="site-blocks-cover overlay" style="background-image: url(images/hero_2.jpg);">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-10 mt-lg-5 text-center">
          <form method="POST" action="">
            <div class="row">
              <div class="form-group col-lg-12">
                <label>Email Address</label>
                <input type="email" id="email" name="email" maxlength="25" class="form-control">
              </div>
              <div class="form-group col-lg-12">
                <label>Password</label>
                <input type="password" id="password" name="password" maxlength="10" class="form-control">
              </div>
              <div class="form-group col-lg-12">
                <button type="submit" id="login" class="btn btn-outline-light">Login</button>
              </div>
              <?php
      if (isset($error_message)) {
        echo '<div class="form-group col-lg-12">
               <p class="text-danger">' . $error_message . '</p>
             </div>';
      }
      ?>
            </div>
          </form>
          <div class="form-group col-lg-12">
            <a href="register.php"><button type="button" class="btn btn-dark">New User? Register here</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <p>Copyright &copy; MyBank - 2010</p>
        </div>
      </div>
    </div>
  </footer>

</div> <!-- .site-wrap -->

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
