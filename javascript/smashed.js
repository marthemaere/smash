document.querySelector("#smashed").addEventListener("click", function (e) {
  e.preventDefault();
  console.log("smashing it");

  //postId?
  let smashed_post = e.target.dataset.postId;
  console.log(smashed_post);
  let smashed_user = e.target.dataset.userId;
  console.log(smashed_user);

  //post naar database AJAX
  let formData = new FormData();
  formData.append("postId", smashed_post);
  formData.append("userId", smashed_user);


  fetch("ajax/smash_project.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((result) => {
      console.log("Success:", result);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
});
