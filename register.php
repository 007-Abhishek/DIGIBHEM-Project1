<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/jquery.fancybox.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    <title>MyBank</title>
</head>
<body class="site-blocks-cover overlay" style="background-image: url(images/hero_2.jpg);">
<?php
$servername = "localhost";
$username = "root";
$dbname = "mybank";

$name = $fname = $account_number = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || !preg_match('/^[a-zA-Z\s]{3,}$/', $_POST["name"])) {
        echo "<span class=\"error\" style=\"color: red;\">Error: Invalid Name</span>";
    } 
    else if (empty($_POST["fname"]) || !preg_match('/^[a-zA-Z\s]{3,}$/', $_POST["fname"])) {
        echo "<span class=\"error\" style=\"color: red;\">Error: Invalid Father's Name</span>";
    } 
    else if (empty($_POST["account_number"])) {
      echo "<span class=\"error\" style=\"color: red;\">Error:Account number Required</span>";
    } 
    elseif (!preg_match('/^\d{14}$/', $_POST["account_number"])) {
        echo "<span class=\"error\" style=\"color: red;\">Error: Account number must be a 14-digit number</span>";
    } 
    else if (empty($_POST["email"])) {
      echo "<span class=\"error\" style=\"color: red;\">Error:Email Required</span>";
    } 
    else if (empty($_POST["password"])) {
      echo "<span class=\"error\" style=\"color: red;\">Error:Password Required</span>";
    } 
    else if (strlen($_POST["password"])<5) {
        echo "<span class=\"error\" style=\"color: red;\">Error:Password must be atleast 5 characters</span>";
    } 
    else {
        $name = val($_POST["name"]);
        $fname = val($_POST["fname"]);
        $account_number = val($_POST["account_number"]);
        $email = val($_POST["email"]);
        $password = val($_POST["password"]);

        // Create connection
        $conn = new mysqli($servername, $username, '', $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data into the database
        $sql_check_account = "SELECT account_number FROM users WHERE account_number = '$account_number'";
        $result = $conn->query($sql_check_account);

        if ($result->num_rows > 0) {
            echo "Error: Account number already exists!";
        } else {
            $sql = "INSERT INTO users (name, fname, account_number, email, password) VALUES ('$name', '$fname', '$account_number', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "Data saved successfully!";
                header("Location: login.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
}

function val($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
?>
    <div>
        <hr>
        <h1 class="mb-0 site-logo"><a href="index.php" class="h2 mb-0">MyBank<span class="text-primary">.</span></a></h1>
        <hr>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table class="table table-success table-striped-columns table-hover" class="site-blocks-cover overlay">
            <tr>
                <div class="form-group col-lg-12">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" maxlength="25" class="form-control">
                </div>
            </tr>
            <tr>
                <div class="form-group col-lg-12">
                    <label for="fname">Fathers Name</label>
                    <input type="text" id="fname" name="fname" maxlength="25" class="form-control">
                </div>
            </tr>
            <tr>
                <div class="form-group col-lg-12">
                    <label for="account_number">Account Number</label>
                    <input type="number" id="account_number" name="account_number" maxlength="25" class="form-control">
                </div>
            </tr>
            <tr>
                <div class="form-group col-lg-12">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" maxlength="25" class="form-control">
                </div>
            </tr>
            <tr>
                <div class="form-group col-lg-12">
                    <label for="password">Password</label>
                    <input type="text" id="password" name="password" maxlength="25" class="form-control">
                </div>
            </tr>
            <tr>
                <div class="form-group col-lg-12">
                    <button type="submit" class="btn btn-dark">Register</button>
                </div>
            </tr>
        </table>
    </form>
</body>
</html>
