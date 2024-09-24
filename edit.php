<?php
session_start();
include("config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id'];

$query = mysqli_query($con, "SELECT * FROM admin_users WHERE ID = '$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "User not found.";
    exit();
}

$res_Uname = $row['username'];
$res_Email = $row['email'];

$success_message = "";

if (isset($_POST['update'])) {
    $new_username = mysqli_real_escape_string($con, $_POST['username']);
    $new_email = mysqli_real_escape_string($con, $_POST['email']);
    
    mysqli_query($con, "UPDATE admin_users SET username='$new_username', email='$new_email' WHERE ID='$id'") or die("Update Error");

    $_SESSION['username'] = $new_username;
    $_SESSION['valid'] = $new_email;

    $success_message = "Profile updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-box {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        header {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field label {
            display: block;
            margin-bottom: 5px;
        }
        .field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            color: green;
            margin-top: 10px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Edit Profile</header>
            <?php if ($success_message): ?>
                <div class="message"><?php echo $success_message; ?></div>
                <div class="back-link">
                    <a href="home.php" class="btn">Back to Home</a>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($res_Uname); ?>" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($res_Email); ?>" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="update" value="Update">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
