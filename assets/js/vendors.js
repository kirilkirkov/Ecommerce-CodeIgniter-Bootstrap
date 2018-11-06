$(document).ready(function () {
    // lets give 'active' class to choosed link from nav
    $(".left-side ul li").each(function (index) {
        var currentUrl = window.location.href;
        var urlOfLink = $(this).find('a').attr('href');
        currentUrl = currentUrl.split('?')[0];//remove if contains GET
        if (currentUrl == urlOfLink) {
            $(this).addClass('active');
        }
    });
});

// Upload More Images on publish product
$('.finish-upload').click(function () {
    $('.finish-upload .finish-text').hide();
    $('.finish-upload .loadUploadOthers').show();
    var someFormElement = document.getElementById('uploadImagesForm');
    var formData = new FormData(someFormElement);
    $.ajax({
        url: urls.uploadOthersImages,
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data)
        {
            $('.finish-upload .finish-text').show();
            $('.finish-upload .loadUploadOthers').hide();
            reloadOthersImagesContainer();
            $('#modalMoreImages').modal('hide');
            document.getElementById("uploadImagesForm").reset();
        }
    });
});

$('.orders-page .show-more').click(function () {
    var tr_id = $(this).data('show-tr');
    $('table').find('[data-tr="' + tr_id + '"]').toggle(function () {
        if ($('[data-tr="' + tr_id + '"]').is(':visible')) {
            $('.orders-page .fa-chevron-up').show();
            $('.orders-page .fa-chevron-down').hide();
        } else {
            $('.orders-page .fa-chevron-up').hide();
            $('.orders-page .fa-chevron-down').show();
        }
    });

});

$('.change-ord-status').change(function () {
    var the_id = $(this).data('ord-id');
    var to_status = $(this).val();

    $.post(urls.changeVendorOrdersOrderStatus, {the_id: the_id, to_status: to_status}, function (data) {
        if (data == '0') {
            alert('Error with status change. Please check logs!');
        }
    });
});

$('.locale-change').click(function () {
    var toLocale = $(this).data('locale-change');
    $('.locale-container').hide();
    $('.locale-container-' + toLocale).show();
    $('.locale-change').removeClass('active');
    $(this).addClass('active');
});

function reloadOthersImagesContainer() {
    $('.others-images-container').empty();
    $('.others-images-container').load(urls.loadOthersImages, {"folder": $('[name="folder"]').val()});
}

//products publish
function removeSecondaryProductImage(image, folder, container) {
    $.ajax({
        type: "POST",
        url: urls.removeSecondaryImage,
        data: {image: image, folder: folder}
    }).done(function (data) {
        $('#image-container-' + container).remove();
    });
} 