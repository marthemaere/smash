document.querySelector("#report-post").addEventListener("click", function(e) {
    e.preventDefault();
    let postid = e.target.dataset.postid;
    let userid = e.target.dataset.userid;

    
    let formData = new FormData();
    formData.append("postid", postid);
    formData.append("userid", userid);

    fetch("ajax/report__post.php",  {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            console.log(result);
            document.querySelector("#report-success").innerHTML = result.message;
            document.querySelector("#report-success").classList = "alert alert-success m-2 visible";
            document.querySelector('#report-btn').innerHTML = "Reported";
            document.querySelector('#report-btn').classList = "btn btn-danger disabled";
            
        })
        .catch(error => {
            console.log(error);
        })
});

