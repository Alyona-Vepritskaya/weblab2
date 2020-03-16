<?php
function filter_input_($name, $default){
    $result = $default;
    if (isset($_POST[$name]))
        $result = $_POST[$name];
    if (isset($_GET[$name]))
        $result = $_GET[$name];
    return $result;
}

function loadFile(){
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
        //TODO check null
        crop_and_resize($image, $height, $width);
    }
}

function crop_width($image, $height, $width){
    global $cropWidth, $cropHeight;
    $newCropWidth = $height * $cropWidth / $cropHeight;
    $shift = ($width - $newCropWidth) / 2;
    $im2 = imagecrop($image, ['x' => $shift, 'y' => 0, 'width' => $newCropWidth, 'height' => $height]);
    $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
    imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $newCropWidth, $height);
    imagejpeg($image_p, 'example-cropped.jpeg');
}

function crop_height($image, $height, $width){
    global $cropWidth, $cropHeight;
    $newCropHeight = $width * $cropHeight / $cropWidth;
    $shift = ($height - $newCropHeight) / 2;
    $im2 = imagecrop($image, ['x' => 0, 'y' => $shift, 'width' => $width, 'height' => $newCropHeight]);
    $image_p = imagecreatetruecolor($cropWidth, $cropHeight);
    imagecopyresampled($image_p, $im2, 0, 0, 0, 0, $cropWidth, $cropHeight, $width, $newCropHeight);
    imagejpeg($image_p, 'example-cropped.jpeg');
}

function crop_and_resize($image, $height, $width){
    global $cropWidth, $cropHeight;
    //count coefficient needed size
    $coefficient = $cropHeight / $cropWidth;
    ($cropHeight < $cropWidth) ?
        ($coefficient < 1 && $coefficient > 0.5) ?
            crop_width($image, $height, $width) : crop_height($image, $height, $width) :
        ($coefficient < 1 && $coefficient > 0.5) ?
            crop_height($image, $height, $width) : crop_width($image, $height, $width);
}

$cropHeight = filter_input_('r_height', '');
$cropWidth = filter_input_('r_width', '');
loadFile();
//TODO return img to user, output name
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
                    <input type="submit" class="submit" name="input_submit" value="Resize">
                </form>
            </div>
        </div>
<?php
include "../general/footer.php";