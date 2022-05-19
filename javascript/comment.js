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
                 let li= `<li class="list-group-item d-flex border-0 border-bottom align-items-center">${text}</li>`;
                 document.querySelector("#listupdates").innerHTML += li;

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

        })*/
        .catch(error => {
            console.error("error:", error);
        });

    });
