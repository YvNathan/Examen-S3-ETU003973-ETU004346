<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <style>
        .container { max-width: 960px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 1rem 1.25rem; }
        .actions a { display: inline-block; margin-right: .75rem; padding: .5rem .9rem; border-radius: 6px; text-decoration: none; }
        .primary { background: #1f6feb; color: white; }
        .secondary { background: #f4f4f4; color: #333; }
    </style>
    <?php if (!empty($app) && ($nonce = $app->get('csp_nonce'))): ?>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'nonce-<?= htmlspecialchars($nonce) ?>'">
    <?php endif; ?>
    
</head>
<body>
    <div class="container">
        <h1>Accueil</h1>
        <div class="card">
            <p>Bienvenue. Choisissez une action ci-dessous&nbsp;:</p>
            <div class="actions">
                <a class="primary" href="/statut">Voir les statuts de livraison</a>
                <a class="primary" href="/livraisons/nouveau">Créer une livraison</a>
                <a class="secondary" href="/">Rafraîchir</a>
            </div>
        </div>
    </div>
</body>
</html>