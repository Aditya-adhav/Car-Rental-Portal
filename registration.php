<?php
session_start();
include('includes/config.php');

if (isset($_POST['register'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $contactNo = $_POST['contactNo'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Check if the email already exists
    $sql = "SELECT * FROM tblusers WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<script>alert('Email already exists.');</script>";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO tblusers (FullName, EmailId, Password, ContactNo, dob, Address, City, Country) 
                VALUES (:fullName, :email, :password, :contactNo, :dob, :address, :city, :country)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':contactNo', $contactNo, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);

        if ($query->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validateForm() {
            var email = document.getElementById('email').value;
            var contactNo = document.getElementById('contactNo').value;

            // Validate email
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Invalid email format.');
                return false;
            }

            // Validate phone number (assuming a simple 10-digit format)
            var phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(contactNo)) {
                alert('Invalid phone number. Please enter a 10-digit number.');
                return false;
            }

            return true;
        }
    </script>

</head>
<body>
    <?php include('includes/header.php'); ?>

    <main>
        <section class="registration-section">
            <h1>Register</h1>
            <form method="post">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="contactNo">Contact Number:</label>
                <input type="text" id="contactNo" name="contactNo" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <button type="submit" name="register">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </section>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>