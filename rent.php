<?php
include 'config.php';

$user_id = $_POST['user_id'];
$admin_id = $_POST['admin_id'];
$borrow_date = $_POST['borrow_date'];
$return_date = $_POST['return_date'];
$isbns = $_POST['isbn'];

// Validasi tanggal
$current_date = date('Y-m-d');
if ($borrow_date !== $current_date) {
    echo "<script>
            alert('Tanggal Peminjaman harus tanggal sekarang.');
            window.location.href = 'index.html';
          </script>";
    exit();
}

if ($return_date < $borrow_date) {
    echo "<script>
            alert('Tanggal Pengembalian tidak boleh sebelum Tanggal Peminjaman.');
            window.location.href = 'index.html';
          </script>";
    exit();
}

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
        $stmt->bind_param("is", $borrow_id, $isbn);
        $stmt->execute();
    }

    $conn->commit();

    // Tampilkan alert dan redirect ke index.html
    echo "<script>
            alert('Book borrowing successful!');
            window.location.href = 'index.html';
          </script>";
} catch (Exception $e) {
    $conn->rollback();
    // Tampilkan alert error dan redirect ke index.html
    echo "<script>
            alert('Failed to borrow book: " . $e->getMessage() . "');
            window.location.href = 'index.html';
          </script>";
}

$conn->close();
?>
