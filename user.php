<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to MyBank</title>
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

  // Check if the user is logged in, otherwise redirect to login page
  if (!isset($_SESSION["email"])) {
    header("Location: index.html");
    exit();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_destroy(); // Destroy all session data
    header("Location: index.html");
    exit();
  }

  // Retrieve user information from the database based on the stored email
  $email = $_SESSION["email"];

  // Replace with your database credentials
  $servername = "localhost";
  $username = "root";
  $password_db = ""; // Add your actual database password
  $dbname = "mybank";

  $conn = new mysqli($servername, $username, $password_db, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $query = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userName = $row["name"];
    $accountNumber = $row["account_number"];
  }

  $conn->close();
  ?>

  <div class="site-blocks-cover overlay" style="background-image: url(images/hero_2.jpg);">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-10 mt-lg-5 text-center">
          <h2>Welcome, <?php echo $userName; ?></h2>
          <p>Account Number: <?php echo $accountNumber; ?></p>
          <div>
            <a href="balance.php" class="btn btn-primary">Check Balance</a>
            <a href="transfer.php" class="btn btn-primary">Transfer Money</a>
          </div>
          <br>
          <form method="POST" action="">
            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
          </form>
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
