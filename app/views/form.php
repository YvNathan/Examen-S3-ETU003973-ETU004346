<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle livraison</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; padding: 20px; }
.container { max-width: 1200px; margin: 0 auto; }
h2 { font-size: 24px; margin-bottom: 10px; }
.back-link { color: #0066cc; text-decoration: none; display: inline-block; margin-bottom: 20px; font-size: 14px; }
.alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
.alert-error { background: #ffe6e6; color: #cc0000; border: 1px solid #cc0000; }
.alert-success { background: #e6ffe6; color: #006600; border: 1px solid #006600; }
.section { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 24px; margin-bottom: 20px; }
.section-title { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 20px; text-align: center; font-weight: bold; }
.form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px; }
.form-grid-2 { display: grid; grid-template-columns: 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; }
.form-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #666; margin-bottom: 8px; font-weight: bold; }
select, input[type="date"], input[type="number"], input[type="text"] { background: #fff; color: #333; border: 1px solid #ccc; border-radius: 4px; padding: 10px 12px; font-size: 14px; outline: none; }
select { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%23666' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
select:focus, input:focus { border-color: #0066cc; }
.table-section { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 24px; margin-bottom: 20px; }
.table-title { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 16px; font-weight: bold; }
.table-container { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
th { background: #f5f5f5; color: #333; padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold; border: 1px solid #ddd; }
td { padding: 12px; border: 1px solid #ddd; font-size: 14px; }
.btn-select { background: #0066cc; color: #fff; border: none; border-radius: 4px; padding: 6px 16px; font-size: 12px; cursor: pointer; }
.btn-select:hover { background: #0052a3; }
.submit-btn { background: #0066cc; color: #fff; border: none; border-radius: 4px; padding: 12px 32px; font-size: 14px; font-weight: bold; cursor: pointer; }
.submit-btn:hover { background: #0052a3; }
@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>
<div class="container">
  <h2>Nouvelle livraison</h2>
  <p><a href="<?= htmlspecialchars($baseUrl ?? '/') ?>" class="back-link">← Retour à l'accueil</a></p>
  
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
  
  <form action="/livraisons/nouveau" method="post">
    <div class="section">
      <div class="section-title">ENTÊTE</div>
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
          <label class="form-label">Coût</label>
          <input type="number" step="0.01" name="coutVehicule" required>
        </div>
        <div class="form-group">
          <label class="form-label">Prix par Kg</label>
          <input type="number" step="0.01" name="prixKg" required>
        </div>
      </div>
    </div>

    <button type="submit" class="submit-btn">Enregistrer</button>
  </form>
</div>

<script>
function selectColis(id, btn) {
  // Réinitialiser tous les boutons
  document.querySelectorAll('.btn-select').forEach(b => {
    b.textContent = 'Sélectionner';
    b.style.background = '#0066cc';
  });

  // Mettre à jour le bouton sélectionné
  btn.textContent = '✓ Sélectionné';
  btn.style.background = '#28a745';

  // Mettre à jour le champ caché
  document.getElementById('selectedColis').value = id;
}
</script>
</body>
</html>
