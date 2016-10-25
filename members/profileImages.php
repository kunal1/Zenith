<?php

session_start();
include_once 'memberMasterPage.php';
require_once '../userInfoDB.php';
require_once 'userImagesDB.php';
// DELETE THE FOLLOWING LINE 
if (!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])) {
    header('Location: ../index.php');
}

// ==================================== THIS CODE IS MUST  (START) ==============================================
$objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
$objPage->setTitle('Zenith - My Image Gallery');
// ==================================== THIS CODE IS MUST  (END) ==============================================

$objUserImgs = new userImagesDB();

if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch ($action){
        case 'Delete':
            $thumnail = $_POST['thumbnailurl'];
            $fimage = $_POST['fullimageurl'];
            $fid = $_POST['deleteImageId'];
            $delResult = $objUserImgs->deleteImage($thumnail, $fimage, $fid);
            //echo $fid;
            if($delResult > 0){
                $message = 'Image deleted successfully!';
            }
            break;
    }
}

if (isset($_POST['imgIdNew']) && isset($_POST['imgIdPrev'])) {
    $imgIdNew = $_POST['imgIdNew'];
    if ($imgIdNew != $_POST['imgIdPrev']) {
        $imageChangeResult = $objUserImgs->updateMainImage($imgIdNew, $_SESSION['loginUserId']);
        if($imageChangeResult > 0)
        {
            $message = 'Image changed successfully!';
        }
    }
}

if (isset($_FILES['upImage']['tmp_name']) && !empty($_FILES['upImage']['tmp_name'])) {
    $file = $_FILES['upImage']['tmp_name'];
    $isMainImage = $_POST['main'];
    $success = $objUserImgs->uploadNewImage($file, $isMainImage);
    if ($success) {
        $message = 'Image saved successfully!';
    }
    else
    {
        $message = "Error uploading file!";
    }
}

$imagesAll = $objUserImgs->getUserImages($_SESSION['loginUserId']);

$body = "<form class='form-horizontal' method='post' enctype='multipart/form-data' >";
$body .= "<link href='../styles/profileImages.css' rel='stylesheet'>";
if (isset($message) && !empty($message)) {
    $body .= $message;
    $body .= "<br/>";
} else {
    $body .= "<br/>";
    $body .= "<br/>";
}
$body .= "<div  class='form-group'>";
$body .= "<label class='col-md-5 control-label'>Upload Photo:</label>";
$body .= "<div class='col-md-7'>";
$body .= "<input type='file' name='upImage' class='btn btn-success' />";
$body .= "</div>";
$body .= "</div>";
$body .= "<div  class='form-group'>";
$body .= "<label class='col-md-5 control-label'>Is Main Photo</label>";
$body .= "<div class='col-md-7'>";
$body .= "<input type='radio' name='main' value='1' checked='checked'>Yes";
$body .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$body .= "<input type='radio' name='main' value='0' >No";
$body .= "</div>";
$body .= "</div>";
$body .= "<div  class='form-group'>";
$body .= "<label class='col-md-5 control-label'></label>";
$body .= "<div class='col-md-7'>";
$body .= "<input type='submit' value='Save' class='btn btn-success' />";
$body .= "</div>";
$body .= "</div>";
$body .= "<br />";

$body .= "<fieldset><legend>Image Gallery</legend>";
$body .= "<div  class='form-group'>";
//$body .= "<div class='col-md-12'><hr /></div>";
$body .= "<ul class='gallery'>";
if (count($imagesAll) > 0) {
    foreach ($imagesAll as $value):
        $thumbnailPath = $value['thumbnail'];
        $fullImagePath = $value['image']; 
        $imageId = $value['imageId'];
         
        $isMainImage = $value['isMainImage'];
        $body .= "<li>";
        $body .= "<a href='#'><img src='../{$thumbnailPath}'></a>";
        $body .= "<br />";
        $body .= "<table style='width: 100%;'><tr><td style='text-align: left; height: 40px;'>";
        if ($isMainImage == 1) {
            $body .= "<input name='imgIdPrev' type='hidden' value='{$imageId}'/>";
            $body .= "<input type='radio' name='imgIdNew' checked='checked' value='{$imageId}' onclick='submit();'>Main";
            $body .= "</td>";
        } else {
            $body .= "<input type='radio' name='imgIdNew' value='{$imageId}' onclick='submit();'>Main";
            $body .= "</td>";
            $body .= "<td style='text-align: right; height: 40px;'>";
            $body .= "<form method='POST'>";
            $body .= "<input type='hidden' value='{$imageId}' name='deleteImageId' /> ";     
            $body .= "<input type='hidden' value='{$thumbnailPath}' name='thumbnailurl' /> ";     
            $body .= "<input type='hidden' value='{$fullImagePath}' name='fullimageurl' /> ";            
            $body .= "<input type='submit' name='action' value='Delete' class='btn btn-success' />";
            $body .= "</form>";
            //$body .= "<a href='{$deleteUrl}'>Delete</a>";
            $body .= "</td>";
        }
        $body .= "</tr>";
        $body .= "</table>";
        $body .= "</li>";
    endforeach;
}
$body .= "</ul>";
$body .= "</div>";
$body .= "</fieldset>";
$body .= "</form>";
$objPage->displayPage($body);
?>