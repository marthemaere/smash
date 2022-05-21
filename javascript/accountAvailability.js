function usernameCheck() {
  let username = document.querySelector("#username").value;
  let usernameresponse = document.querySelector("#username_response");

  let formData = new FormData();
  formData.append("username", username);

  fetch("ajax/checkUsername.php", {
    method: "POST",
    body: formData
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.availability === 1) {
        usernameresponse.text = "Username available";
        usernameresponse.classList.add("status-available");
      } else {
        usernameresponse.text = "Smash available";
        usernameresponse.classList.add("status-not-available");
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
}
