document.querySelector("#btnAddComment").addEventListener("click", e => {
    //postid
    //posttext
    //let postId= this.dataset.postid;
    let comment= document.querySelector("#comment").value;

    //console.log(postId);
    console.log(comment);
    console.log(postId);

    //ajax
    let data= new FormData();
    data.append("comment", comment);

    fetch("./ajax/save_comment.php", {
    method: 'POST', // or 'PUT'
    body: data,
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success"){
            let li= `<li>${data.data.comment}</li>`;
            document.querySelector("#listupdates").innerHTML += li;
            document.querySelector("#comment").value ="";
        }
    })
    .catch((error) => {
    console.error('Error:', error);
    });


    e.preventDefault();
})
    //bevestiging
