$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },

    beforeSend: function (xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }

        if (!$('.fa-spinner.fa-pulse').length) {
            $('body').append('<div id="ajax-indicator" class="fas fa-spinner fa-pulse fa-4x"></div>');
        }
    },

    complete: function (response) {
        var json = response.responseJSON;

        if ($('#ajax-indicator').length) {
            $('#ajax-indicator').remove();
        }

        if (typeof json !== 'undefined') {
            if (json.hasOwnProperty('info')) {
//                $.notify(json.info, 'info');

                return true;
            }

            if (json.hasOwnProperty('success')) {
                if (json.success !== '' && json.success !== 'success') {
//                    $.notify(json.success, 'success');
                }

                return true;
            }
        }
    },

    error: function (response) {
        if ($('#ajax-indicator').length) {
            $('#ajaxicator').remove();
        }
        console.log("Error", response)

//        switch (response.status) {
//            case 500:
//                $.notify('Oops, looks like something went wrong performing this action.', 'error');
//                break;
//
//            case 403:
//                $.notify('Sorry, you are not authorised to perform this action.', 'error');
//                break;
//
//            default:
//                $.notify('Oops, looks like something went wrong performing this action.', 'error');
//        }
    }
});

