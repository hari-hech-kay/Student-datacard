function addModal(ele) {

    var id = ele.id;
    var cardBody = document.getElementById(id).lastChild;
    var image = document.getElementById(id).firstChild;
    var children = cardBody.childNodes;

    var name = children[0].innerHTML;
    var desc = children[1].innerHTML;
    var imgsrc = image.getAttribute("src");

    var modalTitle = document.getElementById("title");
    var modalDesc = document.getElementById("desc");
    var modalImg = document.getElementById("image");

    modalTitle.innerHTML = name;
    modalDesc.innerHTML = desc;
    modalImg.setAttribute("src",imgsrc);

}
