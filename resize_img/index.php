<?php
$error_message = null;
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
        //determine img type  -- [ 1 - gif; 2 - jpeg; 3 - png ]
        $img_type = exif_imagetype($loaded_file['tmp_name']); //uint
        //create img
        $image = null;
        switch ($img_type) {
            case 1:
                echo 'gif';
                $image = imagecreatefromgif($loaded_file['tmp_name']);
                break;
            case 2:
                echo 'jpeg';
                $image = imagecreatefromjpeg($loaded_file['tmp_name']);
                break;
            case 3:
                echo 'png';
                $image = imagecreatefrompng($loaded_file['tmp_name']);
                break;
            default: // unsupported type
                break;
        }
        (is_null($image) || is_bool($image)) ? $error_message = 'Unsupported  image type' :
            crop_and_resize($image, $height, $width);
    }
}

function set_text_and_save($img){
    global $img_type;
    echo $img_type;
    $text = "     Alyona\nVeprytskaya";
    $font = dirname(__FILE__) . '/ArialBlack.ttf';
    //Write text to the image using TrueType fonts
    imagettftext($img, 10, 0, 10, 20, imagecolorallocate($img, 245, 34, 109), $font, $text);
    // Output the image
    //header('Content-Type: image/png');//indicates the type of data transmitted
    switch ($img_type) {
        case 1:
            imagegif($img, 'example-cropped.gif');
            break;
        case 2:
            imagejpeg($img, 'example-cropped.jpeg');
            break;
        case 3:
            imagepng($img,'example-cropped.png');
            break;
        default: // unsupported type
            break;
    }
    // Free up memory
    imagedestroy($img);
}

function crop_width($image, $height, $width){
    global $crop_width, $crop_height;
    $new_crop_width = round($height * $crop_width / $crop_height);
    $shift = round(($width - $new_crop_width) / 2);
    $cropped_image = imagecrop($image, ['x' => $shift, 'y' => 0, 'width' => $new_crop_width, 'height' => $height]);
    $result_image = imagecreatetruecolor($crop_width, $crop_height);
    imagecopyresampled($result_image, $cropped_image, 0, 0, 0, 0, $crop_width, $crop_height, $new_crop_width, $height);
    set_text_and_save($result_image);
}

function crop_height($image, $height, $width){
    global $crop_width, $crop_height;
    $new_crop_height = round($width * $crop_height / $crop_width);
    $shift = round(($height - $new_crop_height) / 2);
    $cropped_image = imagecrop($image, ['x' => 0, 'y' => $shift, 'width' => $width, 'height' => $new_crop_height]);
    $result_image = imagecreatetruecolor($crop_width, $crop_height);
    imagecopyresampled($result_image, $cropped_image, 0, 0, 0, 0, $crop_width, $crop_height, $width, $new_crop_height);
    set_text_and_save($result_image);
}

function crop_and_resize($image, $height, $width){
    global $crop_width, $crop_height;
    //count coefficient needed size
    $coefficient = round($crop_height / $crop_width);
    ($crop_height < $crop_width) ?
        (($coefficient < 1 && $coefficient > 0.5) ?
            crop_width($image, $height, $width) : crop_height($image, $height, $width)) :
        (($coefficient < 1 && $coefficient > 0.5) ?
            crop_height($image, $height, $width) : crop_width($image, $height, $width));
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
        </div>
    </div>
<?php
include "../general/footer.php";