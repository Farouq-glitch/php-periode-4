<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['confirm'])) {
    header('Location: cli-crud-add.php');
    exit;
}

if (!isset($_SESSION['form_data'])) {
    header('Location: cli-crud-add.php');
    exit;
}

$data = $_SESSION['form_data'];

// Hash wachtwoord
$hashedPassword = password_hash($data['pswrd'], PASSWORD_DEFAULT);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=bread_company", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO client 
        (first_name, last_name, email, adress, zipcode, city, state, country, telephone, pswrd, isadmin)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'N')");

    $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $data['adress'],
        $data['zipcode'],
        $data['city'],
        $data['state'],
        $data['country'],
        $data['telephone'],
        $hashedPassword
    ]);

    // Succesmelding
    echo "<!DOCTYPE html>
    <html lang='nl'>
    <head>
        <meta charset='UTF-8'>
        <title>Registratie geslaagd</title>
        <link rel='stylesheet' href='company.css'>
    </head>
    <body>
    <header>
        <h1>Registratie succesvol!</h1>
        ";
    include "nav.html";
    echo "
    </header>
    <p>Dank je wel voor je registratie, " . htmlspecialchars($data['first_name']) . ".</p>
    <p>Je kunt nu inloggen met je e-mailadres.</p>
    </body>
    </html>";

    // Data uit session verwijderen zodat bij refresh geen herhaalde insert
    unset($_SESSION['form_data']);

} catch (PDOException $e) {
    echo "Fout bij het opslaan in de database: " . htmlspecialchars($e->getMessage());
}
?>
