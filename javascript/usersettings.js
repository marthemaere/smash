let buttonUpload = document.getElementById('upload-new-picture');

buttonUpload.addEventListener('click', e => {
    let uploadFile = document.getElementById('upload-file');
    if(uploadFile.style.display === "none") {
        uploadFile.style.display = "block";
    } else {
        uploadFile.style.display = "none"
    }
});