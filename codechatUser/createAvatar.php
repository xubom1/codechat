<?php
    include("src/template.php");
    include("src/utils.php");
    include("../database.php");

    checkSessionElseLogin();
    $db = getDatabase();

    //the index has to correspond with the type number in the db
    $types = [
        1 => 'head',
        2 => 'hair'
    ];

    function make_avatar_type_input($db, $type): string{
        $getComponentPerType = $db->prepare('SELECT * FROM avatarcomponent WHERE type = :type');
        $getComponentPerType->execute(['type' => $type]);
        $components = $getComponentPerType->fetchAll();

        $ret = "<div class='border p-2 row justify-content-center' style='height: 400px'>";

        foreach ($components as $component){
            $imgPath = $component['path'];
            $type = $component['type'];
            $name = $component['name'];
            $id = $component['id'];
            $ret .= "
                <div class='col-md-2 col-lg-3 d-flex justify-content-center m-auto avatarInput'>
                    <input type='radio' id='$id' name='$type'>
                    <label for='$id' title='$name'>
                        <img src='$imgPath' alt='$name' width='100'>
                    </label>
                </div>
            ";
        }

        $ret .= '</div>';

        return $ret;
    }

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head('.', "
        <style>
            input[type='radio']{
                display: none;
            }
            
            input[type='radio'] + label{
                border: 4px solid #0000;
                border-radius: 5px;
                transition: all .2s;
                background-color: #FFF1;
            }
            
            input[type='radio']:checked + label{
                border: 4px solid var(--bs-border-color);
                background-color: rgba(var(--bs-primary-rgb), .2);
            }
        </style>
    ")?>
    <body>
        <?= make_header()?>
        <main codechat-user='<?=$_SESSION['user']?>'>
            <div class="container">
                <div class="d-flex justify-content-between mt-3 align-items-center">
                    <button class="btn btn-secondary" type="button" data-bs-target="#carouselAvatar" data-bs-slide="prev">
                        previous component
                    </button>

                    <div id="avatarContainer">
                        <div class="avatar" codechat-user="<?=$_SESSION['user']?>" size="150"></div>
                    </div>
                    <button class="btn btn-secondary" type="button" data-bs-target="#carouselAvatar" data-bs-slide="next">
                        next Component
                    </button>
                </div>
                <!-- CAROUSEL -->
                <div id="carouselAvatar" class="carousel slide">
                    <div class="carousel-inner">
                        <?php
                            $getAllComponents = $db->query('SELECT type FROM avatarcomponent');
                            $componentsRaw = $getAllComponents->fetchAll(PDO::FETCH_ASSOC);
                            $types = [];

                            //reorganize types array and removing duplicates
                            foreach ($componentsRaw as $component){
                                if (!in_array($component['type'], $types)){
                                    $types[] = $component['type'];
                                }
                            }

                            //loop through different types
                        foreach ($types as $type){
                            $active = ($type == 1) ? 'active' : '';//make the first one active (=showed)
                            echo    "<div class='carousel-item $active'>" .
                                        make_avatar_type_input($db, $type) .
                                    "</div>";
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button onclick="location.href = '/'" class="btn btn-danger m-2">Save Avatar</button>
                    </div>
                </div>
            </div>
            <script src="js/user/createAvatarScript.js"></script>
        </main>
        <?= make_footer()?>
    </body>
</html>