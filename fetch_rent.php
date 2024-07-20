<?php
include 'config.php';

$borrow_id = $_GET['borrow_id'];

$sql = "SELECT * FROM book_borrowing WHERE Borrow_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $borrow_id);
$stmt->execute();
$result = $stmt->get_result();
$rentData = $result->fetch_assoc();

echo json_encode($rentData);

$conn->close();
?>
