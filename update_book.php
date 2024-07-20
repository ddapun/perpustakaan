<?php
include 'config.php';

$isbn = $_POST['isbn'];
$title = $_POST['title'];
$author = $_POST['author'];
$quantity = $_POST['quantity'];

try {
    $stmt = $conn->prepare("UPDATE book SET Title = ?, Author = ?, Quantity = ? WHERE ISBN = ?");
    $stmt->bind_param("ssis", $title, $author, $quantity, $isbn);
    $stmt->execute();
    echo "Book updated successfully!";
    header('Location: available_books.html');
} catch (Exception $e) {
    echo "Failed to update book: " . $e->getMessage();
}

$conn->close();
?>
