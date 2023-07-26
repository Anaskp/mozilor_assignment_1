jQuery(document).ready(function ($) {
    $("#login-form").on('submit', function (e) { 
        e.preventDefault();
        var username = $('#name-id').val();
        var email = $('#email-id').val();
        var nonce = $('#userpost_auth_nonce').val();

        $.ajax({
            type: "post",
            url: public_object.ajax_url,
            data: {
                action: 'auth_submission',
                name : username,
                email : email,
                nonce : nonce
            },
            beforeSend: function() {
                $('#result').html('Submitting...');
            },
            success: function(response) {
                // console.log(nonce)
                // console.log(response)
                if (response === 'success0') {
                    $('#result').html('Auth Successfull');
                    $('#login-form').hide();
                    $('#add-post-form').show();
                } else {
                    $('#result').html('An error occurred while submitting the form.');
                }
            },
            error: function() {
                $('#result').html('An error occurred while submitting the form.');
            },
            
            
        });
        
    });

    $("#add-post-form").submit(function (e) { 
        e.preventDefault();
        var title = $('#title-id').val();
        var content = $('#content-id').val();
        var username = $('#name-id').val();
        var nonce = $('#userpost_post_nonce').val();
        

        $.ajax({
            type: "post",
            url: public_object.ajax_url,
            data: {
                action: 'post_submission',
                title : title,
                content : content,
                username : username,
                nonce : nonce
            },
            success: function(response) {
                //console.log(response)
                if (response === 'success') {
                    $('#result').html('Post submitted successfully');
                    $('#add-post-form').hide();
                    $('#add-post-form')[0].reset();
                    $('#button-div').show();
                } else {
                    $('#result').html('An error occurred while submitting the form.');
                }
            },
            error: function() {
                $('#result').html('An error occurred while submitting the form.');
            },
        });
    });

    $("#add-more").click(function (e) { 
        e.preventDefault();
        $('#button-div').hide();
        $('#add-post-form').show();
    });
   
});