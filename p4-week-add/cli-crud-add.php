<?php
session_start();

// Als er fouten zijn vanuit vorige poging, ophalen
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

// Fouten en form_data meteen wissen zodat niet steeds blijven hangen
unset($_SESSION['errors'], $_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Registreren - Bread Company</title>
    <link rel="stylesheet" href="company.css" />
</head>
<body>
<header>
    <h1>Registreren bij Bread Company</h1>
    <?php include "nav.html"; ?>
</header>

<?php if ($errors): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="cli-crud-add01.php" method="post" novalidate>
    Voornaam:* <br>
    <input type="text" name="first_name" pattern="[A-Za-z ]+" required
        value="<?= htmlspecialchars($form_data['first_name'] ?? '') ?>"><br><br>

    Achternaam:* <br>
    <input type="text" name="last_name" pattern="[A-Za-z ]+" required
        value="<?= htmlspecialchars($form_data['last_name'] ?? '') ?>"><br><br>

    E-mailadres:* <br>
    <input type="email" name="email" required
        value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"><br><br>

    Adres:* <br>
    <input type="text" name="adress" pattern="[A-Za-z0-9 ]+" required
        value="<?= htmlspecialchars($form_data['adress'] ?? '') ?>"><br><br>

    Postcode:* <br>
    <input type="text" name="zipcode" pattern="[A-Za-z0-9 ]+" required
        value="<?= htmlspecialchars($form_data['zipcode'] ?? '') ?>"><br><br>

    Stad:* <br>
    <input type="text" name="city" pattern="[A-Za-z ]+" required
        value="<?= htmlspecialchars($form_data['city'] ?? '') ?>"><br><br>

    Provincie: <br>
    <input type="text" name="state" pattern="[A-Za-z ]*"
        value="<?= htmlspecialchars($form_data['state'] ?? '') ?>"><br><br>

    Land:* <br>
    <select name="country" required>
        <option value="">-- Kies een land --</option>
        <?php
        $landen = ['Nederland', 'België', 'Duitsland', 'Frankrijk'];
        foreach ($landen as $land) {
            $sel = (($form_data['country'] ?? '') === $land) ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($land) . "\" $sel>" . htmlspecialchars($land) . "</option>";
        }
        ?>
    </select><br><br>

    Telefoon: <br>
    <input type="text" name="telephone" pattern="[0-9 ]*"
        value="<?= htmlspecialchars($form_data['telephone'] ?? '') ?>"><br><br>

    Wachtwoord:* <br>
    <input type="password" name="pswrd" required><br><br>

    Bevestig wachtwoord:* <br>
    <input type="password" name="pswrd_confirm" required><br><br>

    <input type="submit" value="Registreren">
</form>

</body>
</html>
