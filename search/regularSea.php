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

        $bodyString='<p id="test"></p>

  <div class="search"><!--   div start for search   -->
<div>
 <form method="post" action="#">
      <table class=\'table table-responsive table-bordered\'>
          <tr><td>Search By Id</td><td><input type=\'text\' ></td><td><input type="submit" value="Search"></td></tr>
      </table>
      </form>
</div>  
</br>
      <p>Regular Search is the most popular search based on a few important criteria one would look for in a life partner</p>
      <h3>Basic Search Criteria</h3>
      <hr />
      <form action="./regularSearchResult.php" method=post onsubmit=return validationCheck()>
      <table>
        <tr>
            <td>Gender : </td>
            <td>Male<input type="radio" name="sex" value="M"  checked="checked" /></td>
            <td colspan="2">Female<input type="radio" name="sex" value="F" /></td>
            
        </tr>
        <tr>
            <td>Age :</td>
            
            <td><input type="text" size="2" name="ageFrom" required="required"> </td>
            <td >to</td>
              <td><input type="text" size="2" name="ageTo"  required="required"> </td>
        </tr>
       <tr>
            <td>Height : </td>
            
            <td>
               
                <select name="heightFrom">
                    <option value="4" >4ft 4in</option>
                                        <option value="4" >4ft 6in</option> 
                    <option value="4" >4ft 8in</option> 
                    <option value="4" >4ft 10in</option> 
                    <option value="4" >4ft 12in</option> 
<option value="5" >5ft 2in</option>
                    <option value="5" >5ft 4in</option>
                    <option value="5" >5ft 6in</option>
                    <option value="5" >5ft 8in</option>
                    <option value="5" >5ft 10in</option>
                    <option value="5" >5ft 12in</option>
                    <option value="6" >6ft 2in</option>
                      <option value="6" >6ft 4in</option>
                        <option value="6" >6ft 6in</option>
                          <option value="6" >6ft 8in</option>
                            <option value="6" >6ft 10in</option>
                              <option value="6" >6ft 12in</option>
                              <option value="7" >7ft Plus </option>
                </select> </td>
            <td >to</td>
            <td><select name="heightTo">
                <option value="4" >4ft 4in</option>
                                        <option value="4" >4ft 6in</option> 
                    <option value="4" >4ft 8in</option> 
                    <option value="4" >4ft 10in</option> 
                    <option value="4" >4ft 12in</option> 
<option value="5" >5ft 2in</option>
                    <option value="5" >5ft 4in</option>
                    <option value="5" >5ft 6in</option>
                    <option value="5" >5ft 8in</option>
                    <option value="5" >5ft 10in</option>
                    <option value="5" >5ft 12in</option>
                    <option value="6" >6ft 2in</option>
                      <option value="6" >6ft 4in</option>
                        <option value="6" >6ft 6in</option>
                          <option value="6" >6ft 8in</option>
                            <option value="6" >6ft 10in</option>
                              <option value="6" >6ft 12in</option>
                              <option value="7" >7ft Plus </option>
                </select> </td>
        </tr>
        <tr>
            <td>Marital status :</td>
            <td colspan="3">Any <input type="checkbox" name="maritalStatus" value="Single" >
            Unmarried <input type="checkbox" name="maritalStatus" value="Single" checked="checked">
           Widow <input type="checkbox" name="maritalStatus" value="Widow">
                      Divorced <input type="checkbox" name="maritalStatus" value="Divorced">
           

            </td>
           
        </tr>
        <tr>
            <td>Religions :</td>
            <td colspan="3"> <select name="religion">
                     <option value="-1">Select Religion...</option>';
                $res = commonDB::getReligions();
                   foreach ($res as $r) { 
                       $id = $r["religionId"]; 
                       $val = $r["religion"]; 
        $bodyString .= "<option value='{$id}'>{$val}</option>";
                 }
               $bodyString .= '</select></td>
        </tr>
          <tr>
            <td>Mother Tongue :</td>
            <td colspan="3"><input type="text" name="mtoungue"></td>
        </tr>
         <tr>
            <td>Country :</td>
            <td colspan="3"> <select name="country">
                     <option value="-1">Select Country...</option>';
                $res1 = commonDB::getCountries();
                   foreach ($res1 as $r) { 
                       $id = $r["countryId"]; 
                       $val = $r["countryName"]; 
        $bodyString .= "<option value='{$val}'>{$val}</option>";
                 }
               $bodyString .= '</select></td>
        </tr>
         <tr>
            <td>Education :</td>
            <td colspan="3"><select name="education">
                    <option value="-1">Education...</option>
                    <option value="Information Technology">Information Technology</option>
                     <option value="Web Developer">Web Developer</option>
                     <option value="Architecture and Engineering">Architecture and Engineering</option>
                     <option value="Arts, Design, Entertainment, Sports, and Media" >Arts, Design, Entertainment, Sports, and Media</option>
                     <option value="Business and Financial Operations" >Business and Financial Operations</option>
                      <option value="Community and Social Service" >Community and Social Service</option>
                       <option value="Construction and Extraction" >Construction and Extraction</option>
                        <option value="Healthcare Practitioners and Technical" >Healthcare Practitioners and Technical</option>
                         <option value="other" >Other</option>
 </select>
            </td>
        </tr>
        <tr>
            <td>Show Profile :</td>
            <td>With Photo <input type="radio" name="withPhoto" value="1"></td>
            <td colspan="2">Any <input type="radio" name="withPhoto" value="2" checked="checked"></td>
        </tr>
        <tr>
            <td colspan="4"><input type="submit" name="submitForm"   value="Search"></td>
        
        </tr>
       
    </table>
    </form>
      <div id="errorMassage"></div>
 <!--   code end for search   -->
  </div><!-- end of div search -->';
 
  $objPage->displayPage($bodyString);
              
        ?>