function fillForm(id) {
    document.getElementById("formCommentId").value = id;    
    document.getElementById("formCommentContent").innerHTML = document.getElementById("commentContent"+id).innerHTML;
    console.log(id);
}