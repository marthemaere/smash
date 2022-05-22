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
                console.log(data.status);
                let empty= document.querySelector(".emptyComment");
                if(empty !== null){
                    let li= `<li class="list-group-item border-0 border-bottom mw-80 m-1 d-flex">
                    <div class="d-flex align-items-start"><div class="d-flex align-items-center">
                    <a href="profile.php?p=${data.data.user['id']}"><img src="profile_pictures/${data.data.user['profile_pic']}" class="img-profile-post"></a>
                    <a href="profile.php?p=${data.data.user['id']}"><h4 class="px-3 mb-0">${data.data.user['username']}</h4></a>
                    </div>
                    <div class="mt-1">
                    ${text}
                    </div>
                    </div>
                    </li>`;
                    document.querySelector("#liststart").innerHTML += li;
                    empty.innerHTML="";
                } else {

                 let li= `<li class="list-group-item border-0 border-bottom mw-80 m-1 d-flex">
                 <div class="d-flex align-items-start"><div class="d-flex align-items-center">
                 <a href="profile.php?p=${data.data.user['id']}"><img src="profile_pictures/${data.data.user['profile_pic']}" class="img-profile-post"></a>
                 <a href="profile.php?p=${data.data.user['id']}"><h4 class="px-3 mb-0">${data.data.user['username']}</h4></a>
                 </div>
                 <div class="mt-1">
                 ${text}
                 </div>
                 </div>
                 </li>`;
                 document.querySelector("#listupdates").innerHTML += li;

                }
              /*   let lijst= document.createElement('ul');
                 let block= document.querySelector("#comment_block");
                 block.appendChild(lijst);
                 document.querySelector(lijst).innerHTML += li;*/
                }
          
    })
    
       /* .catch(error => {
            console.error("error:", error);
        });*/


    });
