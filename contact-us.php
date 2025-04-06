<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');
include('includes/header.php');

// Fetch contact information from the database
$sql = "SELECT * FROM tblcontactusinfo LIMIT 1";
$query = $dbh->prepare($sql);
$query->execute();
$contactInfo = $query->fetch(PDO::FETCH_OBJ);

// Display success or error message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Car Rental</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Contact Section */
        .contact-section {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }

        .contact--info, .contact-form {
            flex: 1;
            min-width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact--info h2, .contact-form h2 {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        .contact--info p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
        }

        .contact--info ul {
            list-style: none;
            padding: 0;
        }

        .contact--info ul li {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .contact--info ul li strong {
            color: #333;
        }

        /* Contact Form */
        .contact-form label {
            display: block;
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 150px;
        }

        .contact-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <main>
        <?php if (isset($message)) { ?>
            <div class="alert <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php } ?>

        <h1>Contact Us</h1>
        <section class="contact-section">
            <div class="contact--info">
                <h2>Get in Touch</h2>
                <p>
                    If you have any questions or need assistance, feel free to reach out to us. Our team is here to help!
                </p>
                <ul>
                    <?php if ($contactInfo) { ?>
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($contactInfo->EmailId); ?></li>
                        <li><strong>Phone:</strong> <?php echo htmlspecialchars($contactInfo->ContactNo); ?></li>
                        <li><strong>Address:</strong> <?php echo htmlspecialchars($contactInfo->Address); ?></li>
                    <?php } else { ?>
                        <li>Contact information not available.</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="submit-contact.php" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>
        </section>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>