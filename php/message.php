<?php
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accontId = $_COOKIE['ID'];
        $friendId = isset($_GET['friend']) ? $_GET['friend'] : null;
        $text = isset($_POST['textSend']) ? $_POST['textSend'] : null;

        $sql = "INSERT INTO messages (sender_id, receiver_id, content)
                VALUES ('$accontId', '$friendId', '$text')";
        $conn -> query($sql);
    }
    else {
        return null;
    }
    $conn -> close(); 
?>