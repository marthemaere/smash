function emailCheck() {
  let email = document.querySelector("#email").value;
  let emailresponse = document.getElementById("emailresponse");

  let formData = new FormData();
  formData.append("email", email);

  fetch("ajax/checkEmail.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((result) => {
    if (result.availability === 0) {
        emailresponse.textContent = "Email unavailable";
        emailresponse.style.color = "red";
        //emailresponse.classList.add("status-not-available");
      } else {
        emailresponse.textContent = " ";
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
}

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
   if (result.availability === 0) {
        usernameresponse.textContent = "Username unavailable";
        usernameresponse.style.color = "red";
        //usernameresponse.classList.add("status-not-available");
      } else {
        usernameresponse.textContent = " ";
      }
      console.log("Success:", result);
    })
    .catch((error) => {
      console.log("Error:", error);
    });
}
