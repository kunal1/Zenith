/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){    
    $('#divForm').hide();
    $('#divRecords').show();
    
    $('#btnReply').click(function(e){
        e.preventDefault();
        $('#divForm').slideToggle("slow");
        $('#divRecords').slideToggle("slow");      
        $('#txtMessage').val('');
    });
    
    $('#btnCancel').click(function(e){
        e.preventDefault();
        $('#divForm').slideToggle("slow");
        $('#divRecords').slideToggle("slow");
    });
    
    $('#btnSave').click(function(e){
        e.preventDefault();
        saveReply();
    });
});

function saveReply(){
    $usid = $('#hdUId').val();
    $subDate = new Date($.now());
    $subDate = getNewFormat($subDate.toLocaleString());
    $msg = $('#txtMessage').val();
    $isReply = $('#hdTRep').val();
    
    $.ajax({
            url:"../ticketsService.php",  
            type:"POST",
            data:{
                    data:"saveReply",
                    ticketId:$('#txtId').val(),
                    userId:$usid,
                    submitDate:$subDate,
                    message:$msg,
                    isReplied:$isReply
            },
            success:function(msg){
                if(msg){
                    $newMessage = "<tr>";
                        $newMessage += "<td><div class='meCol'>Me:  </div></td><td><div class='divMe'>" + $msg + "</td></div>";
                    $newMessage += "</tr>";
                    $('#ticketHis tr:last').after($newMessage);
                    
                    $('#lblMsg').html('Message sent!');
                    $('#divForm').slideToggle("slow");
                    $('#divRecords').slideToggle("slow");
                }
            },
            dataType:"text"
    });
}

function getNewFormat(d){
    $all = d.split(' ');
    $dates = $all[0].split('/');
    
    $newDate = $dates[2] + "-" + $dates[0] + "-"+ $dates[1];
    return $newDate + " " + $all[1]; 
}