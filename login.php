<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($identifier) && !empty($password)) {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? OR email = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header("Location: index.php");
            exit;

        } else {
            echo "Mauvais identifiants de connexion";
        }

    } else {
        echo "Erreur : champs manquants";
    }
}
?>