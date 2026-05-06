<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = $_POST['title'] ?? '';
    $genre       = $_POST['genre'] ?? '';
    $description = $_POST['description'] ?? '';
    $image       = $_POST['image'] ?? '';
    $user_id     = $_SESSION['user_id'];

    $errors = [];

    if (empty($title))       $errors[] = "Le titre est requis.";
    if (empty($genre))       $errors[] = "Le genre est requis.";
    if (empty($description)) $errors[] = "La description est requise.";
    if (empty($image))       $errors[] = "Le nom de l'image est requis.";

    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO games (title, genre, description, image, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $genre, $description, $image, $user_id]);

        header("Location: index.php");
        exit;
    }

} else {
    header("Location: add_game.html");
    exit;
}
?>