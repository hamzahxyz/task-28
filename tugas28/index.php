<?php
session_start();

// Hardcoded user credentials for demonstration purposes
$valid_username = 'hamzah';
$valid_password = 'jamal';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        header('Location: tugas27.php'); // Redirect to tugas 27 after login
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Light grey background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container for the login form */
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        /* Form header */
        .login-container h2 {
            text-align: center;
            color: #FF69B4; /* Pink color */
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Input fields */
        .login-container label {
            font-size: 14px;
            color: #333;
        }

        .login-container input[type="text"], 
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Button styling */
        .login-container button {
            width: 100%;
            background-color: #FF69B4; /* Pink color */
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #e5569c; /* Darker pink on hover */
        }

        /* Error message styling */
        .login-container p {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
