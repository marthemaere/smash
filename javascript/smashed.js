let smashButton = document.querySelector("#smashed");

let smashedPost = smashButton.dataset.postid;
console.log(smashedPost);
let smashedUser = smashButton.dataset.userid;
console.log(smashedUser);

smashButton.addEventListener("click", function (e) {

  console.log("smashing it");

  //post naar database AJAX
  let formData = new FormData();
  formData.append("postid", smashedPost);
  formData.append("userid", smashedUser);

  fetch("ajax/smash_project.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then(result => {
      if (result.smashed === 1) {
        smashButton.text = "Smashed 💥";
        smashButton.classList.add("active");
      } else {
        smashButton.text = "Smash";
        smashButton.classList.remove("active");
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
  e.preventDefault();
});
