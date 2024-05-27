'use strict';

$(function()
{
    $('#btnModalResponse').click(function (e) {
        var $div = $('#dvAnswer');
        var $button = $(this);

        if ($div.is(':visible')) {
            $div.hide();
            $button.text('Mostrar usuarios que respondieron');
        } else {
            $div.show();
            $button.text('Ocultar lista');
        }
    });
});
