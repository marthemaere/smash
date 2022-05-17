document.querySelector("#btnSubmit").addEventListener("click", function(e) {

            e.preventDefault();



    let postId= e.target.dataset.postid;
    let userId= e.target.dataset.userid;
    let comment= document.querySelector("#comment").value;


      //ajax
    let data= new FormData();
    data.append("comment", comment);
    data.append("postid", postId);
    data.append("userid", userId);

    fetch("ajax/save_comment.php", {
    method: 'POST', 
    body: data
    })
    .then(response => response.json())
    /*.then(result => {
        let newComment= document.createElement('li');
        newComment.innerHTML= result.body;
        document.querySelector("#comment").appendChild(newComment);
    })*/
    .then(data => {
        if(data.status === "success"){
            let li= `<li>${data.data.comment}</li>`;
            document.querySelector("#listupdates").innerHTML += li;
            document.querySelector("#comment").value ="";
        }})
        .then(result => {
            console.log("success:", result);
        })
        .catch(error => {
            console.log("error:", error);
        });


    });
