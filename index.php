<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <p>
      <div class="container">
        <div class="box form-box">
            <?php 
                if(isset($_COOKIE['remember_me']) && isset($_COOKIE['remember_password'])){
                    $email = $_COOKIE['remember_me'];
                    $password = $_COOKIE['remember_password'];
                } else {
                    $email = '';
                    $password = '';
                }
             
             include("php/config.php");

             if(isset($_POST['submit'])){
                 $email = mysqli_real_escape_string($con,$_POST['email']);
                 $password = mysqli_real_escape_string($con,$_POST['password']);
             
                 $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                 $row = mysqli_fetch_assoc($result);
                 if(isset($_POST['remember-me']) && $_POST['remember-me'] == 'on'){
                    setcookie('remember_me', $_POST['email'], time() + 30 * 24 * 60 * 60); // 30 days
                    setcookie('remember_password', $_POST['password'], time() + 30 * 24 * 60 * 60); // 30 days
                 }
                 if(is_array($row) && !empty($row)){
                     $_SESSION['valid'] = $row['Email'];
                     $_SESSION['username'] = $row['Username']; // Store username in session
                     $_SESSION['age'] = $row['Age'];
                     $_SESSION['id'] = $row['Id'];
                     header("Location: homepage.php");
                     exit(); // Ensure no further code is executed
                 } else {
                     echo "<div class='message'>
                           <p>Wrong Username or Password</p>
                           </div> <br>";
                     echo "<a href='index.php'><button class='btn'>Go Back</button>";
                 }
             } else {

            
            ?>
            <header>Login</header>
            <form action="" method="post">
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" value="<?php echo $email; ?>" required>
            </div>

            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="off" value="<?php echo $password; ?>" required>
            </div>

                <div class="field">
                    <p><input type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me">Remember Me</label></p>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>