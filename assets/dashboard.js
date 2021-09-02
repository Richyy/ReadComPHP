const Routing = window.Routing;
import Reader from './Reader';

let readers = [];
$('.readerRow').each(function () {
    var id = $(this).data('id');
    let reader = new Reader();
    reader.id = id;
    $('input[name="reader_timer_settings[readers][' + id + '][ip]"]').change(function () {
        reader.ip = $(this).val();
        updateReader(reader,'ip');
    });
    $('input[name="reader_timer_settings[readers][' + id + '][timingPoint]"]').change(function () {
        reader.timingPoint = $(this).val();
        updateReader(reader, 'timingPoint');
    });
    $('input[name="reader_timer_settings[readers][' + id + '][status]"]').change(function() {
        reader.readingStatus = this.checked;
        updateReader(reader, 'status');
    });
    console.log(reader);
    readers[id] = reader;
});


$('.server-connect-btn').click(function () {
    var $btn = $(this);
    var id = $btn.parents('.readerRow').data('id');
    var $spinner = $('#server-connect-progress' + id)
    var ip = $('input[name="reader_timer_settings[readers][' + id + '][ip]"]').val();
    if (ip > 0) {
        $btn.hide();
        $spinner.show();
        $.get(Routing.generate('connect', {id: id, ip: ip}), function (resp) {
            $spinner.hide();
            $btn.html('check_circle').removeClass('red-text').addClass('green-text').show();
        });
    }
});

function updateReader(reader,change) {
    $.post(Routing.generate('update', {id: reader.id}),{reader: reader, change:change}, function (resp) {

    });
}
