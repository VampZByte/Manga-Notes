<?php
session_start();
include 'config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $phonenum = trim($_POST['phonenum']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $_SESSION['errors'] = "Username already taken!";
        header("Location: signup.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE firstname = ?");
    $stmt->bind_param("s", $firstname);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors[] = "First name already taken!";
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT id FROM users WHERE phonenum = ?");
    $stmt->bind_param("s", $phonenum);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors[] = "Phone number already taken!";
    }
    $stmt->close();

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['errors'] = "Password Mismatch!";
        header("Location: ../signup.php");
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, phonenum, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $phonenum, $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../index.php"); // Redirect to login page
        exit;
    } else {
        $_SESSION['errors'] = "Account creation failed!";
        header("Location: ../signup.php");
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
