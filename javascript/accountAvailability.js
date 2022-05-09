        $(document).ready(function() {

            $('#txt_username').keyup(function() {
                var username = $(this).val().trim();

                if (username != '') {
                    $.ajax({
                        url: 'accountAvailability.php',
                        type: 'post',
                        data: {username:username},
                        success: function(response) {
                            $('#uname_response').html(response);
                        }
                    });
                } else {
                    $('#uname_response').html("");
                }
            });
        });
