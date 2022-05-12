let btnComment= document.querySelector("#btnSubmit");

let postId= btnComment.dataset.postId;
let userId= btnComment.dataset.userId;
let comment= document.querySelector("#comment").value;

btnComment.addEventListener("click", function(e) {

      //ajax
    let data= new FormData();
    data.append("comment", comment);
    data.append("postId", postId);
    data.append("userId", userId);

    fetch("ajax/save_comment.php", {
    method: 'POST', 
    body: data
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success"){
            let li= `<li>${data.data.comment}</li>`;
            document.querySelector("#listupdates").innerHTML += li;
            document.querySelector("#comment").value ="";
        }})
        .then(result => {
            console.log(result);
        })
        .catch(error => {
            console.log(error);
        });

        e.preventDefault();


    });

    //bevestiging
