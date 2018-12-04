function show_win(){
    $('#overlay').fadeIn(400,
        function(){
            $('#modal_form')
                .css('display', 'block')
                .animate({opacity: 1, top: '50%'}, 200);
        });
}
function close_win(){
    $('#modal_form')
        .animate({opacity: 0, top: '45%'}, 200,
            function(){
                $(this).css('display', 'none');
                $('#overlay').fadeOut(400);
            }
        );
}
$(document).ready(function(){
    $('#modal_forms').submit(function(e){
        e.preventDefault();
            var form = $(this);
            var data = form.serialize();
            $.ajax({
                type: 'POST',
                url: '/auth.php?action=login',
                dataType: 'json',
                data: data,
                beforeSend: function(data) {
                    form.find('input[type="submit"]').attr('disabled', 'disabled');
                },
                success: function(data){
                    if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Привет '+data["name"]+'!');
                        location.reload();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
                complete: function(data) {
                    form.find('input[type="submit"]').prop('disabled', false);
                }
            });
            return false;
    })
})
function user_logout(param){
    var butt = $(param);
    $.ajax({
        type: 'POST',
        url: '/auth.php?action=logout',
        dataType: 'json',
        beforeSend: function(data) {
            butt.attr('disabled', 'disabled');
        },
        success: function(data){
            if (data['error']) {
                alert(data['error']);
                return false;
            } else {
                alert(data['txt']);
                location.reload();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        },
        complete: function(data) {
            butt.prop('disabled', false);
        }

    });
    return false;
}