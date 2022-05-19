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
                let newComment= document.createElement("ul");
                newComment.classList.add= "list-group list-group-flush";
                newComment.appendChild
                document.querySelector("#listupdates").innerHTML += data.data.comment;
                newComment.innerHTML="<li class='list-group-item d-flex align-items-center border-bottom'>"
                newComment.innerHTML="<a href='profile.php?p=<?php echo $c['id'];?>''><img src='profile_pictures/<?php echo $c['profile_pic']; ?>' class='img-profile-post'></a>"
                newComment.innerHTML="<a href='profile.php?p=<?php echo $c['id'];?>''><h4 class='p-2 mb-0'><?php echo $c['username'];?></h4></a>"
                newComment.innerHTML="<?php echo $c['text']; ?></li>"
                
                //document.classList.add = "list-group list-group-flush";

               // document.querySelector("#comment").value ="";
            }
        /*result => {
        let newComment= document.createElement('li');
        newComment.innerHTML= result.body;
        document.querySelector("#listupdates").appendChild(newComment);
        console.log(result.body);*/
    })
    /*
        .then(result => {
            /*
            let li= document.createElement('li');
            li.innerHTML= result.body;
            document.querySelector("#listupdates").innerHTML += li;
        
            let li= `<ul>${text}</ul>`;
            document.querySelector("#listupdates").innerHTML += li;

        })
        .catch(error => {
            console.error("error:", error);
        });*/

    });
