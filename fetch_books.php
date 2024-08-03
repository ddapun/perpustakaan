<?php
include 'config.php';

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT * FROM book";
if (!empty($search)) {
    $sql .= " WHERE ISBN LIKE '%$search%' OR Title LIKE '%$search%' OR Author LIKE '%$search%'";
}

$result = $conn->query($sql);

$books = array();
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);

$conn->close();
?>
