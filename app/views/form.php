<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle livraison</title>
</head>
<body>

<h2>Nouvelle livraison</h2>

<p><a href="<?= htmlspecialchars($baseUrl ?? '/') ?>">← Retour à l'accueil</a></p>

<?php if (!empty($error)) : ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<?php if (isset($_GET['success'])) : ?>
    <p style="color:green;">
        Livraison enregistrée avec succès
    </p>
<?php endif; ?>

<form action="/livraisons/nouveau" method="post">

    <label>Véhicule :</label><br>
    <select name="idVehicule" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($vehicules as $v) : ?>
            <option value="<?= $v['id'] ?>">
                <?= $v['immatriculation'] ?> - <?= $v['modele'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Livreur :</label><br>
    <select name="idLivreur" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($livreurs as $l) : ?>
            <option value="<?= $l['id'] ?>">
                <?= $l['nom'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Colis :</label><br>
    <select name="idColis" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($colis as $c) : ?>
            <option value="<?= $c['id'] ?>">
                <?= $c['descrip'] ?> (<?= $c['poids_Kg'] ?> kg)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Coût véhicule :</label><br>
    <input type="number" step="0.01" name="coutVehicule" required>
    <br><br>

    <label>Prix par Kg :</label><br>
    <input type="number" step="0.01" name="prixKg" required>
    <br><br>

    <label>Date de livraison :</label><br>
    <input type="date" name="dateLivraison" required>
    <br><br>

    <button type="submit">Enregistrer</button>

</form>

</body>
</html>
