window.onload=function() {
    document.getElementById("upload-btn").disabled = true;

    document.querySelector(".custom-file-input").addEventListener("change", function () {
        document.getElementById("upload-btn").disabled = true;
        var file = this.files[0];
        var filename = this.value.replace("C:\\fakepath\\", "");
        document.getElementById("file-label").innerHTML = filename;
        if (file.size > 1024 * 1024) {
            alert("File size is larger than 1 MB");
            document.getElementById("preview-img").src= "undraw_image_upload_wqh3.svg";
            return;
        }
        if (file.type === "image/jpeg" || file.type === "image/jpg" || file.type === "image/png") {
        } else {
            document.getElementById("preview-img").src= "undraw_image_upload_wqh3.svg";
            alert("Unsupported file type");
            return;
        }

        var PREVIEW_URL = URL.createObjectURL(file);
        document.querySelector("#preview-img").setAttribute("src", PREVIEW_URL);
        document.getElementById("upload-btn").disabled = false;


    });
};
