/* 
 * Author: Jagsir Singh
 * Date: 29 March 2014
 */

$(document).ready(function(){
    $('#divForm').hide();
    $('#divRecords').show();
    $('#addNew').click(function(e){
        e.preventDefault();
        $('#divRecords').slideToggle("slow");
        $('#divForm').slideToggle("slow");
        $('#txtTitle').val('');
        $('#txtDays').val('');
        $('#txtContact').val('');
        $('#txtPrice').val('');
        $('#txtComments').val('');
        $('#hdnMemId').val(0);
    
        $('#errTitle').html("");
        $('#errDays').html("");
        $('#errContact').html("");
        $('#errPrice').html("");
        $('#errComments').html("");
                    
        $('#btnSU').val('Save');
    });
    
    $('#cancPlan').click(function(e){
        e.preventDefault();
        $('#divRecords').slideToggle("slow");
        $('#divForm').slideToggle("slow");       
    });
    
    $('#btnSU').click(function(e){
        e.preventDefault();
        if($('#hdnMemId').val() == "0"){
            saveMembership();
        }
        else{
            UpdateMembership();
        }
            
    });
    
});

function saveMembership(){
    $title = $('#txtTitle').val();
    $daysA = $('#txtDays').val();
    $contactsA = $('#txtContact').val();
    $priceA = $('#txtPrice').val();
    $comnts = $('#txtComments').val();
    $.ajax({
            url:"../zenithAdmin/membershipService.php",  
            type:"POST",
            data:{
                    data:"svPlan",
                    membership:$title,
                    daysAllowed:$daysA,
                    contactsAllowed:$contactsA,
                    price:$priceA,
                    comments:$comnts
            },
            success:function(memId){
                if($.isNumeric($.parseJSON(memId)))
                {
                    memId = $.parseJSON(memId);               
                    $newMem = "<div class='form-group col-md-6' id='divRec_" + memId + "'>";
                         $newMem += "<div class='form-group col-md-12'>";
                             $newMem += "<label class='col-md-6 control-label'>Title:</label>";
                             $newMem += "<div class='col-md-6'>";
                             $newMem += "<label id='lblTitle_'" + memId + "' class='control-label' style='font-weight:normal;'>" + $title + "</label>";
                             $newMem += "</div>";
                         $newMem += "</div>";

                         $newMem += "<div class='form-group col-md-12'>";
                             $newMem += "<label class='col-md-6 control-label'>Days Allowed:</label>";
                             $newMem += "<div class='col-md-6'>";
                             $newMem += "<label id='lblDays_'" + memId + "' class='control-label' style='font-weight:normal;'>" + $daysA + "</label>";
                             $newMem += "</div>";
                         $newMem += "</div>";

                         $newMem += "<div class='form-group col-md-12'>";
                             $newMem += "<label class='col-md-6 control-label'>Contacts:</label>";
                             $newMem += "<div class='col-md-6'>";
                             $newMem += "<label id='lblContacts_'" + memId + "' class='control-label' style='font-weight:normal;'>" + $contactsA + "</label>";
                             $newMem += "</div>";
                         $newMem += "</div>";

                         $newMem += "<div class='form-group col-md-12'>";
                            $newMem += "<label class='col-md-6 control-label'>Price:</label>";
                            $newMem += "<div class='col-md-6'>";
                            $newMem += "$ ";
                            $newMem += "<label id='lblPrice_'" + memId + "' class='control-label' style='font-weight:normal;'>" + $priceA + "</label>";
                            $newMem += " CA";
                            $newMem += "</div>";
                         $newMem += "</div>";

                         $newMem += "<div class='form-group col-md-12'>";
                            $newMem += "<label id='lblComments_'" + memId + "' class='control-label' style='font-weight:normal;'>" + $comnts + "</label>";
                         $newMem += "</div>";

                         $newMem += "<div  class='form-group col-md-12'>";
                            $newMem += "<label class='col-md-4 control-label'>&nbsp;</label>";
                            $newMem += "<div class='col-md-8'>";
                               $newMem += "<input type='submit' id='updMembership_'" + memId + "' onclick='showUpdate(" + memId + ",";
                               $newMem +=  '"' + $title + '"' + "," + '"' + $daysA + '"' + "," + '"' + $contactsA + '"' + "," + '"' + $priceA + '"' + "," + '"' + $comnts + '"' + "); return false;' value='Edit' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                               $newMem += "<input type='submit' id='delMembership_'" + memId + "' onclick='deleteMembership(" + memId + "); return false;' value='Delete' class='btn btn-success' />";
                            $newMem += "</div>";            
                         $newMem += "</div>";

                         $newMem += "<div  class='form-group col-md-12'>";
                            $newMem += "<hr/>";
                         $newMem += "</div>";    

                    $newMem += "</div>";    

  //                    $newMem += "<div class='form-group col-md-1' >";
  //                    $newMem += "</div>";   
                    $('#divRecords').append($newMem);
                    $('#divRecords').slideToggle("slow");
                    $('#divForm').slideToggle("slow");    
                    $('#lblMsg').html('Membership information added!'); 
                }
                else
                {
                    mId = memId.substring(1, eval(memId.length - 1));
                    $('#errTitle').html("");
                    $('#errDays').html("");
                    $('#errContact').html("");
                    $('#errPrice').html("");
                    $('#errComments').html("");

                    $.each(mId.split(", ").slice(0), function(index, item) {  
                          if(item == "memTitle"){
                              $('#errTitle').html('Please enter valid values');
                          }
                          if(item == "days"){
                              $('#errDays').html('Please enter valid values');
                          } 
                          if(item == "contacts"){
                              $('#errContact').html('Please enter valid values');
                          } 
                          if(item == "price"){
                              $('#errPrice').html('Please enter valid values');
                          } 
                          if(item == "comments"){
                              $('#errComments').html('Please enter valid values');
                          } 
                        });
                }
            },
            dataType:"text"
    });
}

function UpdateMembership(){
    $memberId = $('#hdnMemId').val();
    $title = $('#txtTitle').val();
    $daysA = $('#txtDays').val();
    $contactsA = $('#txtContact').val();
    $priceA = $('#txtPrice').val();
    $comnts = $('#txtComments').val();
    $.ajax({
            url:"../zenithAdmin/membershipService.php",  
            type:"POST",
            data:{
                    data:"updPlan",
                    membershipId:$memberId,
                    membership:$title,
                    daysAllowed:$daysA,
                    contactsAllowed:$contactsA,
                    price:$priceA,
                    comments:$comnts
            },
            success:function(msg){
                if(msg=="true")
                {
                    $('#divRecords').slideToggle("slow");
                    $('#divForm').slideToggle("slow");    
                    $('#lblTitle_' + $memberId).html($title);
                    $('#lblDays_' + $memberId).html($daysA);
                    
                    $('#lblContacts_' + $memberId).html($contactsA);
                    $('#lblPrice_' + $memberId).html($priceA);
                    $('#lblComments_' + $memberId).html($comnts);
                    
                    $('#lblMsg').html('Membership information updated!');                    
                }
                else{
                    msg = msg.substring(1, eval(msg.length - 1));
                   
                    $('#errTitle').html("");
                    $('#errDays').html("");
                    $('#errContact').html("");
                    $('#errPrice').html("");
                    $('#errComments').html("");

                    $.each(msg.split(", ").slice(0), function(index, item) {  
                          if(item == "memTitle"){
                              $('#errTitle').html('Please enter valid values');
                          }
                          if(item == "days"){
                              $('#errDays').html('Please enter valid values');
                          } 
                          if(item == "contacts"){
                              $('#errContact').html('Please enter valid values');
                          } 
                          if(item == "price"){
                              $('#errPrice').html('Please enter valid values');
                          } 
                          if(item == "comments"){
                              $('#errComments').html('Please enter valid values');
                          } 
                        });

                }
            },
            dataType:"text"
    });
}

function showUpdate($membershipId, $title, $days, $contacts, $price, $comments){    
    $('#hdnMemId').val($membershipId);    
//    $('#txtTitle').val($('#lblTitle_' + $membershipId).html());
//    $('#txtDays').val($('#lblDays_' + $membershipId).html());
//    $('#txtContact').val($('#lblContacts_' + $membershipId).html());
//    $('#txtPrice').val($('#lblPrice_' + $membershipId).html());
//    $('#txtComments').val($('#lblComments_' + $membershipId).html());
    $('#txtTitle').val($title);
    $('#txtDays').val($days);
    $('#txtContact').val($contacts);
    $('#txtPrice').val($price);
    $('#txtComments').val($comments);
            
    $('#divRecords').slideToggle("slow");
    $('#divForm').slideToggle("slow");
    $('#btnSU').val('Update');
    
    $('#errTitle').html("");
    $('#errDays').html("");
    $('#errContact').html("");
    $('#errPrice').html("");
    $('#errComments').html("");
    //alert($membershipId);
    //alert($('#lblTitle_' + $membershipId).html());
}

function deleteMembership($membershipId)
{
    if(confirm('Confirm delete!')){
        $.ajax({
                url:"../zenithAdmin/membershipService.php",  
                type:"POST",
                data:{
                        data:"delPlan",
                        planId:$membershipId
                },
                success:function(msg){
                    if(msg)
                    {
                        $('#divRec_' + $membershipId).slideToggle("slow");
                        $('#lblMsg').html('Membership plan deleted!');                    
                    }
                },
                dataType:"text"
        });
        
    }
}
