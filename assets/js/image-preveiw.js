var modal = document.getElementById('modalImagePreview');
var modalImg = document.getElementById("img01");
var allNum = $('.img-sl').length;
if (typeof selectedIndicator === 'undefined') {
    var selectedIndicator;
}
var next = null;
var prev = null;
$('.other-img-preview').click(function () {
    modal.style.display = "block";
    var modalImga = $(this).attr('src');
    selectedIndicator = $(this).data('num');
    var cc = selectedIndicator + 1;
    $('.img-series').text(cc + ' of ' + allNum);
    modalImg.src = modalImga;
});
$('.close').click(function () {
    modal.style.display = "none";
});
$('.inner-next').click(function () {
    next = selectedIndicator + 1;
    if (next >= allNum) {
        next = 0;
    }
    selectedIndicator = next;
    var cc = next + 1;
    $('.img-series').text(cc + ' of ' + allNum);
    var newSrc = $('[data-num="' + next + '"]').attr('src');
    modalImg.src = newSrc;
});
$('.inner-prev').click(function () {
    prev = selectedIndicator - 1;
    if (prev < 0) {
        prev = allNum - 1;
    }
    selectedIndicator = prev;
    var cc = prev + 1;
    $('.img-series').text(cc + ' of ' + allNum);
    var newSrc = $('[data-num="' + prev + '"]').attr('src');
    modalImg.src = newSrc;
});

$("#inner-slider").on('slide.bs.carousel', function (evt) {
    var thisSlideI = $(this).find('.active').index();
    var nextSlideI = $(evt.relatedTarget).index();
    $('[data-slide-to="' + thisSlideI + '"]').removeClass('active');
    $('[data-slide-to="' + nextSlideI + '"]').addClass('active');
});