
function loadDepartments(){ 
    
    $('#ddlDepartments').find('option').remove().end();
    
    $.ajax({
            url:"../ticketsService.php",  
            type:"POST",
            data:{
                    data:"getDepartments"
            },
            success:function(msg){
                    msg = $.parseJSON(msg); 
                    for (var index in msg) 
                    {
                        $('#ddlDepartments').append('<option value="'+ msg[index].departmentId +'">' 
                                + msg[index].department + '</option>').val( msg[index].departmentId);                           
                    }
                        $("#ddlDepartments option:first").attr('selected','selected');    
    loadTickets(); 
            },
            dataType:"text"
    });
    
 }
 
$(document).ready(function(){
    loadDepartments();
    $('#divRecords').hide();
 });
 
function loadTickets(){
    $('#divRecords').html('');
    $depId = $('#ddlDepartments').val();
    $.ajax({
            url:"../ticketsService.php",  
            type:"POST",
            data:{
                    data:"getAllTickets",
                    departmentId:$depId
            },
            success:function(msg){
                    msg = $.parseJSON(msg); 
                    if(msg.length>0){
                        $('#divRecords').show("slow");   
                        $newRec = "";
                        for (var index in msg) 
                        {                          
                            $newRec += "<div class='form-group col-md-5'>";
                                 $newRec += "<div class='form-group col-md-12'>";
                                     $newRec += "<label class='col-md-6 control-label'>Ticket Id:</label>";
                                     $newRec += "<div class='col-md-6'>";
                                     $newRec += "<label id='lblTId_'" + msg[index].supportTicketId + "' class='control-label' style='font-weight:normal;'>" + msg[index].supportTicketId + "</label>";
                                     $newRec += "</div>";
                                 $newRec += "</div>";

                                 $newRec += "<div class='form-group col-md-12'>";
                                     $newRec += "<label class='col-md-6 control-label'>Sender Id:</label>";
                                     $newRec += "<div class='col-md-6'>";
                                     $newRec += "<label id='lblSenderId_'" + msg[index].supportTicketId + "' class='control-label' style='font-weight:normal;'>" + msg[index].senderUserId + "</label>";
                                     $newRec += "</div>";
                                 $newRec += "</div>";

                                 $newRec += "<div class='form-group col-md-12'>";
                                     $newRec += "<label class='col-md-6 control-label'>Sender Name:</label>";
                                     $newRec += "<div class='col-md-6'>";
                                     $newRec += "<label id='lblSenderName_'" + msg[index].supportTicketId + "' class='control-label' style='font-weight:normal;'>" + msg[index].senderName + "</label>";
                                     $newRec += "</div>";
                                 $newRec += "</div>";

                                 $newRec += "<div class='form-group col-md-12'>";
                                     $newRec += "<label class='col-md-6 control-label'>Subject:</label>";
                                     $newRec += "<div class='col-md-6'>";
                                     $newRec += "<label id='lblSubject_'" + msg[index].supportTicketId + "' class='control-label' style='font-weight:normal;'>" + msg[index].Subject + "</label>";
                                     $newRec += "</div>";
                                 $newRec += "</div>";

                                 $newRec += "<div class='form-group col-md-12'>";
                                     $newRec += "<label class='col-md-6 control-label'>Date:</label>";
                                     $newRec += "<div class='col-md-6'>";
                                     $newRec += "<label id='lblSDate_'" + msg[index].supportTicketId + "' class='control-label' style='font-weight:normal;'>" + msg[index].submitDate + "</label>";
                                     $newRec += "</div>";
                                 $newRec += "</div>";

                                 $newRec += "<div class='form-group col-md-12'>";
                                     $newRec += "<label class='col-md-6 control-label'>Response:</label>";
                                     $newRec += "<div class='col-md-6'>";
                                     $newRec += "<label id='lblRes_'" + msg[index].supportTicketId + "' class='control-label' style='font-weight:normal;'>" + msg[index].response + "</label>";
                                     $newRec += "</div>";
                                 $newRec += "</div>";

                                 $newRec += "<div  class='form-group col-md-12'>";
                                 $newRec += "<label class='col-md-4 control-label'>&nbsp;</label>";
                                 $newRec += "<div class='col-md-8'>";
                                 $newRec += " <a href='#' id='btnClose' onclick='closeTicket(" + msg[index].supportTicketId + ");return false;' class='btn btn-success'>Close</a>&nbsp;&nbsp;&nbsp;";
                                 $newRec += "<a href='ticketReply.php?ticketId=" + msg[index].supportTicketId + "&uid=" + msg[index].senderUserId + "' id='btnReply' class='btn btn-success'>Reply</a>";
                                 $newRec += "</div>";            
                                 $newRec += "</div>";

                                 $newRec += "<div  class='form-group col-md-12'>";
                                     $newRec += "<hr/>";
                                 $newRec += "</div>";    

                            $newRec += "</div>";    

                            $newRec += "<div class='form-group col-md-1' >";
                            $newRec += "</div>";       
                        } 
                        $('#divRecords').append($newRec);
                    } 
                    else{                        
                            $('#lblMsg').html('No records found.');
                            $('#divRecords').hide("slow"); 
                    }
            },
            dataType:"text"
    });
 }
  
function closeTicket($ticketId){    
    if(confirm('Are you sure to close?'))
    {
        $.ajax({
                url:"../ticketsService.php",  
                type:"POST",
                data:{
                        data:"closeT",
                        tId:$ticketId
                },
                success:function(msg){
                    $('#divRec_' + $ticketId).slideToggle("slow");
                },
                dataType:"text"
        });
    }
}