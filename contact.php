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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --text:#0f172a;
      --border:#e5e7eb;
      --primary:#6366f1;
      --tint:#9db3e37a;        
      --card:#ffffff;
      --shadow:0 8px 28px rgba(17,24,39,.10), 0 2px 10px rgba(17,24,39,.06);
    }

    a{
        color:inherit;
        text-decoration:none;
    }

    .container{
        max-width:1140px;
        margin:10px auto;
        padding:0 20px;
        margin-bottom: 10px;
    }

    /* Hero */
    .hero{
      position:relative;
      padding:54px 0 40px;
      overflow:hidden;
      background:#fff;
    }

    .hero .title{
      text-align:center; 
      font-size:40px; 
      line-height:1.15; 
      margin:0 0 14px; 
      color: #0d6efd;
      letter-spacing:.2px;
    }

    .hero .mini{
      display:flex; 
      gap:32px; 
      justify-content:center; 
      flex-wrap:wrap; 
      color:#4b5563;
    }

    .tag{
      display:flex; 
      align-items:center; 
      gap:10px; 
      font-weight:500;
    }

    .tag svg{
        color:#0d6efd;
    }

    /* Contact block wrapper band */
    .band{
        background:var(--tint); 
        padding:64px 0;
    }

    .contact-card{
      background:var(--card);
      border-radius:18px;
      box-shadow:var(--shadow);
      overflow:hidden;
      display:grid;
      grid-template-columns:1.05fr 1fr;
      min-height:420px;
    }

    /* Form side */
    .form-side{
        padding:36px 30px 28px 40px;
    }

    .form-heading{
        margin:0 0 14px; 
        font-size:28px;
    }

    .field{
        margin:12px 0;
    }

    .label{
        display:block; 
        font-weight:600; 
        font-size:14px; 
        margin-bottom:6px;
    }

    .input, .textarea{
      width:100%;
      padding:12px 14px;
      border:1px solid var(--border);
      border-radius:10px;
      outline:transparent;
      transition:.15s ease;
      font:inherit;
      background:#fff;
    }

    .textarea{
        min-height:110px;
    }

    .input:focus, .textarea:focus{
        border-color:var(--primary); 
        box-shadow:0 0 0 3px rgba(99,102,241,.15);
    }

    .submit-row{
        margin-top:12px;
    }

    .submit-btn{
        display:inline-flex; 
        align-items:center; 
        justify-content:center; 
        padding:12px 30px; 
        color: #ffffff;
        font-weight:600; 
        font-size:16px; 
        border-radius:8px; 
        border:none; 
        cursor:pointer; 
        transition:.15s ease;
        text-decoration:none;
        background-color: #4f46e5;
    }

    .map-side{
      position:relative; 
      background:#fafafa;
    }

    /* Responsive */
    @media (max-width: 1024px){
        .contact-card{ 
            grid-template-columns:1fr 1fr; 
        }

        .form-side{ 
            padding:28px; 
        }
        .hero{ padding:48px 0 32px; 
        }

        .hero .mini{ 
            gap:22px; 
        }
    }

    @media (max-width: 900px){
        .contact-card{ 
            grid-template-columns:1fr; 
        }

        .band{ 
            padding:44px 0; 
        }

        .form-side{ 
            padding:22px 20px; 
        }

        .map-side{
            min-height:auto;
            aspect-ratio:16/11; 
        }
    }

    @media (max-width: 560px){
        .hero{ 
            padding:36px 0 24px; 
        }

        .hero .mini{ 
            gap:16px; 
        }

        .tag{ 
            font-size:14px; 
        }

        .submit-btn{ 
            width:100%; 
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
          <!-- location -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 22s7-5.33 7-12a7 7 0 1 0-14 0c0 6.67 7 12 7 12z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="10" r="2.6" stroke="currentColor" stroke-width="1.6"/></svg>
          Alaska, United States
        </div>
        <div class="tag">
          <!-- mail -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.6"/><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.6"/></svg>
          sample@email.com
        </div>
        <div class="tag">
          <!-- phone -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6.62 10.79a15 15 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24 11.36 11.36 0 0 0 3.57.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 7a1 1 0 0 1 1-1h2.49a1 1 0 0 1 1 1c0 1.23.2 2.42.57 3.57a1 1 0 0 1-.24 1.01l-2.2 2.2z" stroke="currentColor" stroke-width="1.6"/></svg>
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
          <h2 id="form-heading">Contact us</h2>
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
              <label class="label" for="message">Question</label>
              <textarea class="textarea" id="message" name="message" placeholder="Enter question or feedback"></textarea>
            </div>
            <div class="submit-row">
              <button class="submit-btn primary" type="submit">Submit</button>
            </div>
          </form>
        </div>
        
        <div class="map-side" aria-hidden="true">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d53745.271276589156!2d85.28195217030014!3d27.65746270977327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19d3cf18ca51%3A0xd10ec3d53656e18f!2sLalitpur!5e1!3m2!1sen!2snp!4v1765277284041!5m2!1sen!2snp" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </section>
  <?php include './includes/footer.php'; ?>
</body>
</html>