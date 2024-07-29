import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('keydown', function (event) {
        // Check if the delete key (key code 46) is pressed
        if (event.key === 'Delete') {
            // Find the form and submit it
            var button = document.getElementById('removeErr');
            if (button) {
                var form = button.closest('form');
                if (form) {
                    form.submit();
                }
            }
        }
    });
});

// document.addEventListener('DOMContentLoaded', function () {
//     document.getElementById('backToIndex').addEventListener('click', function () {
//         var route = this.getAttribute('data-route');
//         window.location.href = route;
//     });
// });
