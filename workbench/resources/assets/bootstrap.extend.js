window.addEventListener('load', function () {
    [...document.querySelectorAll('[data-bs-toggle="tooltip"]')]
        .forEach((element) => new bootstrap.Tooltip(element));
});
