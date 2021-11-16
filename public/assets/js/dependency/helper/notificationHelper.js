window.alertNotify = function (Msg) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: Msg,
    })

    return false;
}

window.alertNotifyInfo = function (Msg) {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: Msg,
    })

    return false;
}

window.alertNotifySucceess = function (Msg) {
    Swal.fire({
        icon: 'success',
        title: 'success',
        text: Msg,
    })

    return false;
}