<?php
include 'config.php';

// Ambil data dari form
$isbnArray = $_POST['isbn'];
$titleArray = $_POST['title'];
$authorArray = $_POST['author'];

$response = ['success' => false, 'message' => ''];

try {
    // Siapkan pernyataan SQL untuk memeriksa ISBN duplikat
    $checkStmt = $conn->prepare("SELECT ISBN FROM book WHERE ISBN = ?");
    $checkStmt->bind_param("s", $isbn);

    // Siapkan pernyataan SQL untuk memasukkan data
    $stmt = $conn->prepare("INSERT INTO book (ISBN, Title, Author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $isbn, $title, $author);

    // Array untuk menyimpan ISBN yang sudah ada di database
    $existingIsbns = [];
    $duplicateIsbn = null;

    // Cek setiap ISBN yang diinputkan, jika ada yang sudah ada di database atau diinputkan lebih dari satu kali
    foreach ($isbnArray as $isbn) {
        // Cek duplikasi ISBN di database
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0 || in_array($isbn, $existingIsbns)) {
            $duplicateIsbn = $isbn;
            break; // Hentikan loop jika ditemukan duplikat
        }

        // Tambahkan ISBN ke array existingIsbns
        $existingIsbns[] = $isbn;
    }

    if ($duplicateIsbn) {
        $response['message'] = "Failed to add book: ISBN $duplicateIsbn already exists.";
    } else {
        // Loop melalui data dan masukkan ke database
        for ($i = 0; $i < count($isbnArray); $i++) {
            $isbn = $isbnArray[$i];
            $title = $titleArray[$i];
            $author = $authorArray[$i];
            $stmt->execute();
        }
        $response['success'] = true;
        $response['message'] = 'Book added successfully!';
    }
} catch (Exception $e) {
    $response['message'] = 'Failed to add book: ' . $e->getMessage();
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
