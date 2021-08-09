const $ = require('jquery');

/**
 * changes read state of notification
 * @param id
 */
function readNotification(id) {
    // call ajax to change read state
    $.ajax({
        url: '/api/notifications/change-state/' + id + '/', // I suck at this moment
        type: 'POST',
        dataType: 'json',
        async: true,

        success: function (data, status) {},
        error: function (xhr, textStatus, errorThrown) {}
    });
}

function copyImageLink(id) {
    copyToClipboard(window.location.origin + $('#'+ id +' img').attr('src'));
}

function deleteImage(id) {
    $.ajax({
        url:        '/admin/albums/photo/' + id + '/delete/',
        type:       'GET',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            if(data[0]) {
                $('#photo-col-' + id).hide();
                swal("Usunięto!", "Poprawnie usunięto.", "success");
            }
        },
        error : function(xhr, textStatus, errorThrown) {
            swal("Błąd", " Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
        }
    });
}

function confirmDelete(service) {
    swal({
            title: "Jesteś pewien?",
            text: "Usunięte zostaną również powiązane ceny oraz usługi użytkowników!",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-outline-primary",
            confirmButtonText: "Tak, usuń!",
            cancelButtonText: "Anuluj",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url:        '/admin/services/delete/' + service + '/',
                type:       'GET',
                dataType:   'json',
                async:      true,

                success: function(data, status) {
                    if(data[1]) {
                        swal("Usunięto!", "Poprawnie usunięto usługę " + data[0] + ".", "success");
                        $('#service-' + service).hide();
                    }
                },
                error : function(xhr, textStatus, errorThrown) {
                    if(xhr.status = 403)
                        swal("Błąd", " Nie posiadasz uprawnień do wykonania tej akcji.", "error");
                    else
                        swal("Błąd", " Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
                }
            });
        });
}

function deleteAlbum(name) {
    swal({
            title: "Jesteś pewien?",
            text: "Usunięte zostaną również wszystkie zdjęcia z tego albumu!",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-outline-primary",
            confirmButtonText: "Tak, usuń!",
            cancelButtonText: "Anuluj",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url:        '/admin/albums/' + name + '/delete/',
                type:       'GET',
                dataType:   'json',
                async:      true,

                success: function(data, status) {
                    if(data[0]) {
                        // replace to fit conditions and hide card
                        let name_ = name.replace(" ", "-");
                        $('#album-' + name_).hide();
                        swal("Usunięto!", "Poprawnie usunięto album " + name + ".", "success");
                    }
                },
                error : function(xhr, textStatus, errorThrown) {
                    swal("Błąd", " Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
                }
            });
        });
}

function deletePortfolioAlbum(id) {
    swal({
            title: "Jesteś pewien?",
            text: "Album zostanie wyłączony jedynie z publicznego portfolio.",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-outline-primary",
            confirmButtonText: "Tak, usuń!",
            cancelButtonText: "Anuluj",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url:        '/admin/portfolio/' + id + '/delete/',
                type:       'GET',
                dataType:   'json',
                async:      true,

                success: function(data, status) {
                    if(data[0]) {
                        $('#album-' + id).hide();
                        swal("Usunięto!", "Album został wyłączony z portfolio.", "success");
                    }
                },
                error : function(xhr, textStatus, errorThrown) {
                    swal("Błąd", " Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
                }
            });
        });
}

function copyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
    swal("Skopiowano!", "Link został skopiowany do schowka.", "success");
}

module.exports = {
    readNotification,
    copyImageLink,
    deleteImage,
    deleteAlbum,
    deletePortfolioAlbum
};
