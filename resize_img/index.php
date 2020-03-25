<?php
$error_message = null;
$new_url = null;
function filter_input_($name, $default){
    $result = $default;
    if (isset($_POST[$name]))
        $result = $_POST[$name];
    if (isset($_GET[$name]))
        $result = $_GET[$name];
    return $result;
}

function loadFile(){
    global $error_message, $img_type;
    $submit = filter_input_('input_submit', '');
    if (!empty($submit) && (!empty($_FILES['file']['tmp_name']))) {
        $loaded_file = $_FILES['file'];
        $init_size = getimagesize($loaded_file['tmp_name']);
        //get real size
        $height = $init_size[1];
        $width = $init_size[0];
        //determine img type
        $pos = strpos($loaded_file['name'], '.');
        $img_type = substr($loaded_file['name'], $pos + 1);
        //create img
        $image = null;
        switch ($img_type) {
            case "gif":
                $image = imagecreatefromgif($loaded_file['tmp_name']);
                break;
            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($loaded_file['tmp_name']);
                break;
            case "png":
                $image = imagecreatefrompng($loaded_file['tmp_name']);
                break;
            default: // unsupported type
                break;
        }
        (is_null($image) || is_bool($image)) ? $error_message = 'Unsupported  image type' :
            crop_and_resize($image, $height, $width);
    }
}

function set_text_and_save($im){
    global $img_type, $new_url;
    $text = "     Alyona\nVeprytskaya";
    $font = dirname(__FILE__) . '/ArialBlack.ttf';
    //Write text to the image using TrueType fonts
    imagettftext($im, 10, 0, 10, 20, imagecolorallocate($im, 245, 34, 109), $font, $text);
    // Output the image
    $rnd = rand(0,9999999999);
    $img_name = 'tmp'.$rnd;
    switch ($img_type) {
        case "gif":
            $img_full_name = $img_name.'.gif';
            imagegif($im,$img_full_name);
            break;
        case "jpg":
        case "jpeg":
        case "png":
        $img_full_name = $img_name.".jpeg";
            imagejpeg($im, $img_full_name);
            break;
        default: // unsupported type
            break;
    }
    imagedestroy($im); // Free up memory
    $new_url = "<a href='http://k503labs.ukrdomen.com/535a/Veprytskaya/resize_img/img.php?name=$img_full_name' target='_blank'>Click me</a>";
}

function crop_img($src, array $rect){
    $img = imagecreatetruecolor($rect['width'], $rect['height']);
    imagecopy($img, $src, 0, 0, $rect['x'], $rect['y'], $rect['width'], $rect['height']);
    return $img;
}

function crop_width($image, $height, $width){
    global $crop_width, $crop_height;
    $new_crop_width = round($height * $crop_width / $crop_height);
    $shift = round(($width - $new_crop_width) / 2);
    $arr = array('x' => $shift, 'y' => 0, 'width' => $new_crop_width, 'height' => $height);
    $cropped_image = crop_img($image, $arr);
    $result_image = imagecreatetruecolor($crop_width, $crop_height);
    imagecopyresampled($result_image, $cropped_image, 0, 0, 0, 0, $crop_width, $crop_height, $new_crop_width, $height);
    set_text_and_save($result_image);
}

function crop_height($image, $height, $width){
    global $crop_width, $crop_height;
    $new_crop_height = round($width * $crop_height / $crop_width);
    $shift = round(($height - $new_crop_height) / 2);
    $arr = array('x' => 0, 'y' => $shift, 'width' => $width, 'height' => $new_crop_height);
    $cropped_image = crop_img($image, $arr);
    $result_image = imagecreatetruecolor($crop_width, $crop_height);
    imagecopyresampled($result_image, $cropped_image, 0, 0, 0, 0, $crop_width, $crop_height, $width, $new_crop_height);
    set_text_and_save($result_image);
}

function crop_and_resize($image, $height, $width){
    global $crop_width, $crop_height;
    if ($crop_height > $crop_width) {
        if ($width == $height || $width > $height) {
            crop_width($image, $height, $width);
        } else {
            $coefficient = $crop_width / $crop_height;
            $coefficient2 = $width / $height;
            (($coefficient > 0.5) && ($coefficient > $coefficient2)) ?
                crop_height($image, $height, $width) :
                crop_width($image, $height, $width);
        }
    } elseif ($crop_height < $crop_width) {
        if ($width == $height || $width < $height) {
            crop_height($image, $height, $width);
        } else {
            $coefficient = $crop_height / $crop_width;
            $coefficient2 = $height / $width;
            (($coefficient > 0.5) && ($coefficient > $coefficient2)) ?
                crop_width($image, $height, $width) :
                crop_height($image, $height, $width);
        }
    } else { //$crop_height == $crop_width
        ($height > $width) ? crop_height($image, $height, $width) : crop_width($image, $height, $width);
    }
}
$crop_height = filter_input_('r_height', '');
$crop_width = filter_input_('r_width', '');
loadFile();
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
                <div class="error"><?=$error_message?></div>
                <div class="labels">
                    <div> Result height:</div>
                    <div> Result width:</div>
                </div>
                <div class="inputs">
                    <input type="text" name="r_height" pattern="^[1-9]+[0-9]*$" required value="<?=$crop_height?>">
                    <input type="text" name="r_width" pattern="^[1-9]+[0-9]*$" required value="<?=$crop_width?>">
                </div>
                <input type="file" class="submit" name="file" required>
                <input type="submit" class="submit" name="input_submit" value="Resize">
            </form>
            <div class="output-img">
                <?=$new_url?>
            </div>
        </div>
    </div>
<?php
include "../general/footer.php";