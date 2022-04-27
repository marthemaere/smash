document.querySelector(".like").addEventListener("click", e =>{
    console.log("we are liking");
    e.preventDefault();

   // e.preventDefault();
    /*let postId= e.target.dataset.post;
    console.log(postId);

    let data= new FormData();
    data.append("postId", postId);

    fetch("./ajax/save_like.php", {
        method: 'POST', // or 'PUT'
        body: data,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.status === "success"){
                document.querySelector(".like").innerHTML = "YOU LIKED THIS";
            }
        })
        .catch((error) => {
        console.error('Error:', error);
        });
    */
})