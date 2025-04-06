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

    /* FAQ Section */
    .faq-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .faq-item {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        border-left: 5px solid #007bff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .faq-item h2 {
        font-size: 20px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .faq-item p {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
    }
</style>

<main>
    <h1>Frequently Asked Questions</h1>
    <section class="faq-section">
        <div class="faq-item">
            <h2>How do I rent a car?</h2>
            <p>
                Renting a car is easy! Simply browse our available vehicles, select the one you want, and proceed to the booking page. You'll need to provide some basic information and payment details to complete the reservation.
            </p>
        </div>
        <div class="faq-item">
            <h2>What documents do I need?</h2>
            <p>
                You'll need a valid driver's license, a credit card for payment, and proof of insurance (if applicable). Additional documents may be required depending on your location.
            </p>
        </div>
        <div class="faq-item">
            <h2>Can I cancel my booking?</h2>
            <p>
                Yes, you can cancel your booking. Please refer to our cancellation policy for more details. Cancellations made within 24 hours of the rental period may incur a fee.
            </p>
        </div>
        <div class="faq-item">
            <h2>Do you offer long-term rentals?</h2>
            <p>
                Yes, we offer long-term rental options. Contact our customer service team for more information and special rates for extended rentals.
            </p>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>
