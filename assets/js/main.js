function toast(message, type = 'info',  position = 'toast-bottom-left', duration = 1000, onclick = null) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": position,
        "preventDuplicates": true,
        "onclick": onclick,
        "showDuration": "0",
        "hideDuration": duration,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    switch (type) {
        case "success":
            toastr.success(message);
            break;
        case "error":
            toastr.error(message);
            break;
        case "warning":
            toastr.warning(message);
            break;
        default:
            toastr.info(message);
            break;
    }
}

const getCookie = function (cookie) {
    let name = cookie + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}