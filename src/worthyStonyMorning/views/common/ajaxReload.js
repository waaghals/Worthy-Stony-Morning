$(".ajax-reload").click(function(e) {
    e.preventDefault();

    url = $(this).attr('href');
    $.ajax({url: url, success: function() {
            location.reload();
        }});
});