<?php
session_start();
include("db.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password =$_POST['password'] ?? '';

    if (empty($username) || empty($password)) {$errors[] = "Both username and password are required.";
    } else {
        // Secure Prepared Statement to prevent SQL Injection
        $stmt =$conn->prepare("SELECT `id`, `password` FROM `users` WHERE `username` = ?");
        $stmt->bind_param("s", $username);$stmt->execute();
        $result =$stmt->get_result();

        if ($row =$result->fetch_assoc()) {
            if (password_verify($password,$row['password'])) {
                $_SESSION['username'] =$username;
                $stmt->close();
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect credentials";
            }
        } else {
            $errors[] = "Incorrect credentials";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <h3>Login System</h3>

  <?php if (!empty($errors)): ?>
      <p style="color:red">
          <?php foreach ($errors as$error): ?>
              <?= htmlspecialchars($error) ?><br>
          <?php endforeach; ?>
      </p>
  <?php endif; ?>

  <form method="POST">
      <label for="username">Enter your username
          <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
      </label>
      <br><br>
      <label for="password">Enter your password
          <input type="password" id="password" name="password" required>
      </label>
      <br><br>
      <button type="submit">Submit</button>
  </form>
</body>
</html>