<?php
$username_err = $password_err = $confirm_password_err = $phone_err = $message_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconnect.php';
   
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    // Validate phone number
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }
    if (!empty(trim($_POST["message"]))) {
    $message = trim($_POST["message"]);
    } else {
    $message = ""; // Set default value if message is empty
    }
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert the message value into the database query
$sql = "INSERT INTO `users` (`username`, `password`, `phone`, `message`, `date`) VALUES ('$username', '$hash', '$phone', '$message', current_timestamp())";

    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err)) {
        // Perform database insertions (Replace this with your database logic)
        // You can insert values into your database table here
        // For simplicity, I'm just displaying the entered values here
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $num = mysqli_num_rows($result);

        if ($num == 0) {
            $sql = "INSERT INTO `users` (`username`, `password`, `phone`, `message`, `date`) VALUES ('$username', '$hash', '$phone', '$message', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<h3 style='color:green'>Signup Successful</h3>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "<h3 style='color:red'>Username not available</h3>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background img2.jpg') no-repeat center center fixed; /* Add the URL of your background image */
            background-size: cover; /* Cover the entire viewport */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        textarea {
            height: 100px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Signup Form</h2>
        <form action="signup.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            
            <label for="date">Date of Booking:</label><br>
            <input type="date" id="date" name="date" required><br>
            
            <label for="phone">Phone Number:</label><br>
            <input type="tel" id="phone" name="phone" required><br>
            
            <label for="message">Message:</label><br>
            <textarea id="message" name="message"></textarea><br>
            
            <input type="submit" value="Signup">
        </form>
    </div>
</body>
</html>

    
    <?php
// Database connection logic
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "mehendi"; // Change to your database name

// Check if form fields are set and not empty
if(isset($_POST['username'], $_POST['password'], $_POST['date'], $_POST['phone'],$_POST['message'])) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dob = $_POST['date'];
    $phone = $_POST['phone'];
    $message = isset($_POST['message']) ? $_POST['message'] : ''; // Check if message is set

    // Insert data into database
    $sql = "INSERT INTO users (username, password, date, phone, message)
    VALUES ('$username', '$password', '$date', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to homepage with success message
        header("Location: mehendi.html?signup=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "All fields are required.";
}
?>




</body>
</html>

