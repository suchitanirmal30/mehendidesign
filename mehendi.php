<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $message = trim($_POST['message']);

    // Validate input
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($number) || !preg_match('/^[0-9]{10,15}$/', $number)) {
        $errors[] = "Valid phone number is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    if (empty($errors)) {
        // Send email
        $to = "your_email@example.com";
        $subject = "New Message from MehndiMagicWorld";
        $email_body = "Name: $name\nEmail: $email\nNumber: $number\nMessage:\n$message";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        if (mail($to, $subject, $email_body, $headers)) {
            // Redirect back to the contact page with success status
            header("<Location:mehendi.html?status=success");
        } else {
            // Redirect back to the contact page with error status
            header("Location: mehendi.html?status=error");
        }
        exit();
    } else {
        // Redirect back to the contact page with validation errors
        $error_message = implode(" ", $errors);
        header("Location: mehendi.html?status=validation_error&message=" . urlencode($error_message));
        exit();
    }
}
?>
