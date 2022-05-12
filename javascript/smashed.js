document.querySelector("#smashed").addEventListener("click", function(e){
    console.log("smashing it");
    e.preventDefault();

    //postId?
    let postId = this.dataset.postId;
    console.log(postId);


   
});