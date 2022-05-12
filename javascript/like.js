//let l= document.getElementById("#likePost");
//let notLiked= document.querySelector("#likePost").value= "notLiked";

//if (l.value == "liked"){

document.querySelector("#likePost").addEventListener("click", function(e){
    console.log("we are liking");
    
    e.preventDefault();

    let postId= e.target.dataset.postid;
    let userId= e.target.dataset.userid;

    console.log(postId);
    console.log(userId);

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
                document.querySelector("#likePost").src = "assets/images/liked-heart.svg";
                document.querySelector(".num-of-likes").innerHTML=+1;
                console.log("joepie");
            }
        })
        .then(result => {
            console.log(result);
        })
        .catch((error) => {
            console.log(error);
        });
})/*
} else if (l.value=="liked") {
    document.querySelector("#likePost").addEventListener("click", function(e){
        console.log("we are unliking");
       // e.preventDefault();
    
        let postId= e.target.dataset.postid;
        let userId= e.target.dataset.userid;
    
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
                document.querySelector("#likePost").src = "assets/images/empty-heart.svg";
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
    })
}*/