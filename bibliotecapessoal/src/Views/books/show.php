<?php
require_once '../../Models/Book.php';

$bookId = $_GET['id'] ?? null;
$book = null;

if ($bookId) {
    $bookModel = new Book();
    $book = $bookModel->find($bookId);
}

if (!$book) {
    header('Location: index.php');
    exit;
}

include '../layouts/header.php';
?>

<div class="container">
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
    <p><strong>Published:</strong> <?php echo htmlspecialchars($book['published_date']); ?></p>
    <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn btn-primary">Edit</a>
    <a href="index.php" class="btn btn-secondary">Back to List</a>
</div>

<?php include '../layouts/footer.php'; ?>