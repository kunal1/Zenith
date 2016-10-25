<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    // put your code here
    session_start();    
    include_once '../members/memberMasterPage.php';
    require_once '../userInfoDB.php';
    require_once '../commonDB.php';
    require_once '../Database.php';
   
    // note for me(jassi): make the following code querystring based
    $_SESSION['loginUserId'] = 4;
    $_SESSION['userFName'] = "Tunde";
    
    if(!isset($_SESSION['loginUserId']) || empty($_SESSION['loginUserId'])){
            header( 'Location: ../Login.aspx' ) ;
        }
 
        if(isset($_GET["searchUserId"])){
            $searchUserId = $_GET["searchUserId"]; // THIS WILL BE THE VALUE FROM QUERYSTRING
        }
        else {
            $searchUserId = $_SESSION['loginUserId'];
        }
 
        
        // ==================================== THIS CODE IS MUST  (START) ==============================================
        $objPage = new memberMasterPage($_SESSION['loginUserId']);       // THIS INFORMATION COMES FROM SESSIONS ONCE USER LOGS IN;
        $objPage->setTitle('Zenith - Profile'); 
        $objPage->setMetaAuthor('this is meta author');
        // ==================================== THIS CODE IS MUST  (END) ==============================================
    
                               
                              
                                $sex = $_POST['sex'];
                      
                            $agefrom = $_POST['ageFrom'];
                                $ageto = $_POST['ageTo'];
                                $heightfrom = $_POST['heightFrom'];
                                $heightto = $_POST['heightTo'];
                                $maritalstatus = $_POST['maritalStatus'];
                                $religion = $_POST['religion'];
                                $mtoungue = $_POST['mtoungue'];
                                $country = $_POST['country'];
                                $education = $_POST['education'];
                                $withphoto = $_POST['withPhoto'];
                                
                          //$body='  echo "$sex" . " <br/> " . "$agefrom" . " <br/>  " . "$ageto" . " <br/>  " . "$heightfrom" . " <br/>  " . "$heightto" . " <br/> " . "$maritalstatus-" . " <br/> " . "$religion " . " <br/> " . "$mtoungue" . " <br/> " . "$country" . " <br/> " . "$education-" . " <br/> " . "$withphoto"';
                              //  $query = "select tu.firstName,tub.gender,tub.age,tub.height,tub.weight,tub.motherTounge,tub.martialStatus from tbl_users as tu,tbl_userbasicdetails as tub
//where tu.userId=tub.userId";

 
 //-----------------------------------------------
 
     //  $query = "select tu.firstName,tub.gender,tub.age,tub.height,tub.weight,tub.motherTounge,tub.martialStatus from tbl_users as tu,tbl_userbasicdetails as tub
//where tu.userId=tub.userId";
  
   $query2="select * from tbl_userbasicdetails;";
   
                $obj=new commonDB();
              $rows=  $obj->getCountries();
$row=$obj->getSearchResult($sex, $agefrom, $ageto, $heightfrom, $heightto, $maritalstatus, $religion, $country);
             // $row=$obj->getSearchResult('M', 22, 44, 4,6, 'Single', 'Hindu', 'Canada');
if(empty($row))
{
    
}else{
                                foreach ($row as $s) {
                                  $userid=$s["userId"];
                                  $firstname=$s["firstName"];
                                  $gender=$s["gender"];
                                                                    $age=$s["age"];
                                                                    $height=$s["height"];
                                                                    $weight=$s["weight"];
                                                                    $mothertounge=$s["motherTounge"];
                                                                    $martialstatus=$s["martialStatus"];
                                                                    $aboutuser=$s["aboutUser"];
                                                                    $image=$s["image"];

 $body='<table class="table table-striped table-hover table-bordered">
    <tr class="row" >
        <td rowspan="4" ><img src='."{$image}".' alt="image not found"></img> </td>
        <td >Name : </td>
        <td >'
            .  "{$firstname}" .
          '</td>
    </tr>
   <tr class="row" >
        

        <td >Gender : </td>
        <td >'."{$gender}".'</td>
    </tr>
      <tr class="row" >
      
        <td >Age</td>
        <td >'."{$age}".'</td>
    </tr>
      <tr class="row" >
      
        <td >Height : </td>
        <td >'."{$height}".'</td>
    </tr>
     <tr class="row" >
        <td rowspan="3" >'."{$aboutuser}".'</td>
        <td >Weight : </td>
        <td >'."{$weight}".'Kg</td>
    </tr>
     <tr class="row" >
        
        <td >Mother Tounge : </td>
        <td >'."{$mothertounge}".'</td>
    </tr>
     <tr class="row" >
      
        <td >user</td>
        <td >database</td>
    </tr>

</table>';
}}
 $objPage->displayPage($body);               

