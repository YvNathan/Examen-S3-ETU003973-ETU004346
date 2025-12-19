<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nouvelle livraison</title>
  <?php
  $basePath = rtrim($baseUrl ?? BASE_URL ?? '', '/');
  if ($basePath === '/') {
    $basePath = '';
  }
  $base = htmlspecialchars($basePath, ENT_QUOTES);
  ?>
  <link rel="stylesheet" href="<?= $base ?>/assets/styles.css">
 
  </style>
</head>

<body class="app-shell">
  <header class="topbar">
    <div class="topbar__inner">
      <div class="topbar__brand"><a href="<?= $base ?: '/accueil' ?>"></a></div>
      <nav class="topbar__actions">
        <a class="topbar__link" href="<?= $base ?>/livraisons/nouveau">+ Nouvelle livraison</a>
        <a class="topbar__link" href="<?= $base ?>/accueil">Réinitialiser</a>
      </nav>
    </div>
  </header>

  <div class="app-grid">
    <aside class="sidebar">
      <div class="sidebar__title">Navigation</div>
      <a class="sidebar__link" href="<?= $base ?: '/accueil' ?>">Accueil</a>
      <a class="sidebar__link" href="<?= $base ?>/statut">Statuts des livraisons</a>
      <a class="sidebar__link is-active" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
      <a class="sidebar__link" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
      <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
      <a class="sidebar__link" href="<?= $base ?>/benefices/vehicules">Bénéfices par véhicule</a>
      <a class="sidebar__link" href="<?= $base ?>/zones">Zones de livraison</a>
    </aside>

    <main class="page">
      <div class="container">
        <h2>Nouvelle livraison</h2>
        <p><a href="<?= $base ?: '/' ?>" class="back-link">← Retour à l'accueil</a></p>

        <?php if (!empty($error)) : ?>
          <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])) : ?>
          <div class="alert alert-success">
            Livraison enregistrée avec succès
          </div>
        <?php endif; ?>

        <form action="<?= $base ?>/livraisons/nouveau" method="post">
          <div class="section">
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">Chauffeur</label>
                <select name="idLivreur" required>
                  <option value="">-- Choisir --</option>
                  <?php if (!empty($livreurs)) : ?>
                    <?php foreach ($livreurs as $l) : ?>
                      <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['nom']) ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Véhicule</label>
                <select name="idVehicule" required>
                  <option value="">-- Choisir --</option>
                  <?php foreach ($vehicules as $v) : ?>
                    <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['immatriculation']) ?> - <?= htmlspecialchars($v['modele']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="date" name="dateLivraison" required>
              </div>
            </div>
          </div>

          <div class="table-section">
            <div class="table-title">Colis</div>
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Description</th>
                    <th>Destinataire</th>
                    <th>Poids/kg</th>
                    <th>Adresse Destination</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($colis as $c) : ?>
                    <tr>
                      <td><?= htmlspecialchars($c['descrip']) ?></td>
                      <td><?= htmlspecialchars($c['destinataire'] ?? 'N/A') ?></td>
                      <td><?= htmlspecialchars($c['poids_Kg']) ?></td>
                      <td><?= htmlspecialchars($c['adrDestination'] ?? 'N/A') ?></td>
                      <td>
                        <button type="button" class="btn-select" onclick="selectColis(<?= $c['id'] ?>, this)">Sélectionner</button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <input type="hidden" name="idColis" id="selectedColis" required>

          <div class="section">
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">Coût véhicule</label>
                <input type="number" step="0.01" name="coutVehicule" required>
              </div>
              <div class="form-group">
                <label class="form-label">Prix par Kg</label>
                <input type="number" step="0.01" name="prixKg" required>
              </div>
              <div class="form-group">
                <label class="form-label">Zone de livraison</label>
                <select name="idZone" required>
                  <option value="">-- Choisir une zone --</option>
                  <?php if (!empty($zones)) : ?>
                    <?php foreach ($zones as $z) : ?>
                      <option value="<?= $z['id'] ?>">
                        <?= htmlspecialchars($z['nom']) ?> 
                        (<?= number_format($z['pourcentage'], 2) ?>%)
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="submit-btn">Enregistrer la livraison</button>
          </div>
        </form>
      </div>

  </div>
  </main>
  </div>

  <script>
    function selectColis(id, btn) {
      document.querySelectorAll('.btn-select').forEach(b => {
        b.textContent = 'Sélectionner';
        b.style.background = '#0066cc';
      });
      btn.textContent = '✓ Sélectionné';
      btn.style.background = '#28a745';

      document.getElementById('selectedColis').value = id;
    }
  </script>
</main>
</div>
  <footer class="footer-main">
    &copy; 2025 ETU003973-ETU004346 
  </footer>
</body>

</html>