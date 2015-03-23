$.ajaxPrefilter(function(options, originalOptions, xhr) {
    var token = $('meta[name="csrf_token"]').attr('content');

    if (token) {
        return xhr.setRequestHeader('X-XSRF-TOKEN', token);
    }
});