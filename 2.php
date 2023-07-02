<?php
// Database configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email from the user
$email = $_POST['email'];

// Fetch the health report file path from the database
$sql = "SELECT pdf_file FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pdfFilePath = $row['pdf_file'];

    // Check if the PDF file exists
    if (file_exists($pdfFilePath)) {
        // Set appropriate headers for PDF download
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename='" . basename($pdfFilePath) . "'");
        header("Content-Length: " . filesize($pdfFilePath));

        // Output the PDF file
        readfile($pdfFilePath);
    } else {
        echo "PDF file not found.";
    }
} else {
    echo "User not found.";
}

// Close the database connection
$conn->close();
?>