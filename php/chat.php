<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    $login = $_SESSION['login'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleChat.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Chat</title>
</head>
<body>
    <header>
        Osoba z która piszesz :D
    </header>
    <section id="chat">
        <div class="message other-message">   
            wqewqewquegqwe   
        </div>
        <div class="message my-message">
            sajkdsksadsadasdasdasasadasdsdasda
        </div>
        <div class="message other-message">
            sajkdsksadsadasdasdasasadasdsdasda
        </div>
    </section>
    <footer>
        <input type="text" id="text" placeholder="Napisz wiadomość...">
        <button id="send" class="material-symbols-outlined">
            send
        </button>
    </footer>
</body>
<script src="../JavaScript/chat.js"></script>
</html>
<?php
    $conn -> close(); 
?>