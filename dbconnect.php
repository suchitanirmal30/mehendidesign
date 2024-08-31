<?php
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "mehendi"; // Change to your database name

// Check if form fields are set and not empty
if(isset($_POST['username'], $_POST['password'])) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
   
   
    // Insert data into database
    $sql = "INSERT INTO users (username, password)
    VALUES ('$username', '$password')";

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