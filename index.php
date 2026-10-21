<?php
include("db.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password =$_POST['password'] ?? '';
    $confirmPassword =$_POST['confirm_password'] ?? '';

    // 1. Validate Username Length
    if (empty($username)) {$errors[] = "Username is required";
    } elseif (strlen($username) < 8) {$errors[] = "Username must be 8 or more characters long";
    }

    // 2. Validate Password Match & Strength
    if ($password !== $confirmPassword) {$errors[] = "Passwords do not match";
    }

    // Pattern requires: 8+ chars, at least 1 uppercase, 1 lowercase, 1 digit, 1 special char
    $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if (!preg_match($passwordPattern, $password)) {$errors[] = "Password must be at least 8 characters long and contain uppercase, lowercase, a number, and a special character.";
    }

    // 3. Check Database for Existing Username
    if (empty($errors)) {
        $stmt =$conn->prepare("SELECT `username` FROM `users` WHERE `username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();$stmt->store_result();

        if ($stmt->num_rows > 0) {$errors[] = "Username already exists";
        }
        $stmt->close();
    }

    // 4. Insert User
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt =$conn->prepare("INSERT INTO `users` (`username`, `password`) VALUES (?, ?)");
        $stmt->bind_param("ss", $username,$hashedPassword);

        if ($stmt->execute()) {$stmt->close();
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Database error: Unable to complete registration.";
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h3>Register Account</h3>
    
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as$error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label>Enter your username
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        </label>
        <br><br>
        <label>Enter your password
            <input type="password" name="password" required>
        </label>
        <br><br>
        <label>Confirm your password
            <input type="password" name="confirm_password" required>
        </label>
        <br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>