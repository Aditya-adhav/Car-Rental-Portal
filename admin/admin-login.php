<?php
session_start();
include('../includes/config.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch admin from the database
    $sql = "SELECT * FROM admin WHERE UserName = :username";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $admin = $query->fetch(PDO::FETCH_OBJ);

    if ($admin) {
        // Verify password
        if (password_verify($password, $admin->Password)) {
            $_SESSION['admin_login'] = $admin->UserName;
            echo "<script>alert('Admin login successful!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Admin not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Car Rental</title>
    <link rel="stylesheet" href="\css\style.css">
    <link rel="stylesheet" href="/css/style.css">
    <style>
    /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Login Container */
.admin-login-section {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0px 4px 20px rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    text-align: center;
    width: 350px;
}

/* Heading */
.admin-login-section h1 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 20px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
}

label {
    text-align: left;
    color: #fff;
    font-size: 14px;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 5px;
    outline: none;
    font-size: 16px;
    margin-bottom: 15px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

/* Placeholder Text */
input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Button */
button {
    background: #00c6ff;
    color: #fff;
    font-size: 16px;
    padding: 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #0072ff;
}

/* Responsive Design */
@media (max-width: 400px) {
    .admin-login-section {
        width: 90%;
    }
}

    </style>

</head>
<body>
    <main>
        <section class="admin-login-section">
            <h1>Admin Login</h1>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Login</button>
            </form>
        </section>
    </main>
</body>
</html>