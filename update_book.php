<?php
include 'config.php';

$isbn = $_POST['isbn'];
$title = $_POST['title'];
$author = $_POST['author'];

try {
    $stmt = $conn->prepare("UPDATE book SET Title = ?, Author = ? WHERE ISBN = ?");
    $stmt->bind_param("sss", $title, $author, $isbn);
    $stmt->execute();
    echo "Book updated successfully!";
    header('Location: available_books.html');
} catch (Exception $e) {
    echo "Failed to update book: " . $e->getMessage();
}

$conn->close();
?>
