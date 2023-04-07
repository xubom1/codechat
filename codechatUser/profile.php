<?php

include("src/template.php");
include("src/utils.php");
include("../database.php");

checkSessionElseLogin();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme='<?=getColorTheme()?>'>
    <?= make_head() ?>
    <body>
        <?= make_header() ?>
        <!--    MAIN PAGE    -->
        <main>
            <div class="container p-2 border">
                <h2 class="my-4"><em><?=$_SESSION['pseudo']?></em> account page</h2>

<!--            tabs buttons    -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications-tab-pane" type="button" role="tab" aria-controls="publications-tab-pane" aria-selected="false">publications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="likes-tab" data-bs-toggle="tab" data-bs-target="#likes-tab-pane" type="button" role="tab" aria-controls="likes-tab-pane" aria-selected="false">likes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="responses-tab" data-bs-toggle="tab" data-bs-target="#responses-tab-pane" type="button" role="tab" aria-controls="responses-tab-pane" aria-selected="false">responses</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers-tab-pane" type="button" role="tab" aria-controls="followers-tab-pane" aria-selected="false">followers</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="followed-tab" data-bs-toggle="tab" data-bs-target="#followed-tab-pane" type="button" role="tab" aria-controls="followed-tab-pane" aria-selected="false">followed</button>
                    </li>

                </ul>
<!--                tabs content-->
                <div class="tab-content" id="myTabContent">
<!--                    profile tab-->
                    <div class="tab-pane fade show active p-2" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <h4 class="my-3 py-2 ">Your personal information :</h4>
                        <table class="table table-striped table-hover table-borderless profileTable">
                        <?php
                            $db = getDatabase();

                            $cmd = $db->prepare('SELECT * FROM user WHERE id = ?');
                            $cmd->execute([$_SESSION['user']]);
                            $user = $cmd->fetch();

                            function makeLine($title, $display, $modalInputType = null, $bddName = null, $editAttributes = null){
                                $edit = '<br>';
                                if (isset($editAttributes))
                                    $edit = "<img src='../assets/edit.svg' alt='edit' class='editButton p-0' height='20' title='edit $title' $editAttributes>";

                                $ret = "
                                    <tr class='row'>
                                        <th class='col-4'>$title:</th>
                                        <td class='col-4'>$display</td>
                                        <td class='col-4'>$edit</td>
                                    </tr>
                                    ";
                                if (isset($modalInputType)) {
                                    $ret .="
                                    <!--change value -->
                                    <div class='modal' id='$bddName-modal'>
                                      <div class='modal-dialog'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title'>change " . $_SESSION['pseudo'] . "'s $title</h5>
                                                      
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                          </div>
                                          <form action='users/change.php?user=" . $_SESSION['pseudo'] . "&type=$bddName' method='post'>
                                              <div class='modal-body'>
                                                 <label for='name' class='form-label'>New $title</label>
                                                 <input name='$bddName' type='$modalInputType' class='form-control'>
                                              </div>
                                              <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                <button type='submit' class='btn btn-danger'>change</button>
                                              </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                ";
                                }
                                echo $ret;
                            }
                            makeLine('avatar', "<div class='avatar' codechat-user='". $_SESSION['user'] ."'></div>", null, null, 'onclick=\'location.href = "createAvatar.php"\'');
                            makeLine('pseudo', $_SESSION['pseudo'], "text", 'pseudo', '');
                            makeLine('mail', $user['mail'], "text", 'mail', '');
                            makeLine('last name', $user['lastName'], "text", 'lastName', '');
                            makeLine('first name', $user['firstName'], "text", 'firstName', '');
                            makeLine('postal code', $user['postalCode'], "text", 'postalCode', '');
                            makeLine('city', $user['city'], "text", 'city', '');
                            makeLine('address', $user['address'], "text", 'address', '');
                            makeLine('receive newsletter', $user['wantNews']? 'yes' : 'no', "text", 'wantNews', '');
                            makeLine('subscribed', $user['subscription'] ? 'yes' : 'no', "text", 'subscription', '');
                            makeLine('grade', $user['grade'], 'text', 'grade', '');
                            makeLine('account creation date', $user['creation'], 'text', 'creation', '');

                        ?>
                        </table>
                    </div>
<!--                    publication tab-->
                    <div class="tab-pane fade" id="publications-tab-pane" role="tabpanel" aria-labelledby="publications-tab" tabindex="0">
                        <?php
                        //get publication published by the user
                        $cmd = $db->prepare('SELECT id FROM publication WHERE creator = :user AND respondTo IS NULL LIMIT 100');
                        $cmd->execute(['user' => $_SESSION['user']]);
                        $publications = $cmd->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($publications as $publication){
                            echo makePublication($publication['id'], $db);
                        }
                        ?>
                    </div>
<!--                    likes-->
                    <div class="tab-pane fade" id="likes-tab-pane" role="tabpanel" aria-labelledby="likes-tab" tabindex="0">
                        <?php
                        //get publication that user liked
                        $cmd = $db->prepare('SELECT publication.id FROM publication LEFT JOIN liked ON liked.publication = publication.id WHERE liked.user = :user LIMIT 100');
                        $cmd->execute(['user' => $_SESSION['user']]);
                        $publications = $cmd->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($publications as $publication){
                            echo makePublication($publication['id'], $db);
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="responses-tab-pane" role="tabpanel" aria-labelledby="responses-tab" tabindex="0">
                        <?php
                        //get responses created by the user
                        $cmd = $db->prepare('SELECT id FROM publication WHERE creator = :user AND respondTo IS NOT NULL LIMIT 100');
                        $cmd->execute(['user' => $_SESSION['user']]);
                        $publications = $cmd->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($publications as $publication){
                            echo makePublication($publication['id'], $db);
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="followers-tab-pane" role="tabpanel" aria-labelledby="followers-tab" tabindex="0">
                        <?php
                        //get users that follow the user
                        $cmd = $db->prepare('SELECT user.id FROM user CROSS JOIN follow ON follow.follower = user.id WHERE follow.followed = :user');
                        $cmd->execute(['user' => $_SESSION['user']]);
                        $followers = $cmd->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($followers as $follower){
                            echo make_user_presentation($db, $follower['id']);
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="followed-tab-pane" role="tabpanel" aria-labelledby="followed-tab" tabindex="0">
                        <?php
                        //get users that are followed by the user
                        $cmd = $db->prepare('SELECT user.id FROM user CROSS JOIN follow ON follow.followed = user.id WHERE follow.follower = :user');
                        $cmd->execute(['user' => $_SESSION['user']]);
                        $followeds = $cmd->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($followeds as $followed){
                            echo make_user_presentation($db, $followed['id']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>

        <!--    END OF MAIN    -->
        <?= make_footer() ?>
        <script src="js/user/importPublications.js"></script>
    </body>
</html>