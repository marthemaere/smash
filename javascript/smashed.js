document.querySelector("#smashed").addEventListener("click", function(e){
    console.log("smashing it");
    e.preventDefault();

    let formData = new FormData();
    formData.append("isShowcase", 1);

    fetch("ajax/smash_project.php", {
        method: 'POST', 
        body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === "success"){
                console.log("YOU SMASHED IT");
                document.querySelector("#smashreaction").innerHTML = "YOU SMASHED IT";
                
            }
        })
        .catch((error) => {
            console.log(error);
        });
});