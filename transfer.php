<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transfer Money - MyBank</title>
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
    header("Location: index.php");
    exit();
  }

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

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipientEmail = $_POST["recipient_email"];
    $amount = $_POST["amount"];

    // Retrieve sender's balance from the database
    $senderQuery = "SELECT * FROM users WHERE email = '$email'";
    $senderResult = $conn->query($senderQuery);

    if ($senderResult->num_rows > 0) {
      $senderRow = $senderResult->fetch_assoc();
      $senderBalance = $senderRow["balance"];

      if ($senderBalance >= $amount) {
        // Update sender's balance
        $newSenderBalance = $senderBalance - $amount;
        $updateSenderQuery = "UPDATE users SET balance = '$newSenderBalance' WHERE email = '$email'";
        $conn->query($updateSenderQuery);

        // Update recipient's balance
        $recipientQuery = "SELECT * FROM users WHERE email = '$recipientEmail'";
        $recipientResult = $conn->query($recipientQuery);

        if ($recipientResult->num_rows > 0) {
          $recipientRow = $recipientResult->fetch_assoc();
          $recipientBalance = $recipientRow["balance"];
          $newRecipientBalance = $recipientBalance + $amount;
          $updateRecipientQuery = "UPDATE users SET balance = '$newRecipientBalance' WHERE email = '$recipientEmail'";
          $conn->query($updateRecipientQuery);

          $successMessage = "Money transferred successfully!";
        } else {
          $errorMessage = "Recipient not found.";
        }
      } else {
        $errorMessage = "Insufficient balance.";
      }
    }
  }

  $conn->close();
  ?>

  <div class="site-blocks-cover overlay" style="background-image: url(images/hero_2.jpg);">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-10 mt-lg-5 text-center">
          <h2>Transfer Money</h2>
          <?php
          if (isset($errorMessage)) {
            echo '<p class="text-danger">' . $errorMessage . '</p>';
          }
          if (isset($successMessage)) {
            echo '<p class="text-success">' . $successMessage . '</p>';
          }
          ?>
          <form method="POST" action="">
            <div class="row">
              <div class="form-group col-lg-12">
                <label>Recipient Email Address</label>
                <input type="email" id="recipient_email" name="recipient_email" class="form-control" required>
              </div>
              <div class="form-group col-lg-12">
                <label>Amount</label>
                <input type="number" id="amount" name="amount" class="form-control" min="0.01" step="0.01" required>
              </div>
              <div class="form-group col-lg-12">
                <button type="submit" class="btn btn-outline-primary">Transfer</button>
              </div>
            </div>
          </form>
          <br>
          <a href="user.php" class="btn btn-primary">Back</a>
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
