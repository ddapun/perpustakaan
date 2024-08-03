<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';

if (!empty($isbn)) {
    $stmt = $conn->prepare("SELECT isbn, title, author FROM book WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);
} else if (!empty($title)) {
    $stmt = $conn->prepare("SELECT isbn, title, author FROM book WHERE title = ?");
    $stmt->bind_param("s", $title);
} else {
    echo json_encode(['status' => 'fail', 'message' => 'No valid input provided']);
    $conn->close();
    exit();
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'fail', 'message' => 'Book not found']);
}

$stmt->close();
$conn->close();
?>
