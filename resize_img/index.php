<?php
$error_message = null;
$image_to_display = null;// !
function filter_input_($name, $default)
{
    $result = $default;
    if (isset($_POST[$name]))
        $result = $_POST[$name];
    if (isset($_GET[$name]))
        $result = $_GET[$name];
    return $result;
}

function loadFile()
{
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
                $image = imagecreatefromgif($loaded_file['tmp_name']);
                break;
            case 2:
                $image = imagecreatefromjpeg($loaded_file['tmp_name']);
                break;
            case 3:
                $image = imagecreatefrompng($loaded_file['tmp_name']);
                break;
            default: // unsupported type
                break;
        }
        (is_null($image)) ? $error_message = 'Unsupported  image type' :
            crop_and_resize($image, $height, $width);
    }
}

function set_text_and_save($image_p)
{
    global $img_type;
    $text = "     Alyona\nVeprytskaya";
    $font = dirname(__FILE__) . '/ArialBlack.ttf';
    imagettftext($image_p, 10, 0, 10, 20, imagecolorallocate($image_p, 245, 34, 109), $font, $text);
    // header('Content-Type: image/jpeg'); //указываем на тип передаваемых данных
    // Output the image
    switch ($img_type) {
        case 1:
            imagegif($image_p, 'example-cropped.gif');
            break;
        case 2:
            imagejpeg($image_p, 'example-cropped.jpeg');
            break;
        case 3:
            imagepng($image_p, 'example-cropped.png');
            break;
        default: // unsupported type
            break;
    }
    // Free up memory
    imagedestroy($image_p);
}

function crop_width($image, $height, $width)
{
    global $cropWidth, $cropHeight;
    $newCropWidth = round($height * $cropWidth / $cropHeight);
    $shift = round(($width - $newCropWidth) / 2);
    $im2 = imagecrop($image, ['x' => $shift, 'y' => 0, 'width' => $newCropWidth, 'height' => $height]);
    $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
    imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $newCropWidth, $height);
    set_text_and_save($image_p);
}

function crop_height($image, $height, $width)
{
    global $cropWidth, $cropHeight;
    $newCropHeight = round($width * $cropHeight / $cropWidth);
    $shift = round(($height - $newCropHeight) / 2);
    $im2 = imagecrop($image, ['x' => 0, 'y' => $shift, 'width' => $width, 'height' => $newCropHeight]);
    $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
    imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $width, $newCropHeight);
    set_text_and_save($image_p);
}

function crop_and_resize($image, $height, $width)
{
    //TODO
    global $cropWidth, $cropHeight;
    //count coefficient needed size
    $coefficient = round($cropHeight / $cropWidth);
    if ($cropHeight < $cropWidth) {
        ($coefficient < 1 && $coefficient > 0.5) ? crop_width($image, $height, $width) : crop_height($image, $height, $width);
    } else {
        ($coefficient < 1 && $coefficient > 0.5) ? crop_height($image, $height, $width) : crop_width($image, $height, $width);
    }
}

$cropHeight = filter_input_('r_height', '');
$cropWidth = filter_input_('r_width', '');
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
                <div class="error"><?= $error_message ?></div>
                <div class="labels">
                    <div> Result height:</div>
                    <div> Result width:</div>
                </div>
                <div class="inputs">
                    <input id="r_height" type="text" name="r_height" pattern="^[1-9]+[0-9]*$" required
                           value="<?= $cropHeight ?>">
                    <input id="r_width" type="text" name="r_width" pattern="^[1-9]+[0-9]*$" required
                           value="<?= $cropWidth ?>">
                </div>
                <input type="file" class="submit" name="file" required>
                <input type="submit" class="submit" name="input_submit" value="Resize">
            </form>
        </div>
    </div>
<?php
include "../general/footer.php";