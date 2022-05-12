let btn= document.querySelector("#likePost");

let postId= btn.dataset.postid;
let userId= btn.dataset.userid;

btn.addEventListener("click", function(e){
    
    console.log(postId);
    console.log(userId);
    console.log("we are liking");

    let data= new FormData();
    data.append("postId", postId);
    data.append("userId", userId);

    fetch("ajax/save_like.php", {
        method: 'POST', 
        body: data,
        })
        .then(response => response.json())
        .then(result => {
            if(result.isLiked === true){
                btn.src = "assets/images/liked-heart.svg";
                document.querySelector(".num-of-likes").innerHTML++;
                //btn.classList.add("active");
            } else{
                btn.src = "assets/images/empty-heart.svg";
                //btn.classList.remove("active");
                document.querySelector(".num-of-likes").innerHTML--;
            }
            console.log('Success: ', result);
        })
        .catch(error=>{
            console.log('Error: ', error);
        });

        e.preventDefault();
    })