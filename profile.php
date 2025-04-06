<?php
session_start();
include('includes/config.php');

// Check if user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database
$userEmail = $_SESSION['login'];
$sql = "SELECT * FROM tblusers WHERE EmailId = :email";
$query = $dbh->prepare($sql);
$query->bindParam(':email', $userEmail, PDO::PARAM_STR);
$query->execute();
$user = $query->fetch(PDO::FETCH_OBJ);
?>
<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Rent Rush</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Profile Page Styles */
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-container h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .profile-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .profile-details p {
            font-size: 1.1rem;
            color: #555;
        }

        .profile-details p strong {
            color: #333;
        }

        .profile-actions {
            margin-top: 20px;
            text-align: center;
        }

        .profile-actions a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <main>
        <div class="profile-container">
            <h1>My Profile</h1>
            <?php if ($user) { ?>
                <div class="profile-details">
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user->FullName); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user->EmailId); ?></p>
                    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user->ContactNo); ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user->dob); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user->Address); ?></p>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($user->City); ?></p>
                    <p><strong>Country:</strong> <?php echo htmlspecialchars($user->Country); ?></p>
                </div>
                <div class="profile-actions">
                    <a href="edit-profile.php">Edit Profile</a>
                </div>
            <?php } else { ?>
                <p>No profile information found.</p>
            <?php } ?>
        </div>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>