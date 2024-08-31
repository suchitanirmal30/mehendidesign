<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'your_username';
$dbPassword = 'your_password';
$dbName = 'mehendi_shop';

// Connect to MySQL database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to retrieve all mehendi designs
function getDesigns($conn) {
    $sql = "SELECT * FROM designs";
    $result = $conn->query($sql);
    $designs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $designs[] = $row;
        }
    }
    return $designs;
}

// Insert new mehendi design
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    $price = sanitize_input($_POST['price']);
    $image_url = sanitize_input($_POST['image_url']);
    
    $sql = "INSERT INTO designs (name, description, price, image_url) VALUES ('$name', '$description', '$price', '$image_url')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve all mehendi designs
$designs = getDesigns($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mehendi Shop</title>
</head>
<body>
    <h1>Welcome to Mehendi Shop</h1>
    <h2>Add New Design</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Name:</label><br>
        <input type="text" name="name" required><br>
        <label>Description:</label><br>
        <textarea name="description" rows="4" cols="50"></textarea><br>
        <label>Price:</label><br>
        <input type="text" name="price" required><br>
        <label>Image URL:</label><br>
        <input type="text" name="image_url" required><br>
        <input type="submit" name="submit" value="Add Design">
    </form>

    <h2>Available Designs</h2>
    <ul>
        <?php foreach ($designs as $design): ?>
            <li>
                <strong><?php echo $design['name']; ?></strong><br>
                Description: <?php echo $design['description']; ?><br>
                Price: <?php echo $design['price']; ?><br>
                <img src="<?php echo $design['image_url'];
?>" alt="<?php echo $design['name']; ?>" style="max-width: 200px;"><br>
<a href="edit_design.php?id=<?php echo $design['id']; ?>">Edit</a> | 
<a href="delete_design.php?id=<?php echo $design['id']; ?>" onclick="return confirm('Are you sure you want to delete this design?');">Delete</a>
</li>
<?php endforeach; ?>
</ul>
</body>
</html>
