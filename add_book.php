<?php
include 'config.php';

$isbn = $_POST['isbn'];
$title = $_POST['title'];
$author = $_POST['author'];

try {
    $stmt = $conn->prepare("INSERT INTO book (ISBN, Title, Author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $isbn, $title, $author);
    $stmt->execute();
    echo "<script>
            alert('Book added successfully!');
            window.location.href = 'available_books.html';
          </script>";
} catch (Exception $e) {
    echo "<script>
            alert('Failed to add book: " . $e->getMessage() . "');
            window.location.href = 'available_books.html';
          </script>";
}

$conn->close();
?>
