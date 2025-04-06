<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Save to database or send email
    // Example: Save to database
    include('includes/config.php');
    $sql = "INSERT INTO tblcontactusquery (name, EmailId, Message) VALUES (:name, :email, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);

    if ($query->execute()) {
        echo "<script>alert('Message sent successfully!'); window.location.href = 'contact-us.php';</script>";
    } else {
        echo "<script>alert('Failed to send message.'); window.location.href = 'contact-us.php';</script>";
    }
}
?>