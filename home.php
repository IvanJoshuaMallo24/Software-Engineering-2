<?php
session_start();
include(__DIR__ . "/config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id'];
$res_Uname = "";
$res_Email = "";

// Fetch the admin user's username and email
$query = mysqli_prepare($con, "SELECT username, email FROM admin_users WHERE ID = ?");
mysqli_stmt_bind_param($query, 'i', $id);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $res_Uname, $res_Email);
if (!mysqli_stmt_fetch($query)) {
    die("User not found");
}
mysqli_stmt_close($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .nav {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        .nav .logo a {
            color: white;
            text-decoration: none;
        }
        .right-links a {
            color: white;
            margin-left: 20px;
        }
        .main-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">PLMUN Alumni</a></p>
        </div>
        <div class="right-links">
            <?php echo "<a href='edit.php?Id=$id'>Change Profile</a>"; ?>
            <a href="logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="box">
                <p>Hello <b><?php echo htmlspecialchars($res_Uname); ?></b>, Welcome!</p>
            </div>
        </div>
        
       

        <!-- Alumni List Table -->
        <div class="main-box table-container">
            <h2>Batch 2024-2025 Graduates</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumni ID</th>
                        <th>Student Number</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Department</th>
                        <th>Program</th>
                        <th>Year Graduated</th>
                        <th>Contact Number</th>
                        <th>Personal Email</th>
                        <th>Working Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($con, "
                        SELECT g.*, ws.Working_Status 
                        FROM `Alumni_2024-2025` g 
                        LEFT JOIN `alumni_2024-2025_ws` ws 
                        ON g.Alumni_ID_Number = ws.Alumni_ID_Number
                    ");
                    if (!$result) {
                        die("Query failed: " . mysqli_error($con));
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Alumni_ID_Number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Student_Number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Last_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['First_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Department']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Program']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Year_Graduated']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Contact_Number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Personal_Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Working_Status']) . "</td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
