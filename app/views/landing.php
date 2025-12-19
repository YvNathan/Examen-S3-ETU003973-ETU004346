<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Suivi de Livraisons</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/landing.css">
</head>

<body>

<header>
    <div class="logo">
    </div>
    <nav>
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#">ABOUT US</a></li>
            <li><a href="#">OUR CAMPAIGN</a></li>
            <li><a href="#">NEWS</a></li>
            <li><a href="#">CONTACT</a></li>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <p><?= BASE_URL ?></p>
            <h1>Suivi de Livraisons</h1>
            <p>
                Gérez et suivez vos livraisons en temps réel avec une plateforme
                moderne, fiable et intuitive pour optimiser votre logistique.
            </p>
            <a href="<?= BASE_URL ?>/accueil" class="cta">Accéder à l'application</a>
        </div>

        <div class="hero-illustration">
            <img src="<?= BASE_URL ?>/assets/images/logo.png"
                 alt="Illustration suivi de livraison">
        </div>
    </div>
</section>

<footer>
    &copy; 2025 ETU003973 - ETU004346
</footer>

<script>
    window.addEventListener('scroll', () => {
        document.querySelector('header')
            .classList.toggle('scrolled', window.scrollY > 50);
    });
</script>

</body>
</html>
