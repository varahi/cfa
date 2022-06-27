$(document).ready(function(){

    $('input.custom-checkbox').iCheck('destroy');

    var chosen = "";
    var $items = jQuery('.item');
    var $cats = jQuery('#list-category input[type=checkbox]');

    $cats.on('change', function (e) {
        var cats = $cats.filter(':checked').map(function(){
            return 'cat-' + (this.value || '')
        }).get();
        if(cats.length){
            var $fitems = $items;
            var addchosen = "";
            if (chosen) {
                addchosen =', .' + chosen;
            }
            if(cats.length){
                $fitems = $fitems.filter('.' + cats.join(', .') + addchosen );
            }
            $fitems.show('slow');
            $items.not($fitems).hide('slow');
        } else {
            $items.show('slow');
        }
    });

});