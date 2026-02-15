<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact — Brand</title>
  <meta name="description" content="Get in touch with our team" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --text: #0f172a;
      --border: #e5e7eb;
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --tint: #eef2ff;
      --card: #ffffff;
      --shadow: 0 8px 28px rgba(17, 24, 39, .10), 0 2px 10px rgba(17, 24, 39, .06);
    }

    body {
      font-family: "Poppins", sans-serif;
      color: #0f172a;
      line-height: 1.6;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    .container {
      max-width: 1140px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Hero */
    .hero {
      position: relative;
      padding: 20px 0 40px;
      background: #fff;
    }

    .hero .title {
      text-align: center;
      font-size: 48px;
      font-weight: 700;
      line-height: 1.2;
      margin: 0 0 24px;
      color: #0d6efd;
      letter-spacing: -0.5px;
    }

    .hero .mini {
      display: flex;
      gap: 32px;
      justify-content: center;
      flex-wrap: wrap;
      color: #4b5563;
    }

    .tag {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
      font-size: 15px;
    }

    .tag i {
      color: #0d6efd;
      font-size: 20px;
    }

    /* Contact block wrapper band */
    .band {
      background: var(--tint);
      padding: 80px 0;
    }

    .contact-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
      display: grid;
      grid-template-columns: 1.05fr 1fr;
      min-height: 500px;
    }

    /* Form side */
    .form-side {
      padding: 48px 50px;
    }

    .form-heading {
      margin: 0 0 8px;
      font-size: 32px;
      font-weight: 700;
      color: var(--text);
    }

    .form-subtitle {
      color: #64748b;
      font-size: 15px;
      margin-bottom: 28px;
    }

    .field {
      margin-bottom: 20px;
    }

    .label {
      display: block;
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 8px;
      color: var(--text);
    }

    .input,
    .textarea {
      width: 100%;
      padding: 13px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      outline: none;
      transition: all 0.2s ease;
      font-family: inherit;
      font-size: 15px;
      background: #fff;
      color: var(--text);
    }

    .textarea {
      min-height: 120px;
      resize: vertical;
    }

    .input:focus,
    .textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
    }

    .input::placeholder,
    .textarea::placeholder {
      color: #9ca3af;
    }

    .submit-row {
      margin-top: 24px;
    }

    .submit-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 14px 32px;
      color: #ffffff;
      font-weight: 600;
      font-size: 16px;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      background-color: #0d6efd;
      font-family: inherit;
    }

    .submit-btn:hover {
      background-color: #0d6efd;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    .map-side {
      position: relative;
      background: #f3f4f6;
    }

    .map-side iframe {
      display: block;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .contact-card {
        grid-template-columns: 1fr 1fr;
      }

      .form-side {
        padding: 40px 36px;
      }

      .hero {
        padding: 48px 0 32px;
      }

      .hero .title {
        font-size: 42px;
      }

      .hero .mini {
        gap: 24px;
      }
    }

    @media (max-width: 900px) {
      .contact-card {
        grid-template-columns: 1fr;
      }

      .band {
        padding: 60px 0;
      }

      .form-side {
        padding: 40px 32px;
      }

      .map-side {
        min-height: 350px;
      }
    }

    @media (max-width: 640px) {
      .hero {
        padding: 40px 0 28px;
      }

      .hero .title {
        font-size: 36px;
      }

      .hero .mini {
        gap: 20px;
        flex-direction: column;
        align-items: center;
      }

      .tag {
        font-size: 14px;
      }

      .tag i {
        font-size: 18px;
      }

      .band {
        padding: 40px 0;
      }

      .form-side {
        padding: 32px 24px;
      }

      .form-heading {
        font-size: 28px;
      }

      .submit-btn {
        width: 100%;
      }

      .map-side {
        min-height: 300px;
      }
    }
  </style>
</head>

<body>
  <?php include './includes/header.php'; ?>

  <!-- Hero -->
  <section class="hero">
    <div class="container">
      <h1 class="title">Drop Us a Line</h1>
      <div class="mini">
        <div class="tag">
          <i class="ri-map-pin-line"></i>
          Alaska, United States
        </div>
        <div class="tag">
          <i class="ri-mail-line"></i>
          sample@email.com
        </div>
        <div class="tag">
          <i class="ri-phone-line"></i>
          (205) 387-2122
        </div>
      </div>
    </div>
  </section>

  <!-- Contact band -->
  <section class="band">
    <div class="container">
      <div class="contact-card" role="region" aria-label="Contact form and map">
        <!-- Form -->
        <div class="form-side">
          <h2 class="form-heading">Contact Us</h2>
          <p class="form-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
          <form action="#" method="post">
            <div class="field">
              <label class="label" for="name">Name</label>
              <input class="input" id="name" name="name" type="text" placeholder="Enter your name" required>
            </div>
            <div class="field">
              <label class="label" for="email">Email</label>
              <input class="input" id="email" name="email" type="email" placeholder="your@email.com" required>
            </div>
            <div class="field">
              <label class="label" for="message">Message</label>
              <textarea class="textarea" id="message" name="message" placeholder="Tell us what's on your mind..." required></textarea>
            </div>
            <div class="submit-row">
              <button class="submit-btn" type="submit">
                Send Message
                <i class="ri-send-plane-line"></i>
              </button>
            </div>
          </form>
        </div>

        <div class="map-side" aria-hidden="true">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d53745.271276589156!2d85.28195217030014!3d27.65746270977327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19d3cf18ca51%3A0xd10ec3d53656e18f!2sLalitpur!5e1!3m2!1sen!2snp!4v1765277284041!5m2!1sen!2snp" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
<?php include './includes/footer.php'; ?>