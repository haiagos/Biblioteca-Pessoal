<?php
// This file is for creating a new book entry in the personal library.

require_once '../../Controllers/BookController.php';

$bookController = new BookController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $year = $_POST['year'] ?? '';

    $result = $bookController->createBook($title, $author, $year);

    if ($result) {
        header('Location: /bibliotecapessoal/src/Views/books/index.php');
        exit();
    } else {
        $error = "Failed to create book. Please try again.";
    }
}
?>

<?php include '../layouts/header.php'; ?>

<h1>Create a New Book</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="create.php" method="POST">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    
    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required>
    
    <label for="year">Year:</label>
    <input type="number" id="year" name="year" required>
    
    <button type="submit">Create Book</button>
</form>

<?php include '../layouts/footer.php'; ?>