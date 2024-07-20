<?php
include 'config.php';

$isbn = $_POST['isbn'];

try {
    $stmt = $conn->prepare("DELETE FROM book WHERE ISBN = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    echo "Book deleted successfully!";
} catch (Exception $e) {
    echo "Failed to delete book: " . $e->getMessage();
}

$conn->close();
?>
