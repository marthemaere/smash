function checkUsername(){

    $.ajax({
        type:"POST",
        url:"ajax/checkUsername.php",
        cache:false,
        data:{
            type:1,
            username:$("#username").val(),
        },
        success:function(data){
            $("#username_response").html(data);
        }
    });
}


function checkEmail(){

    $.ajax({
        type:"POST",
        url:"ajax/checkEmail.php",
        cache:false,
        data:{
            type:1,
            email:$("#email").val(),
        },
        success:function(data){
            $("#email_response").html(data);
        }
    });
    
}