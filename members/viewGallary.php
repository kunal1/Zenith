<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
        include_once '../members/userImagesDB.php';
        if(isset($_GET["sid"])){
            $userId = $_GET["sid"]; // THIS WILL BE THE VALUE FROM QUERYSTRING     
            $objImgs = new userImagesDB();            
            $UserImages = $objImgs->getUserImages($userId);
        }
        else {
            header( 'Location: ../Login.aspx' ) ;
        }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="../galleria/galleria-1.3.5.min.js"></script>
        <script src="../galleria/viewGallary.js"></script>
        <style>
            .galleria{ width: 700px; height: 400px; background: #000 }
        </style>
    </head>
    <body>
        <input type='hidden' name='uid' id='uid' value='<?php echo $userId; ?>' />
        <div id='divImages' class="galleria">
            <?php
                if(count($UserImages)>0)
                {
                    foreach ($UserImages as $img):
                    ?>
                        <a href='../<?php echo $img["image"]; ?>'><img src='../<?php echo $img["thumbnail"]; ?>' data-title='Image' data-big='../<?php echo $img["image"]; ?>'></a>
                        
                    <?php
                    endforeach;                    
                }
            ?>
        </div>
        <script>
            Galleria.loadTheme('../galleria/themes/classic/galleria.classic.min.js');
                Galleria.configure({
                    transition: 'fade',
                     autoplay: 5000
                });
            Galleria.run('.galleria');
        </script>
    </body>
</html>
