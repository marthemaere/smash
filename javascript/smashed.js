let smashed = document.querySelectorAll("#smashed");

smashed.forEach(function (smash) {
  smash.addEventListener("click", function (e) {
    let smashedPost = smash.dataset.postid;
    console.log(smashedPost);
    let smashedUser = smash.dataset.userid;
    console.log(smashedUser);

    //post naar database AJAX
    let formData = new FormData();
    formData.append("postid", smashedPost);
    formData.append("userid", smashedUser);

    fetch("ajax/smash_project.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.smashed === 1) {
          smash.text = "Smashed 💥";
          smash.classList.add("active");
        } else {
          smash.text = "Smash";
          smash.classList.remove("active");
        }
        console.log("Success:", result);
      })
      .catch((error) => {
        console.log("Error:", error);
      });
    e.preventDefault();
  });
});
