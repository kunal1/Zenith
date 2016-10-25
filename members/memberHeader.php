<?php
    class memberHeader{
   public function displayHeader(){
       echo "<div class='container'><!-- Container is a class used throughout the document -->
        <div id='logo'><a href='../index.html'><img src='../img/logo.png' alt='Zenith Matrimony'></a></div>
        <div id='login'>
        Welcome, " .  $_SESSION['userFName'] . "  " .
        "<a href='../LoginRegistration/Logout.php'>Logout</a>

        </div>
        </div>";
        }
    }
?>