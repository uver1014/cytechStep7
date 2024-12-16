$(document).ready(function() {
    $('#search-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'GET',
            data: $(this).serialize(),
            success: function(response) {
                $('#resultList').html(response);
            },
            error: function() {
                alert('検索に失敗しました。');
            }
        });
    });
});