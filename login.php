<?php
session_start();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
 
    $errors = [];
    if (empty($login)) {
        $errors[] = "Le champ login est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le champ mot de passe est requis.";
    }
    if (!empty($login) && !preg_match('/^[a-zA-Z0-9]{3,}$/', $login)) {
        $errors[] = "Le login doit contenir uniquement des lettres et des chiffres, et avoir au moins 3 caractères.";
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
        $_SESSION['user'] = $login;
        echo "<h2>Connexion réussie !</h2>";
        echo "<p>Bienvenue, " . htmlspecialchars($login) . " !</p>";
    }
} else {
    echo "<p>Accès non autorisé.</p>";
}
?>