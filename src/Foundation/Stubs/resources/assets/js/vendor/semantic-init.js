/*
|--------------------------------------------------------------------------
| Semantic UI - Component initializations
|--------------------------------------------------------------------------
*/

$(function(){

    /* Modals */
    $("[data-toggle='modal']").click(function() {
        const target = $(this).data('target');
        $(target)
            .modal({
                selector: { close: '.close', deny: '.cancel', approuve: '' }
            })
            .modal('show')
        ;
    });

    /* Sidebars */
    $('.ui.sidebar').sidebar('attach events', "[data-toggle='sidebar']");

    /* Messages */
    $('.message .close').on('click', function() {
        $(this).closest('.message').transition('fade');
    });

    //

})
