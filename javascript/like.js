let likes= document.querySelectorAll("#likePost");
let number = document.querySelectorAll(".num-of-likes");

likes.forEach(function(like) {

let postId= like.dataset.postid;

like.addEventListener("click", function(e){

    let data= new FormData();
    data.append("postId", postId);

    fetch("ajax/save_like.php", {
        method: 'POST', 
        body: data,
        })
        .then(response => response.json())
        .then(result => {
            if(result.isLiked === true){
                like.src = "assets/images/liked-heart.svg";
                number.forEach(function(num){
                    if(num.dataset.postid === postId){
                        num.innerHTML++;
                    }
                })
                //document.querySelector(".num-of-likes").innerHTML++;
                //btn.classList.add("active");
            } else{
                like.src = "assets/images/empty-heart.svg";
                //btn.classList.remove("active");
                number.forEach(function(num){
                    if(num.dataset.postid === postId){
                        num.innerHTML--;
                        
                    }
                })
            }
            console.log('Success: ', result);
        })
        .catch(error=>{
            console.log('Error: ', error);
        });

        e.preventDefault();
    })
});