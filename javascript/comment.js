document.querySelector("#btnSubmit").addEventListener("click", function(e) {

    console.log("klik");

    e.preventDefault();
    let postId= e.target.dataset.postid;
    let userId= e.target.dataset.userid;
    let text= document.querySelector("#comment").value;

    console.log(postId);
    console.log(userId);
    console.log(text);

    //ajax
    let data= new FormData();
    data.append("text", text);
    data.append("postid", postId);
    data.append("userid", userId);

    fetch("ajax/save_comment.php", {
    method: 'POST', 
    body: data
    })
    .then(response => response.json())
    .then(
        data => {
            if(data.status === "success"){
                console.log(data.data);
                 let li= `<li class="list-group-item d-flex border-0 border-bottom align-items-center"><a href="profile.php?p=${data.data.user['id']}"><img src="profile_pictures/${data.data.user['profile_pic']}" class="img-profile-post"></a>
                 <a href="profile.php?p=${data.data.user['id']}">
                     <h4 class="p-2 mb-0">${data.data.user['username']}</h4>
                 </a>${text}</li>`;
                 document.querySelector("#listupdates").innerHTML += li;
                }
          
    })
    
        .catch(error => {
            console.error("error:", error);
        });

    });
