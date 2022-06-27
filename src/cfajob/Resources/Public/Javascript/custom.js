$('.remove-image-link').click(function(){
    $('.hidden-image-value').val('1');
    $('#container-image-upload').show();
    $('#container-image-current').remove();
    //alert('asdasd');
});

$('.remove-file-link').click(function(){
    $('.hidden-file-value').val('1');
    $('#container-file-upload').show();
    $('#container-file-current').remove();
});

$('.remove-diplome-link').click(function(){
    //$('.hidden-file-value').val('1');
    $('#container-file-upload').show();
    $('.container-diplome-current').remove();
});