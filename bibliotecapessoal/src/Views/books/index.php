<?php
require_once '../../Controllers/BookController.php';

$bookController = new BookController();
$books = $bookController->index();

include '../layouts/header.php';
?>

<div class="container">
    <h1>My Personal Library</h1>
    <a href="create.php" class="btn btn-primary">Add New Book</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="show.php?id=<?php echo $book['id']; ?>" class="btn btn-info">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>