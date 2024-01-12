document.addEventListener('DOMContentLoaded', function () {
    var inputs = document.querySelectorAll('.pass');
    var visibilityIcons = document.querySelectorAll('.visPass');

    visibilityIcons.forEach(function (icon, index) {
        icon.addEventListener('click', function () {
            var input = inputs[index];

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        });
    });
});