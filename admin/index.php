<?php 
session_start();

if(isset($_SESSION['auth'])) {
    if($_SESSION['auth'] == 1) {
        header("Location: dashboard.php");
        exit();
    }
}

include "config/db.php";

if (isset($_POST['login'])) { // Corrected this line to match the button name
    $username = $_POST['username'];
    $pass = $_POST['password']; // No need to wrap in brackets unless hashing

    echo $username;
    echo $pass;

    // Ensure to escape inputs or use prepared statements to avoid SQL injection
    $username = $conn->real_escape_string($username);
    $pass = $conn->real_escape_string($pass);

    $loginquery = "SELECT * FROM admins WHERE username='$username' AND password='$pass'";
    $loginres = $conn->query($loginquery);

    echo $loginres->num_rows;

    if ($loginres->num_rows > 0) {
        while ($result = $loginres->fetch_assoc()) {
            $username = $result['username'];
        }

        $_SESSION['username'] = $username;
        $_SESSION['auth'] = 1;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JOSHIANA | 13.0</title>
    <!--css file-->
    <link rel="stylesheet" href="css/login.css">
    <style>
      ::placeholder{
        font-family: none;
      }
    </style>
</head>
<body>
    <section class="container-reg">
        <h4>JOSHIANA <sup>13.0</sup></h4>
        <header>Login Form</header>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form">
            <div class="column">
                <div class="input-box">
                    <input type="text" placeholder="Enter username" name="username" required />
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Enter Password" name="password" required />
                </div>
            </div>
            <button name="login">Login</button>
        </form>
    </section>
</body>
</html>
