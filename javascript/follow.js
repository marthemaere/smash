let btn = document.querySelector(".follow")

let followerId = btn.dataset.followerid;
let followingId = btn.dataset.followingid;

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
        if(result.isFollowed === true){
            btn.innerHTML = "Following";
            btn.classList.add("active");
        } else {
            btn.innerHTML = "Follow";
            btn.classList.remove("active");
        }
        console.log('Success:', result);
    })
    .catch(error => {
        console.log('Error:', error);
    });
    e.preventDefault();
})