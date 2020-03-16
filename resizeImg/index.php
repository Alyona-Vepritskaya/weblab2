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
        //echo $loaded_file['tmp_name'];
        return $_FILES['file'];
    }
    return null;
}

$cropHeight = filter_input_('r_height', '');
$cropWidth = filter_input_('r_width', '');
$loaded_file = loadFile();
$init_size = getimagesize($loaded_file['tmp_name']);
$init_height = $init_size[1];
$init_width = $init_size[0];
/*
 * 1    IMAGETYPE_GIF
 * 2	IMAGETYPE_JPEG
 * 3	IMAGETYPE_PNG
*/
$img_type = exif_imagetype($loaded_file['tmp_name']); //uint

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
    default:
        break;
}
$width = $init_width;
$height = $init_height;
/*$kw = $cropWidth / $width;
$kh = $cropHeight / $height;*/
$k = $cropHeight / $cropWidth;

/*$centreX = round($width / 2);
$centreY = round($height / 2);
$cropWidthHalf = round(($width * $kh - $cropWidth) / 2); // could hard-code this but I'm keeping it flexible
$cropHeightHalf = round(($height * $kw - $cropHeight) / 2);

$x1 = max(0, $centreX - $cropWidthHalf);
$y1 = max(0, $centreY - $cropHeightHalf);*/


if($cropHeight<$cropWidth) {
    if ($k < 1 && $k > 0.5) {
        $newCropWidth = $height * $cropWidth / $cropHeight;
        echo $newCropWidth;
        $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $newCropWidth, 'height' => $height]);
        $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $newCropWidth, $height);
        imagejpeg($image_p, 'example-cropped.jpeg');
    } else {
        $newCropHeight = $width * $cropHeight / $cropWidth;
        echo $newCropHeight;
        $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $newCropHeight]);
        $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $width, $newCropHeight);
        imagejpeg($image_p, 'example-cropped.jpeg');
    }
}else{
    if ($k < 1 && $k > 0.5) {
        $newCropHeight = $width * $cropHeight / $cropWidth;
        echo $newCropHeight;
        $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $newCropHeight]);
        $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $width, $newCropHeight);
        imagejpeg($image_p, 'example-cropped.jpeg');

    } else {
        $newCropWidth = $height * $cropWidth / $cropHeight;
        echo $newCropWidth;
        $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $newCropWidth, 'height' => $height]);
        $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $newCropWidth, $height);
        imagejpeg($image_p, 'example-cropped.jpeg');
    }
}


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
                    <div> Result height:</div>
                    <div> Result width:</div>
                </div>
                <div class="inputs">
                    <input id="r_height" type="text" name="r_height" pattern="^[1-9]+[0-9]*$" required>
                    <input id="r_width" type="text" name="r_width" pattern="^[1-9]+[0-9]*$" required>
                </div>
                <input type="file" class="submit" name="file" required>
                <!--// <input type="hidden" name="get_request" value="<? /*= $dir */ ?>">-->
                <input type="submit" class="submit" name="input_submit" value="Resize">
            </form>
        </div>
    </div>
<?php
include "../general/footer.php";