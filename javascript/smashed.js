document.querySelector("#smashed").addEventListener("click", function(e){
    console.log("smashing it");
    e.preventDefault();

    fetch("ajax/smash_project.php", {
        method: 'POST', 
        body: data,
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === "success"){
                document.querySelector("#smashreaction").innerHTML = "YOU LIKED THIS";
                console.log("joepie");
            }
        })
        .then(result => {
            console.log(result);
        })
        .catch((error) => {
            console.log(error);
        });
});