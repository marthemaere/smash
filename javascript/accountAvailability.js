function usernameCheck() {
  let username = document.querySelector("#username").value;
  let usernameresponse = document.getElementById("usernameresponse");
  console.log(usernameresponse);


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
        usernameresponse.textContent = "Username available";
        usernameresponse.classList.add("status-available");
        console.log(usernameresponse);
      } else {
        usernameresponse.textContent = "Username unavailable";
        usernameresponse.classList.add("status-not-available");
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
}

function emailCheck() {
  let email = document.querySelector("#email").value;
  let emailresponse = document.getElementById("emailresponse");
  console.log(emailresponse);


  let formData = new FormData();
  formData.append("email", email);
  console.log(email);

  fetch("ajax/checkEmail.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.availability === 1) {
        emailresponse.textContent = "Email available";
        emailresponse.classList.add("status-available");
      } else {
        emailresponse.textContent = "Email unavailable";
        //emailresponse.classList.add("status-not-available");
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
}
