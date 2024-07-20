<?php
include 'config.php';

$user_id = $_POST['user_id'];
$admin_id = $_POST['admin_id'];
$borrow_date = $_POST['borrow_date'];
$return_date = $_POST['return_date'];
$isbns = $_POST['isbn'];

$conn->begin_transaction();

try {
    // Insert into Book Borrowing Table
    $stmt = $conn->prepare("INSERT INTO book_borrowing (ID_User, ID_Admin, Borrow_Date, Return_Date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $admin_id, $borrow_date, $return_date);
    $stmt->execute();
    $borrow_id = $stmt->insert_id;

    // Insert into Book Borrowing Details Table
    $stmt = $conn->prepare("INSERT INTO book_borrowing_details (Borrow_ID, ISBN) VALUES (?, ?)");
    foreach ($isbns as $isbn) {
        // Check book quantity
        $stmtCheck = $conn->prepare("SELECT Quantity FROM book WHERE ISBN = ?");
        $stmtCheck->bind_param("s", $isbn);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        $book = $result->fetch_assoc();

        if ($book['Quantity'] > 0) {
            // Decrement book quantity
            $stmtUpdate = $conn->prepare("UPDATE book SET Quantity = Quantity - 1 WHERE ISBN = ?");
            $stmtUpdate->bind_param("s", $isbn);
            $stmtUpdate->execute();

            $stmt->bind_param("is", $borrow_id, $isbn);
            $stmt->execute();
        } else {
            throw new Exception("Book with ISBN $isbn is out of stock!");
        }
    }

    $conn->commit();
    echo "Books rented successfully!";
    header('Location: index.html');
} catch (Exception $e) {
    $conn->rollback();
    echo "Failed to rent books: " . $e->getMessage();
}

$conn->close();
?>
