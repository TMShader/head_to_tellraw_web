<link rel="stylesheet" href="style.css">
<link rel="icon" href="https://crafatar.com/avatars/8e437b09425747dba1ef50f5eeef7cfa?size=250&overlay0">
<title>Head to tellraw 1.16+ by TMShader</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function copy(text) {
        $('<p class="command">Here you go:</p>').appendTo(".middle")
        $('<input>').val(text).appendTo('.middle').attr("style", "font-size: 2em; width: 21em;").select()
        $('<p class="command">Just press Ctrl+C ;)</p>').appendTo(".middle")
    }
</script>

<p class="title">Head to tellraw</p>
<p class="subtitle">by TMShader</p>

<?php
    print_r($_REQUEST);
?>

<div class="middle">

<?php

if (isset($_REQUEST['settings'])) {
    include 'settings.php';
    return;
}

if (isset($_REQUEST['get_command']) and empty($_REQUEST['name']) == false) {
    if ($_REQUEST["credits_setting"] == "ON" and $_REQUEST["version_setting"] == "1.16+ (Colored)") {
        $command = escapeshellcmd('python ./getTellraw_credits.py ' . $_REQUEST['name']);
    } elseif ($_REQUEST["credits_setting"] == "ON" and $_REQUEST["version_setting"] == "1.15 (Grayscale)") {
        $command = escapeshellcmd('python ./getTellraw15_credits.py ' . $_REQUEST['name']);
    } elseif ($_REQUEST["credits_setting"] == "OFF" and $_REQUEST["version_setting"] == "1.16+ (Colored)") {
        $command = escapeshellcmd('python ./getTellraw.py ' . $_REQUEST['name']);
    } elseif ($_REQUEST["credits_setting"] == "OFF" and $_REQUEST["version_setting"] == "1.15 (Grayscale)") {
        $command = escapeshellcmd('python ./getTellraw15.py ' . $_REQUEST['name']);
    } else {
        echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        return;
    }
    
    $output = shell_exec($command);
    print_r($_REQUEST);
    print_r("<script type='text/javascript'>setTimeout(() => { copy('" . substr($output, 0, -1) . "')}, 1000);</script>");
    return;
    
}



if (isset($_REQUEST['name']) and empty($_REQUEST['name']) == false) {
    $name = $_REQUEST['name'];
    $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $name);
    if (empty($json) == false) {
        $json_string = json_decode($json, true);
        print_r('<img src="https://crafatar.com/avatars/' . $json_string['id'] . '?size=250&overlay">');
    } else {
        print_r('<p class="error">User not found!</p>');
    }
} else {
    print_r('<img src="https://crafatar.com/avatars/8e437b09425747dba1ef50f5eeef7cfa?size=250&overlay">');
}

?>

    <form method="post" style="margin-top: 1em;">
        <?php
            if (isset($_REQUEST["credits_setting"])) {
                print_r('<input hidden name="credits_setting" type="text" value="' . $_REQUEST["credits_setting"] . '">');
            } else {
                print_r('<input hidden name="credits_setting" type="text" value="ON">');
            }

            if (isset($_REQUEST["version_setting"])) {
                print_r('<input hidden name="version_setting" type="text" value="' . $_REQUEST["version_setting"] . '">');
            } else {
                print_r('<input hidden name="version_setting" type="text" value="1.16+ (Colored)">');
            }
        ?>

        <input type="text" oninput="$('input[name=\'get_command\']').attr('hidden', true); $('input[name=\'get_player\']').removeAttr('hidden');" class="inp" name="name" value="<?php if (isset($json_string)) { print_r($json_string['name']); } ?>">
        <!-- <input hidden type="text" class="inp" name="uname" value="<?php if (isset($json_string)) { print_r($json_string['name']); } ?>"> -->
        <?php 
            if (empty($json) == false) {
                print_r('<input type="submit" class="btn" name="get_command" value="Get Command">');
                print_r('<input type="submit" class="btn" name="get_player" value="Get Player" hidden>');
            }
        ?>
        <?php 
            if (empty($json) == true) {
                print_r('<input type="submit" class="btn" name="get_player" value="Get Player">');
                print_r('<input type="submit" class="btn" name="get_command" value="Get Command" hidden>');
            }
        ?>
    </form>
    <form method="post" style="margin-top: 1em;">
        <?php
            if (isset($_REQUEST["credits_setting"])) {
                print_r('<input hidden name="credits_setting" type="text" value="' . $_REQUEST["credits_setting"] . '">');
            } else {
                print_r('<input hidden name="credits_setting" type="text" value="ON">');
            }

            if (isset($_REQUEST["version_setting"])) {
                print_r('<input hidden name="version_setting" type="text" value="' . $_REQUEST["version_setting"] . '">');
            } else {
                print_r('<input hidden name="version_setting" type="text" value="1.16+ (Colored)">');
            }
        ?>
        <input type="submit" class="btn" name="settings" value="Settings">
    </form>
</div>