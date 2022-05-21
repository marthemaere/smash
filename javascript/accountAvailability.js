function usernameCheck() {
  let username = document.querySelector("#username").value;
  console.log(username);
  let usernameresponse = document.querySelector("#username_response");
  console.log(username);

  let formData = new FormData();
  formData.append("username", username);
  console.log(username);

  fetch("ajax/checkUsername.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.availability === 1) {
        usernameresponse.text = "Username unavailable";
        usernameresponse.classList.add("status-not-available");
      } else {
        usernameresponse.text = "Smash available";
        usernameresponse.classList.add("status-available");
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
}
