function checkUsername(){


    let username = document.querySelector("#username");
    let usernameresponse = document.querySelector("#username_response");
    console.log(username); 
    console.log(usernameresponse); 
    
    
    fetch("ajax/checkUsername.php",{
        method: 'POST',
        username:username,
        type: 1,
        cache: false
    })
    .then((response)=> response.json())
    .then((result) =>{
        result = usernameresponse.html(type);
    })
}

//     $.ajax({
//         type:"POST",
//         url:"ajax/checkUsername.php",
//         cache:false,
//         data:{
//             type:1,
//             username:$("#username").val(),
//         },
//         success:function(data){
//             $("#username_response").html(data);
//         }
//     });
// }


// function checkEmail(){

//     $.ajax({
//         type:"POST",
//         url:"ajax/checkEmail.php",
//         cache:false,
//         data:{
//             type:1,
//             email:$("#email").val(),
//         },
//         success:function(data){
//             $("#email_response").html(data);
//         }
//     });
    
// }