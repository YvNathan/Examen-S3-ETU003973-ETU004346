<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bienvenue</title>
  <link rel="stylesheet" href="/assets/styles.css" />
  <style>
    body,
    html {
      height: 100%;
    }

    .landing {
      min-height: 100vh;
      display: grid;
      place-items: center;
      background: linear-gradient(135deg, #0f1f3a 0%, #1f6feb 100%);
    }

    .panel {
      background: #ffffff;
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 14px 40px rgba(15, 23, 42, 0.18);
      padding: 2rem 2.2rem;
      width: min(520px, 92%);
      text-align: center;
    }

    .logo {
      width: 200px;
      height: 200px;
      margin: 0 auto 0 auto;
    }

    .logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .panel h1 {
      margin: 0 0 0.5rem 0;
      color: #0f1f3a;
    }

    .panel p {
      margin: 0 0 1.25rem 0;
      color: #475569;
    }

    .cta {
      display: inline-block;
      padding: 0.9rem 1.4rem;
      border-radius: 12px;
      background: linear-gradient(120deg, #1f6feb, #3f8cff);
      color: #fff;
      text-decoration: none;
      font-weight: 800;
      letter-spacing: .02em;
      box-shadow: 0 16px 36px rgba(31, 111, 235, 0.35);
      transition: transform .15s, box-shadow .15s;
    }

    .cta:hover {
      transform: translateY(-1px);
      box-shadow: 0 20px 40px rgba(31, 111, 235, 0.4);
    }
  </style>
</head>

<body>
  <section class="landing">
    <div class="panel">
      <div class="logo">
        <img src="/assets/images/Logo.png" alt="Logo" />
      </div>
      <h1>Bienvenue</h1>
      <p>Accédez à l'application pour gérer vos livraisons.</p>
      <a class="cta" href="/app">Accéder</a>
    </div>
  </section>
</body>

</html>