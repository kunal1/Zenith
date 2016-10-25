<?php
require_once '../Database.php';

class userImagesDB {
    //put your code here
    public static function getUserDefaultThumb($userId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserDefaultThumb(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $conn = null;
        return $rows;
    } 
    
    private function getUsersTotalImages(){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetUsersTotalImages()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $conn = null;
        return $rows;
    }
    
    public function getUserImages($userId){    
        $conn = Database::getDB(); 
        $sql = "CALL spGetUserImages(:UsersId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
//        $stmt->bindParam(1, $second_name, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $conn = null;
        return $rows;
    }
    
    public function updateMainImage($imageId, $userId)    { 
        $conn = Database::getDB(); 
        $sql = "CALL spUpdateUserMainImage(:UsersId, :ImgId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
        $stmt->bindParam('ImgId', $imageId, PDO::PARAM_INT, 11);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        $conn = null;
        return $row_count;
    }

    public function uploadNewImage($file, $isMainImage){
        $result = false;
        $userName = $_SESSION['userFName'];
        $totalImagesInfo = $this->getUsersTotalImages();
        $totalImages = $totalImagesInfo[0]['TotalImages'];
        $image_info = getimagesize($file);
        $image_type = $image_info[2];
        switch($image_type)
        {
            case IMAGETYPE_JPEG:
                $image_ext = ".jpeg";               
                $old_image = imagecreatefromjpeg($file);                
                break;
            case IMAGETYPE_PNG:
                $image_ext = ".png";   
                $old_image = imagecreatefrompng($file); 
                break;
            case IMAGETYPE_GIF:
                $image_ext = ".gif";   
                $old_image = imagecreatefromgif($file); 
                break;
            default :
                $result = false;
                return $result;
        }
        $totalImages++;
        $fullImageName = "images/" . $userName . $totalImages . $image_ext;
        $thumbImageName = "images/" . $userName . $totalImages . "_thumb". $image_ext;
        
        
        $lastImageId = $this->saveNewImage($thumbImageName, $fullImageName, $isMainImage, $_SESSION['loginUserId']);
        if($lastImageId>0)
        {
            // save the original image as it is for full size
            $result1 = move_uploaded_file($file, "../" . $fullImageName);

            // ============= HERE IS CODE FOR THUMBNAIL =========================
            $old_width = imagesx($old_image);
            $old_height = imagesy($old_image);
            $new_width = 194;
            $new_height = 130;

            // create the new image
            $new_image = imagecreatetruecolor($new_width, $new_height);
            //copy old image to new image to resize the file
            $new_x = 0;  // start new image from upper left corner
            $new_y = 0;
            $old_x = 0;  // copy old image from upper left corner
            $old_y = 0;
            imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
            // write the new image to a file
              switch($image_type)
            {
                case IMAGETYPE_JPEG:     
                    imagejpeg($new_image, "../" . $thumbImageName);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($new_image, "../" . $thumbImageName);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($new_image, "../" . $thumbImageName);
                    break;
            }
            // Free any memory associated with the new image
            imagedestroy($new_image);
            imagedestroy($old_image);    

            // ===============  THUMBNAIL CODE ENDS HERE =========================    
            $result = true;            
        }       
        return $result;
    }
    
    private function saveNewImage($thumbnail, $image, $mainImage, $userId){
        try{
            if($mainImage==1){
                $mainImage = true;
            }
            else
            {
                $mainImage = false;
            }
            $conn = Database::getDB(); 
            //$sql = 'CALL spSave(:UsersId, :fullImageName, :thumbnailImageName, :isMain)';
            $sql = 'CALL spSaveImage(:UsersId, :fullImageName, :thumbnailImageName, :isMain)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam('UsersId', $userId, PDO::PARAM_INT, 11);
            $stmt->bindParam('fullImageName', $image, PDO::PARAM_STR, 100);
            $stmt->bindParam('thumbnailImageName', $thumbnail, PDO::PARAM_STR, 100);
            $stmt->bindParam('isMain', $mainImage, PDO::PARAM_BOOL);
            $row_count = $stmt->execute();
            $stmt->closeCursor();
            $lastImageId = $conn->lastInsertId();
            $conn = null;
            return $row_count;
        }
        catch (Exception $e){
            $error_message = $e->getMessage();
            echo $error_message;
            return 0;
        }
    }
    
    public function deleteImage($thumbnail, $image, $imageId)
    {        
        $conn = Database::getDB(); 
        $sql = "CALL spDeleteImage(:ImagesId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('ImagesId', $imageId, PDO::PARAM_INT, 11);
        $row_count = $stmt->execute();
        $stmt->closeCursor();
        if($row_count>0){
            if(file_exists("../" . $thumbnail)){
                unlink("../" . $thumbnail);
            }
            if(file_exists("../" . $image)){
                unlink("../" . $image);
            }
        }
        $conn = null;
        return $row_count;
    }
}
