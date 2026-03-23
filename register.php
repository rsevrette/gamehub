<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $errors = [];

    // Vérifier que tous les champs sont remplis
    if (empty($login)) {
        $errors[] = "Le champ login est requis.";
    }
    if (empty($email)) {
        $errors[] = "Le champ email est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le champ mot de passe est requis.";
    }
    if (empty($confirm_password)) {
        $errors[] = "Le champ confirmation du mot de passe est requis.";
    }

    // Vérifier le format du login
    if (!empty($login) && !preg_match('/^[a-zA-Z0-9]{3,}$/', $login)) {
        $errors[] = "Le login doit contenir uniquement des lettres et des chiffres, et avoir au moins 3 caractères.";
    }

    // Vérifier le format de l'email
    if (!empty($email) && !preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
        $errors[] = "L'email n'est pas valide.";
    }

    // Vérifier le mot de passe
    if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
    }

    // Vérifier que le mot de passe et la confirmation sont identiques
    if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
        $errors[] = "Le mot de passe et la confirmation ne correspondent pas.";
    }

    // Afficher les erreurs ou le succès
    if (!empty($errors)) {
        echo "<h2>Erreurs :</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        echo "<h2>Inscription réussie !</h2>";
        echo "<p>Bienvenue, $login !</p>";
    }
} else {
    echo "<p>Accès non autorisé.</p>";
}
?>