<?php
require 'dbconnect.php';

if(isset($_POST["submit"])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Sanitize input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    $result = mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        // Assuming passwords are hashed
        $stored_password = $row["password"];
        
        // Check if the hashed input password matches the stored hashed password
        if(password_verify($password, $stored_password)){
            session_start();
            $_SESSION["login"] = true;
            // $_SESSION["id"] = $row["id"];
            $_SESSION['user'] = $username;
            header("location: mehendi.html");
            exit();
        } else {
            echo "<script>alert('Wrong password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>diems library</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background: url('background img2.jpg') no-repeat center center fixed; /* Add the URL of your background image */
            background-size: cover; /* Cover the entire viewport */
            margin: 0;
            padding: 0;
        }
        h2{
            text-align: center;
        }
        .login-container {
            margin-top:130px;
            margin-left:36%;
            text-align: left;
            padding-top: 50px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8); /* transparent white */
            width: 400px; /* adjust width as needed */
            /* margin: 0 auto; */
            height: 400px; /* adjust height as needed */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-form {
            padding: 20px;
        }
    
        </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
                <h2>Login</h2>
                <form method="post" action="" class="" autocomplete="off" id="login-form">
            
                    <div class="form-group">
                        <label for="username">username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required value="">
                    </div>
                    <div class="form-group">
                        <label for="password">password:</label>
                        <input type="password" class="form-control" name="password"  id="password" placeholder="Enter password" required value="">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
                    <pre>
                    </pre>          
                    <a href="logout.php" class="btn">Logout</a>
                </form>
            </div>
        </div>

    <script></script>
   
</body>

</html>
