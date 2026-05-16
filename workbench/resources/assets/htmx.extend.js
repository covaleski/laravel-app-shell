window.addEventListener('load', function () {
    htmx.defineExtension('activate', {
        init: function(api) {
            htmx.setCurrent = function (element, className, ariaCurrent) {
                [...element.parentElement.children].forEach(function (child) {
                    child.ariaCurrent = ariaCurrent === 'true' ? 'false' : null;
                    child.classList.remove(className);
                });
                element.ariaCurrent = ariaCurrent;
                element.classList.add(className);
            };

            htmx.setSelected = function (element, className) {
                [...element.parentElement.children].forEach(function (child) {
                    child.ariaSelected = 'false';
                    child.classList.remove(className);
                });
                element.ariaSelected = 'true';
                element.classList.add(className);
            };
        },
    });
});
