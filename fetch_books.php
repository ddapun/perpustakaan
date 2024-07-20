<?php
include 'config.php';

// Fetch books from the book table
$query = "SELECT * FROM book";
$result = $conn->query($query);

$books = array();
while($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);

$conn->close();
?>
