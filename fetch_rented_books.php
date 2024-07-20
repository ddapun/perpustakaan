<?php
include 'config.php';

// Fetch rented books details
$query = "SELECT bb.Borrow_Date, bb.Return_Date, a.name AS Admin_Name, u.Name AS Borrower_Name, b.Title AS Book_Title
          FROM book_borrowing bb
          JOIN admin a ON bb.ID_Admin = a.id_admin
          JOIN user u ON bb.ID_User = u.ID_User
          JOIN book_borrowing_details bbd ON bb.Borrow_ID = bbd.Borrow_ID
          JOIN book b ON bbd.ISBN = b.ISBN";
$result = $conn->query($query);

$rented_books = array();
while($row = $result->fetch_assoc()) {
    $rented_books[] = $row;
}

echo json_encode($rented_books);

$conn->close();
ob_end_flush();
?>
