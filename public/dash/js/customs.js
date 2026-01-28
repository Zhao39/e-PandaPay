function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en'
    }, 'google_translate_element');
}

var badWords = [
    "<!--Start of Tawk.to Script-->",
    '<script type="text/javascript">',
    "<!--End of Tawk.to Script-->",
];
$("#livechat").on("blur", function() {
    var value = $(this).val();
    $.each(badWords, function(idx, word) {
        value = value.replace(word, "");
    });
    $(this).val(value);
});


$("#usernameinput").on("keypress", function(e) {
    return e.which !== 32;
});

// autologout.js
$(document).ready(function() {
    const timeout = 1000000; // 900000 ms = 15 minutes
    var idleTimer = null;
    $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function() {
        clearTimeout(idleTimer);

        idleTimer = setTimeout(function() {
            document.getElementById('logout-form').submit();
        }, timeout);
    });
    $("body").trigger("mousemove");
});

function toggleMode() {
    const darkIcon = document.querySelector('.dark-icon');
    const lightIcon = document.querySelector('.light-icon');
    const body = document.body;
    const modal = document.querySelector('.modal-content');
    const lightbg = document.querySelectorAll('.bg-light');
    const transbg = document.querySelectorAll('.bg-drk-trans');
    // get side bar element with a class of sidebar-style-2
    const sidebar = document.querySelector('.sidebar-style-2');
    const currentMode = body.getAttribute('data-background-color');
    const newMode = currentMode === 'dark' ? 'light' : 'dark';
    if (newMode) {
        if (newMode === 'dark') {
            darkIcon.classList.remove('d-none');
            lightIcon.classList.add('d-none');
            if (lightbg) {
                lightbg.forEach(element => {
                    element.classList.remove('bg-light');
                });
            }
        } else {
            lightIcon.classList.remove('d-none');
            darkIcon.classList.add('d-none');
            if (transbg) {
                transbg.forEach(element => {
                    element.classList.add('bg-light');
                });
            }
        }
        // Set the new mode
        body.setAttribute('data-background-color', newMode);
        sidebar.setAttribute('data-background-color', newMode);
        if (modal) {
            modal.setAttribute('data-background-color', newMode);
        }
        // Save the new mode to local storage
        localStorage.setItem('background-color', newMode);
    }

}