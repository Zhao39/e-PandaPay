function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en'
    }, 'google_translate_element');
}

// autologout.js
$(document).ready(function() {
    const timeout = 1000000; // 900000 ms = 15 minutes
    var idleTimer = null;
    $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function() {
        clearTimeout(idleTimer);

        idleTimer = setTimeout(function() {
            document.getElementById('logout-user').submit();
            document.getElementById('logout-dashly').submit();
            document.getElementById('logout-purpose').submit();
            document.getElementById('logout-userp').submit();
        }, timeout);
    });
    $("body").trigger("mousemove");
});