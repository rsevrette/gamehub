<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $_POST['identifier'] ?? ''; // login OU email
    $password = $_POST['password'] ?? '';

    $errors = [];

    if (empty($identifier)) {
        $errors[] = "Le champ login ou email est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le champ mot de passe est requis.";
    }

    if (!empty($identifier)) {
        $isLogin = preg_match('/^[a-zA-Z0-9]{3,}$/', $identifier);
        $isEmail = preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $identifier);

        if (!$isLogin && !$isEmail) {
            $errors[] = "Veuillez entrer un login valide (lettres/chiffres, 3 caractères min) ou une adresse email valide.";
        }
    }
    if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
    }

    if (!empty($errors)) {
        echo "<h2>Erreurs :</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        $_SESSION['user'] = $identifier;
        echo "<h2>Connexion réussie !</h2>";
        echo "<p>Bienvenue, " . htmlspecialchars($identifier) . " !</p>";
    }
} else {
    echo "<p>Accès non autorisé.</p>";
}
?>