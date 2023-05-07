<?php
    include("src/template.php");
    include("src/utils.php");
    include("../database.php");

    checkSessionElseLogin(false);
    $db = getDatabase();

    //get all the messages if needed
    $messages = [];
    if (isset($_GET['user'])){

        if ($_GET['user'] === $_SESSION['user']) header('location: /');//discussion with himself case

        $getMessages = $db->prepare('SELECT creation, content, author FROM message WHERE :sessionUser IN (author, receiver) AND :user IN (author, receiver) ORDER BY creation DESC LIMIT 100');
        $getMessages->execute([
            'sessionUser' => $_SESSION['user'],
            'user' => $_GET['user']
        ]);
        $messages = $getMessages->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>' codechat-user='<?=$_SESSION['user']?>'>
    <?= make_head()?>
    <body>
        <?= make_header()?>

        <!--    MAIN PAGE    -->

        <main class="row justify-content-center">
            <div id="leftPanel" class="mainPagePanel col-2 border-start">
                <div>
                    <div id="user" onclick="location.href='profile.php' " class='d-flex align-items-center justify-content-center'>
                        <div class='avatar' codechat-user='<?=$_SESSION['user']?>'></div>
                        <div><?=$_SESSION['pseudo']?></div>
                    </div>
                    <button class='colorModeButton btn btn-outline-success m-2' onclick='switchColorMode()'><?=(($_COOKIE['codechat_theme'] ?? 'light') === 'dark' ? 'light' : 'dark')?> mode</button>
                    <button class="btn btn-secondary" onclick="location.href='events/createEvents.php'"> creat an event</button> <br> <br>
                
                </div>
                <button class="btn btn-secondary" onclick="location.href='/newPublication.php'">new publication</button>
            </div>

            <div id="scrollerContainer" class="col-6 border-start border-end">
                <div id="scroller"></div>
            </div>
            <div id="rightPanel" class="mainPagePanel col-2 border-end p-0">

                <?php
                if (isset($_GET['user'])) {
                    $user = $_GET['user'];
                    $author = $_SESSION['user'];
                    $pseudo = getUserPseudo($user, $db);

                    $messagesHTML = "";
                    foreach ($messages as $message){
                        $content = $message['content'];
                        $type = $message['author'] === $_SESSION['user'] ? 'messageSent' : 'messageReceived';
                        $messagesHTML .= "
                            <div class='message $type'>$content</div>
                        ";
                    }
                    echo "
                        <div id='messagesContainer' class='d-flex flex-column justify-content-between'>
                            <div class='border-bottom py-1 d-flex justify-content-between align-items-center'>
                                <img src='assets/back.svg' onclick='location.href=\"/\"' alt='back' width='30' height='30'>
                                <div class='d-flex align-items-center'>
                                    <div class='avatar' codechat-user='$user'></div>
                                    <div>$pseudo</div>
                                </div>
                                <div class='p-4'></div>
                            </div>
                            <div class='h-100 d-flex flex-column-reverse' id='messages'>
                                $messagesHTML
                            </div>
                            <div class='d-flex'>
                                <input id='messageInput' type='text' name='content' class='form-control' maxlength='255' placeholder='tchat with $pseudo' required>
                                <img src='/assets/send.svg' alt='send' height='40' class='animHover p-1' onclick='newMessage()'>
                            </div>
                        </div>
                    ";
                }
                else{
                    echo "
                        <div class='mt-1 pb-2 border-bottom'>your chats</div>
                        <div id='contactsContainer'></div>
                    ";
                }
                ?>

            </div>
        </main>

        <!--    END OF MAIN    -->
        <?= make_footer()?>
        <script src='js/user/importPublications.js'></script>
        <script src='js/user/msg.js'></script>
    </body>
</html>