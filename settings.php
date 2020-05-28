<form method="post">

    <?php
        if (isset($_REQUEST["credits_setting"])) {
            print_r('<input hidden class="credits_setting" name="credits_setting" type="text" value="' . $_REQUEST["credits_setting"] . '">');
            print_r('<input type="button" class="btn credits" value="Add Credits: ' . $_REQUEST["credits_setting"] . '">');
        } else {
            print_r('<input hidden class="credits_setting" name="credits_setting" type="text" value="ON">');
            print_r('<input type="button" class="btn credits" value="Add Credits: ON">');
        }
    ?>

    <br><br>

    <?php
        if (isset($_REQUEST["version_setting"])) {
            print_r('<input hidden class="version_setting" name="version_setting" value="' . $_REQUEST["version_setting"] . '">');
            print_r('<input type="button" class="btn version" value="Version: ' . $_REQUEST["version_setting"] . '">');
        } else {
            print_r('<input hidden class="version_setting" name="version_setting" type="text" value="1.16+ (Colored)">');
            print_r('<input type="button" class="btn version" value="Version: 1.16+ (Colored)">');
        }
    ?>

    <br><br><br><br>
    <input type="submit" class="btn" value="Save">
</form>

<script>
    $(".version").click(function(){
        if ($(".version").val() == "Version: 1.16+ (Colored)") {
            $(".version").val("Version: 1.15 (Grayscale)")
            $("input.version_setting").val("1.15 (Grayscale)")
        }
        else if ($(".version").val() == "Version: 1.15 (Grayscale)") {
            $(".version").val("Version: 1.16+ (Colored)")
            $("input.version_setting").val("1.16+ (Colored)")
        }
    });
    $(".credits").click(function(){
        if ($(".credits").val() == "Add Credits: ON") {
            $(".credits").val("Add Credits: OFF")
            $(".credits_setting").val("OFF")
        }
        else if ($(".credits").val() == "Add Credits: OFF") {
            $(".credits").val("Add Credits: ON")
            $(".credits_setting").val("ON")
        }
    });
</script>