<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $errors = [];

    // Vérifications
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

    if (!empty($login) && !preg_match('/^[a-zA-Z0-9]{3,}$/', $login)) {
        $errors[] = "Login invalide.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $errors[] = "Mot de passe trop faible.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? OR email = ?");
        $stmt->execute([$login, $email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user['login'] === $login) {
                $errors[] = "Login déjà utilisé.";
            }
            if ($user['email'] === $email) {
                $errors[] = "Email déjà utilisé.";
            }
        }
    }
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$login, $email, $hashedPassword]);

        echo "<p>Utilisateur créé avec succès !</p>";
    }

} else {
    echo "<p>Accès non autorisé.</p>";
}
?>