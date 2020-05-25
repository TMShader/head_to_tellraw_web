<link rel="stylesheet" href="style.css">

<?php

if (isset($_REQUEST['get_command']) and empty($_REQUEST['name']) == false) {
    $command = escapeshellcmd('py ./getTellraw.py ' . $_REQUEST['name']);
    $output = shell_exec($command);
    print_r('<p class="command">' . $output . '</p>');
    return;
}

?>

<p class="title">Head to tellraw 1.16+</p>
<p class="subtitle">by TMShader</p>

<div class="middle">

<?php

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
        <input type="text" class="inp" name="name" value="<?php if (isset($json_string)) { print_r($json_string['name']); } ?>">
        <!-- <input hidden type="text" class="inp" name="uname" value="<?php if (isset($json_string)) { print_r($json_string['name']); } ?>"> -->
        <?php if (empty($json) == false) { print_r('<input type="submit" class="btn" name="get_command" value="Get Command">'); } ?>
        <input type="submit" class="btn" name="get_player" value="Get Player">
    </form>
</div>
