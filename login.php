<?php

include 'config.php';
session_start();

try {
  if ($_SERVER['REQUEST_METHOD'] == "POST") { 
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = verify_user($username, $password);

    if ($user) {
      
      $token = bin2hex(random_bytes(32));


      $_SESSION['access_token'] = $token;
      $_SESSION['user_id'] = $user['id']; 


      header("Location: index.php");
      exit;
    } else {
      $_SESSION['errors'] = "Invalid username or password!";
      header("Location: signin.php");
      exit;
    }
  }
} catch (\Exception $e) {
  echo "Error: " . $e->getMessage();
}


function verify_user($username, $password) {
  global $conn;

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
 
    if (password_verify($password, $row['password'])) {
      return $row;
    }
  }
  return false;
}
?>

   