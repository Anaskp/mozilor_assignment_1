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

    
});

// document.addEventListener('DOMContentLoaded', function() {
//     const deleteButtons = document.querySelectorAll('.delete-user-btn');

//     deleteButtons.forEach(function(button) {
//         button.addEventListener('click', function(event) {
//             // Find the parent <tr> element and get its row index
//             const rowNumber = this.closest('tr').rowIndex;

//             // You can now use the rowNumber in your further logic (e.g., delete the corresponding user)
//             console.log('Clicked on delete button in row: ' + rowNumber);
//         });
//     });
// });

