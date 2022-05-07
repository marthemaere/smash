let btn = document.querySelector(".follow")

let followerId = btn.dataset.followerid;
let followingId = btn.dataset.followingid;

if (followerId === followingId) {
    btn.style.display = "none";
}

btn.addEventListener("click", (e) => {
    let formData = new FormData();

    formData.append('followerid', followerId);
    formData.append('followingid', followingId);

    fetch('ajax/follow.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if(btn.innerHTML === "Follow"){
            btn.innerHTML = "Following";
        }
        console.log('Success:', result);
    })
    .catch(error => {
        console.log('Error:', error);
    });
    e.preventDefault();
})