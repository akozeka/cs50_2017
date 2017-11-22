$(document).ready(function () {
    initUI();
});

function initUI() {
    $('button.btn-back').click(function () {
        window.history.back();
    });
}
