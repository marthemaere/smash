document.querySelector("#btnSubmit").addEventListener("click", function(e) {

    e.preventDefault();

    let postId= e.target.dataset.postId;
    let userId= e.target.dataset.userId;
    let comment= document.querySelector("#comment").value;

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

    });

    //bevestiging
