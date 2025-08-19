<?php
require_once '../../Models/Book.php';

$bookId = $_GET['id'] ?? null;
$book = null;

if ($bookId) {
    $book = Book::find($bookId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($book) {
        $book->title = $title;
        $book->author = $author;
        $book->description = $description;
        $book->save();
    }

    header('Location: /bibliotecapessoal/public/index.php');
    exit;
}
?>

<?php include '../layouts/header.php'; ?>

<h1>Edit Book</h1>

<form action="" method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($book->title ?? '') ?>" required>

    <label for="author">Author:</label>
    <input type="text" name="author" id="author" value="<?= htmlspecialchars($book->author ?? '') ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" required><?= htmlspecialchars($book->description ?? '') ?></textarea>

    <button type="submit">Update Book</button>
</form>

<?php include '../layouts/footer.php'; ?>