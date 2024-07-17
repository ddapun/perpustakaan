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
    $stmt = $conn->prepare("INSERT INTO Book_Borrowing (ID_User, ID_Admin, Borrow_Date, Return_Date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $admin_id, $borrow_date, $return_date);
    $stmt->execute();
    $borrow_id = $stmt->insert_id;

    // Insert into Book Borrowing Details Table
    $stmt = $conn->prepare("INSERT INTO Book_Borrowing_Details (Borrow_ID, ISBN) VALUES (?, ?)");
    foreach ($isbns as $isbn) {
        $stmt->bind_param("is", $borrow_id, $isbn);
        $stmt->execute();
    }

    $conn->commit();
    echo "<script>alert('Books rented successfully!');</script>";
} catch (Exception $e) {
    $conn->rollback();
    echo "<script>alert('Failed to rent books: " . $e->getMessage() . "');</script>";
}

$conn->close();
?>

