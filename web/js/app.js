$(document).ready(function () {
    initUI();
});

function initUI() {
    $('button.btn-back').click(function () {
        window.history.back();
    });

    // Delete confirmation
    $(document).on('submit', 'form[name="delete_entity"]', function (e) {
        var $form = $(this);

        if ($form.data('confirmed')) {
            return;
        }

        e.preventDefault();

        eModal
            .confirm({
                message: 'Are you sure you want to delete?',
                title: 'Delete confirmation',
                size: eModal.size.sm
            })
            .then(function () {
                $form.data('confirmed', true);
                $form.submit();
            })
        ;
    });

    // Searchable select
    $('select.searchable').chosen();
}
