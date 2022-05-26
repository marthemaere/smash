document.querySelector("#report-user").addEventListener("click", function(e) {
    console.log("geklikt");
    e.preventDefault();
    let reported_user = e.target.dataset.userid;
    
    let formData = new FormData();
    formData.append("userid", reported_user);

    fetch("ajax/report__user.php",  {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            document.querySelector('#report-btn').innerHTML = "Reported";
            document.querySelector('#report-btn').classList = "btn btn-danger disabled";
            
        })
        .catch(error => {
            console.log(error);
        })
});