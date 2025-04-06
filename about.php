<?php include('includes/header.php'); ?>

<style>
    /* General Styles */
    main {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 28px;
        margin-bottom: 20px;
    }

    /* About Section */
    .about-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .about-content {
        flex: 1;
        min-width: 300px;
    }

    .about-content h2 {
        font-size: 24px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .about-content p {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
    }

    .about-image {
        flex: 1;
        min-width: 300px;
        text-align: center;
    }

    .about-image img {
        width: 100%;
        max-width: 400px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .about-section {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<main>
    <h1>About Us</h1>
    <section class="about-section">
        <div class="about-content">
            <h2>Welcome to Rent Rush</h2>
            <p>
                At Rent Rush, we are dedicated to providing you with the best car rental experience. Whether you need a car for a day, a week, or longer, we have a wide range of vehicles to suit your needs. Our mission is to make car rental simple, convenient, and affordable.
            </p>
            <p>
                With years of experience in the industry, we pride ourselves on offering high-quality vehicles, excellent customer service, and competitive prices. Our team is here to help you find the perfect car for your journey.
            </p>
        </div>
        <div class="about-image">
            <img src="images/aboutus-page-header-img.jpg" alt="About Us">
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>
