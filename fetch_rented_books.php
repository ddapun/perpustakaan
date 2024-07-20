<?php
include 'config.php';

$sql = "SELECT book_borrowing.Borrow_ID, user.Name as UserName, admin.Name as AdminName, book_borrowing.Borrow_Date, book_borrowing.Return_Date, book_borrowing.Status FROM book_borrowing
        JOIN user ON book_borrowing.ID_User = user.ID_User
        JOIN admin ON book_borrowing.ID_Admin = admin.id_admin";
$result = $conn->query($sql);

$rentedBooks = array();
while ($row = $result->fetch_assoc()) {
    $rentedBooks[] = $row;
}

echo json_encode($rentedBooks);

$conn->close();
?>
