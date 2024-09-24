<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
           
            if (file_exists(__DIR__ . "/config.php")) {
                include(__DIR__ . "/config.php");
            } else {
                die("Error: config.php not found in " . __DIR__ . "/php/");
            }

            if (isset($_POST['submit'])) {
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                // Verifying the unique email
                $verify_query = mysqli_query($con, "SELECT email FROM admin_users WHERE email='$email'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                        <p>This email is already in use. Please try another one!</p>
                    </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } else {
                    $insert_query = mysqli_query($con, "INSERT INTO admin_users (username, email, password) VALUES ('$username', '$email', '$password')") or die("Error Occurred");

                    if ($insert_query) {
                        // Redirect to index.php after successful registration
                        header("Location: index.php?registration=success");
                        exit();
                    } else {
                        echo "<div class='message'>
                            <p>Registration failed. Please try again later.</p>
                        </div> <br>";
                    }
                }
            } else {
            ?>
                <header>Sign Up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>
                    <div class="links">
                        Already a member? <a href="index.php">Sign In</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>
