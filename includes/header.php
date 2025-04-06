<?php
include('config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch contact information from the database
$sql = "SELECT EmailId, ContactNo FROM tblcontactusinfo LIMIT 1";
$query = $dbh->prepare($sql);
$query->execute();
$contactInfo = $query->fetch(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Rush</title>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images\favicon-icon\apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images\favicon-icon\apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images\favicon-icon\apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images\favicon-icon\apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images\favicon-icon\favicon.png">
    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Modern Dropdown Menu Styles */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown .dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-dropdown .dropdown-toggle img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #007bff;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .user-dropdown .dropdown-toggle:hover img {
            transform: scale(1.1);
            border-color: #0056b3;
        }

        .user-dropdown .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            z-index: 1000;
            min-width: 200px;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .user-dropdown.active .dropdown-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .user-dropdown .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .user-dropdown .dropdown-menu a i {
            width: 20px;
            text-align: center;
        }

        .user-dropdown .dropdown-menu a:hover {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .user-dropdown .dropdown-menu a:hover i {
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <!-- Top Header Section -->
        <div class="top-bar">
            <div class="container">
                <div class="logo">
                    <img src="images/logo4.png" alt="Car Rental Logo">
                </div>
                
                <div class="contact-info">
                    <div class="header_widgets">
                        <div class="circle_icon"> <i class="fa fa-envelope"></i> </div>
                        <p>For Support Mail Us: </p>
                        <a href="mailto:<?php echo htmlspecialchars($contactInfo->EmailId); ?>">
                            <?php echo htmlspecialchars($contactInfo->EmailId); ?>
                        </a>
                    </div>
                    <div class="header_widgets">
                        <div class="circle_icon"> <i class="fa fa-phone"></i> </div>
                        <p>Service Helpline Call Us: </p>
                        <a href="tel:<?php echo htmlspecialchars($contactInfo->ContactNo); ?>">
                            <?php echo htmlspecialchars($contactInfo->ContactNo); ?>
                        </a>
                    </div>
                </div>
                <div class="user-actions">
                    <?php if (isset($_SESSION['login'])) { ?>
                        <!-- Show User Logo and Dropdown Menu if user is logged in -->
                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-toggle">
                                <img src="images\cat-profile.png" alt="User Logo">
                            </div>
                            <div class="dropdown-menu">
                                <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                                <a href="my-bookings.php"><i class="fas fa-car"></i> My Bookings</a>
                                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- Show Login Button if user is logged out -->
                        <li><a href="login.php" class="btn">Login</a></li>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Navigation Bar -->
        <nav class="main-nav">
            <div class="container">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                    <li><a href="cars.php">CAR LISTING</a></li>
                    <li><a href="faqs.php">FAQS</a></li>
                    <li><a href="contact-us.php">CONTACT US</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <script>
        // JavaScript to toggle the dropdown menu
        document.addEventListener('DOMContentLoaded', function () {
            const userDropdown = document.getElementById('userDropdown');
            const dropdownToggle = userDropdown.querySelector('.dropdown-toggle');
            const dropdownMenu = userDropdown.querySelector('.dropdown-menu');

            dropdownToggle.addEventListener('click', function (e) {
                e.stopPropagation(); // Prevent the click from closing the dropdown immediately
                userDropdown.classList.toggle('active');
            });

            // Close the dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>