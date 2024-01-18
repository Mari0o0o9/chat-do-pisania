<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    if ($_COOKIE['login'] == null && $_COOKIE['ID'] == null) {
        header("Location: login.php");
    }

    function friendList() {
        global $conn;
        $login = $_COOKIE['login'];
        $id = $_COOKIE['ID'];
        
        $sql = "SELECT friends.friend_id, users.login
                FROM friends
                JOIN users ON users.user_id = friends.friend_id
                WHERE friends.users_id = '$id'";

        $result = $conn -> query($sql);

        while ($row = $result -> fetch_array()) {
            echo "<li>$row[login]</li>";
        }
    }

    // Funkcja nie działa
    function search() {
        global $conn;

        $user_id = $_COOKIE['ID'];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        } 
        else {
            $search = $_POST['search'];

            $sql = "SELECT *
                    FROM users
                    WHERE login = '$search'";
            $result = $conn -> query($sql);
            
            if ($result == true && $result -> num_rows > 0) {
                $row = $result -> fetch_assoc();
                $friend_id = $row['user_id'];

                $sql2 = "SELECT friend_id
                        FROM friends
                        WHERE users_id = '$user_id' AND friend_id = '$friend_id'";
                $result2 = $conn -> query($sql2);

                if ($user_id == $friend_id) {
                    echo "Nie możesz dodać samego siebie!!!";
                }
                elseif ($result2 == true && $result2 -> num_rows > 0) {
                    echo "Posiadasz już użytkownika w zanjomych!!!";
                }
                else {
                    $sql2 = "INSERT INTO friends (users_id, friend_id)
                            VALUES ('$user_id', '$friend_id')";
                    $conn -> query($sql2);

                    echo "Dodano ".$row['login']." do listy znajomych!!!";
                }  
            }
            else {
                echo "Nie znaleziono takiego Użytkownika!!!";
            }
        }    
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleChat.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../zdjecia/favicon.ico" type="image/x-icon">
    <title>Chat</title>
</head>
<body>
    <nav>
        <div id="account">
            <h2>Witaj, <?=$_COOKIE['login']?>!!!</h2>
            <a href="./changeAccount.php">
                <span class="material-symbols-outlined">
                settings
                </span>
            </a>
        </div>
        <div id="chat">
            <h3>Czaty:</h3> 
            <form action="" method="POST">
                <input type="text" name="search" placeholder="Szukaj Znajomych...">
                <input type="submit" value="send" class="material-symbols-outlined">
            </form>
            <p id="searchWynik">
                <?= search(); ?>
            </p>
        </div>
        <div id="friendList">
            <ul>
                <?= friendList();?>
            </ul>
        </div>
        <a href="./login.php" id="logout">
            <div class="material-symbols-outlined">logout</div>
            Wyloguj się
        </a>
    </nav>
    <main>
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
    </main>
</body>
<script src="../JavaScript/chat.js"></script>
</html>
<?php
    $conn -> close(); 
?>