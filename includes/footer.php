<?php
if(isset($_POST['emailsubscibe']))
{
    $subscriberemail=$_POST['subscriberemail'];
    $sql ="SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

    if($query -> rowCount() > 0)
    {
        echo "<script>alert('Already Subscribed.');</script>";
    }
    else
    {
        $sql="INSERT INTO tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':subscriberemail',$subscriberemail,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo "<script>alert('Subscribed successfully.');</script>";
        }
        else 
        {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var backToTop = document.querySelector(".back-to-top");

        // Show button when scrolling down
        window.addEventListener("scroll", function () {
            if (window.scrollY > 300) {
                backToTop.classList.add("show");
            } else {
                backToTop.classList.remove("show");
            }
        });

        // Smooth scroll to top
        backToTop.addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    });
</script>

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <!-- About Us Section -->
                <div class="col-md-6">
                    <h6>ABOUT US</h6>
                    <ul class="footer-links">
                        <li><a href="about.php">ABOUT US</a></li>
                        <li><a href="faqs.php">FAQs</a></li>
                        <li><a href="contact-us.php">CONTACT US</a></li>
                        <li><a href="admin/">ADMIN LOGIN</a></li>
                    </ul>
                </div>
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <p>Copyright &copy; 2025 Car Rental Portal. All Rights Reserved</p>
                </div>
                <div class="col-md-6 text-right social-icons">
                    <span>Connect with Us: </span>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                    <a href="#"><i class="fa fa-google-plus"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
</footer>
