<?php
include 'config.php';

$sql = "SELECT 
    Borrow_ID, 
    Name AS UserName, 
    Phone_Number,
    Address,
    admin.Name AS AdminName, 
    Borrow_Date, 
    Return_Date, 
    Status 
FROM book_borrowing
JOIN admin ON book_borrowing.ID_Admin = admin.ID_Admin";

$result = $conn->query($sql);

$rentedBooks = array();
while ($row = $result->fetch_assoc()) {
    $rentedBooks[] = $row;
}

echo json_encode($rentedBooks);

$conn->close();
?>
