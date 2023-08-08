jQuery(document).ready(function ($) 
{
   

    $(".delete-user").click(function (e) 
    { 
        e.preventDefault();
        userId = $(this).attr('id');
        $.ajax({
            type: "post",
            url: public_object.ajax_url,
            data: {
                action : 'delete_user',
                userId : userId
            },
            
            success: function(response) {
                if (response === 'success0') {
                    var table = document.getElementById("up-user-id");
                    var rowNumber = $(e.target).closest('tr')[0].rowIndex;
                    table.deleteRow(rowNumber); 
                }
            },
            error: function() {
                console.log('error');
            },
        });
    });

    $(".delete-post").click(function (e) 
    { 
        e.preventDefault();
        userId = $(this).attr('id');
        $.ajax({
            type: "post",
            url: public_object.ajax_url,
            data: {
                action : 'delete_post',
                userId : userId
            },
            
            success: function(response) {
                if (response === 'success0') {
                    window.location.reload();  
                }
            },
            error: function() {
                console.log('error');
            },
        });
    });

    $("#UP_activate").click(function (e) { 
        e.preventDefault();
        console.log('hello');
        
    });

    
});


