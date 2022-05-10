document.querySelector("#likePost").addEventListener("click", function(e){
    console.log("we are liking");
    e.preventDefault();

    let postId= e.target.dataset.postId;
    let userId= e.target.dataset.userId;

    let data= new FormData();
    data.append("postId", postId);
    data.append("userId", userId);

    fetch("ajax/save_like.php", {
        method: 'POST', 
        body: data,
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === "success"){
                document.querySelector("#likePost").innerHTML = "YOU LIKED THIS";
                //document.querySelector(".num-of-likes").innerHTML=+1;
                console.log("joepie");
            }
        })
        .then(result => {
            console.log(result);
        })
        .catch((error) => {
            console.log(error);
        });
});/*
} else {
    document.querySelector("#likePost").addEventListener("click", function(e){
        console.log("we are liking");
       // e.preventDefault();
    
        let postId= e.target.dataset.postId;
        let userId= e.target.dataset.userId;
    
        let data= new FormData();
        data.append("postId", postId);
        data.append("userId", userId);
    
        fetch("ajax/save_like.php", {
            method: 'POST', 
            body: data,
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === "success"){
                    document.querySelector("#likePost").innerHTML = "<img src='assets/images/empty-heart.svg'";
                    //document.querySelector(".num-of-likes").innerHTML=+1;
                    console.log("joepie");
                }
            })
            .then(result => {
                console.log(result);
            })
            .catch((error) => {
                console.log(error);
            });
    });*/
