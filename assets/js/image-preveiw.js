var modal = document.getElementById('modalImagePreview');
var modalImg = document.getElementById("img01");
$('.other-img-preview').click(function () {
    modal.style.display = "block";
    var modalImga = $(this).attr('src');
    modalImg.src = modalImga;
});
var span = document.getElementsByClassName("close")[0];
span.onclick = function () {
    modal.style.display = "none";
}