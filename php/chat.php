<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    if ($_COOKIE['login'] == null && $_COOKIE['ID'] == null) {
        header("Location: login.php");
    }

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
                    echo "Posiadasz już go w zanjomych!!!";
                }
                else {
                    $sql2 = "INSERT INTO friends (users_id, friend_id)
                            VALUES ('$user_id', '$friend_id')";
                    $conn -> query($sql2);

                    echo "Dodano ".$row['login']." do listy znajomych!!!";
                }  
            }
            else {
                $result_search = ($search == '') ? null : "Nie znaleziono takiego Użytkownika!!!";
                return $result_search;
            }
        }    
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

        if ($result -> num_rows > 0) {
            while ($row = $result -> fetch_assoc()) {
                $friendId = $row['friend_id'];
                $friendLogin = $row['login'];
    
                $sql2 = "SELECT file_path 
                         FROM images 
                         WHERE user_id = '$friendId'";
                $result2 = $conn -> query($sql2);
    
                $imgPath = ($result2 -> num_rows > 0) ? $result2 -> fetch_assoc()['file_path'] : 'user.png';
    
                echo "<a href='./chat.php?friend=$friendId&name=$friendLogin' class='friends'>
                        <img src='./profil/$imgPath' alt='Profilowe zdjęcie' class='profilFriend'>
                        <li>$friendLogin</li>
                    </a>";
            }
        }
        else {
            return null;
        }
    }

    function profilUser() {
        global $conn;

        $user_id = $_COOKIE['ID'];

        $sql = "SELECT file_path 
                FROM images 
                WHERE user_id = '$user_id'";
        $result = $conn -> query($sql);

        if ($result -> num_rows > 0) {
            $imgRow = $result -> fetch_assoc()['file_path'];

            echo "<img src='./profil/$imgRow' alt='Profilowe zdjęcie' class='profil'>";
        }
        else {
            echo "<img src='./profil/user.png' alt='Profilowe zdjęcie' class='profil'>";
        }
    }

    // funkcja do napisania i zmiana css od wiadomosci od zera najlepiej 
    function chat() {
        global $conn;

        $user_id = $_COOKIE['ID'];
        $friend_id = (isset($_GET['friend'])) ? $_GET['friend'] : null;
        $friend_login = (isset($_GET['name'])) ? $_GET['name'] : null;

        $sql_select = "SELECT *
                        FROM messages
                        WHERE (sender_id = '$user_id' AND receiver_id = '$friend_id')
                        OR (sender_id = '$friend_id' AND receiver_id = '$user_id')
                        ORDER BY timestamp";
        $result_select = $conn -> query($sql_select);

        if ($result_select -> num_rows > 0) {
            while ($row = $result_select -> fetch_assoc()) {
                $sender = ($row['sender_id'] == $user_id) ? "You" : $friend_login;
                $class = ($sender == $friend_login) ? "other-message" : "my-message";
                $content = $row['content'];

                echo "  <div class='message $class'>
                            <strong>$sender:</strong>
                               $content
                        </div>";
            }
        }
        $sql_insert = "";
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
            <div>
                <?= profilUser();?>
            </div>
            <h3>Witaj, <?=$_COOKIE['login']?>!!!</h3>
            <a href="./changeAccount.php">
                <span class="material-symbols-outlined">
                    settings
                </span>
            </a>
        </div>
        <div id="chat">
            <h3>Czaty:</h3> 
            <form method="POST">
                <input type="text" name="search" id="search" placeholder="Szukaj Znajomych...">
                <input type="submit" value="send" class="material-symbols-outlined">
            </form>
            <p id="searchWynik">
                <?= search(); ?>
            </p>
        </div>
        <hr>
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
            <?= $write = (isset($_GET['name'])) ? $_GET['name'] : null?>
        </header>
        <section id="chat">
            <?= chat()?>
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