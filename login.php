<?php
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email exists
    $sql = "SELECT id, EmailId, Password FROM tblusers WHERE EmailId = :email LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_OBJ);

    if ($user) {
        // Verify password (ensure it's hashed in the DB)
        if (password_verify($password, $user->Password)) {
            session_regenerate_id(true); // Prevent session fixation

            $_SESSION['login'] = $user->EmailId;
            $_SESSION['user_id'] = $user->id;

            echo "<script>alert('Login successful!'); window.location.href='index.php';</script>";
            exit;
        } else {
           
            echo "<script>alert('Invalid password.');</script>";
            
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <main>
        <section class="login-section">
            <h1>Login</h1>
            <form method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="registration.php" class="btn">Register here</a></p>
        </section>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>
