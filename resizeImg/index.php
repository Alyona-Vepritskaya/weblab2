<?php
function filter_input_($name, $default)
{
    $result = $default;
    if (isset($_POST[$name])) {
        $result = $_POST[$name];
    }
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}


function loadFile()
{
    $submit = filter_input_('input_submit', '');
    if (!empty($submit) && (!empty($_FILES['file']['tmp_name']))) {
        $loaded_file = $_FILES['file'];
    }
}

//Todo

include "../general/header.php"; ?>
    <div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                ReSize
            </div>
        </a>
        <div class="date">
            30 февраля 666
        </div>
    </div>
    <div class="text-content  clearfix">
        <div class="form">
            <form action="index.php" method="post" class="qwerty" enctype="multipart/form-data">
                <div class="labels">
                    <div> Init height:</div>
                    <div> Init width:</div>
                    <div> Result height:</div>
                    <div> Result width:</div>
                </div>
                <div class="inputs">
                    <input id="i_height" type="text" name="i_height">
                    <input id="i_width" type="text" name="i_width">
                    <input id="r_height" type="text" name="r_height">
                    <input id="r_width" type="text" name="r_width">
                </div>
                <input type="file" class="submit" name="file">
                <!--// <input type="hidden" name="get_request" value="<? /*= $dir */ ?>">-->
                <input type="submit" class="submit" name="input_submit" value="Resize">
            </form>
        </div>
    </div>
<?php
include "../general/footer.php";