const Routing = window.Routing;
import Reader from './Reader';

const READER_DISCONNECTED = 0;
const READER_CONNECTING = 1;
const READER_DISCONNECTING = 2;
const READER_CONNECTED = 3;

let readers = [];
window.readers = readers;
$('.readerRow').each(function () {
    var id = $(this).data('id');
    let reader = new Reader();
    reader.id = id;
    $('input[name="reader_timer_settings[readers][' + id + '][ip]"]').change(function () {
        reader.ip = $(this).val();
        updateReader(reader, 'ip');
    });
    $('input[name="reader_timer_settings[readers][' + id + '][timingPoint]"]').change(function () {
        reader.timingPoint = $(this).val();
        updateReader(reader, 'timingPoint');
    });
    $('input[name="reader_timer_settings[readers][' + id + '][status]"]').change(function () {
        reader.readingStatus = this.checked;
        updateReader(reader, 'status');
    });
    readers[id] = reader;
});

let logUpdateTime = 2000;
let lastSize = 0;

setTimeout(updateLog, logUpdateTime);

function updateLog() {
    $.get(Routing.generate('getLogLines', {lastSize: lastSize}), function (data) {
        lastSize = data.size;

        if (data.data.length > 0) {
            logUpdateTime = 2000;
            $.each(data.data, function (key, value) {
                $("#logs").append(value).scrollTop(99999);
                M.updateTextFields();
            });
        } else {
            logUpdateTime *= 1.1;
        }
        setTimeout(updateLog, logUpdateTime);
    }, "json");
}


$('.server-connect-btn').click(function () {
    var $btn = $(this);
    var id = $btn.parents('.readerRow').data('id');
    var $spinner = $('#server-connect-progress' + id)
    if (readers[id].ip > 0) {
        $btn.hide();
        $spinner.show();
        console.log("teszt1");
        console.log(readers[id]);
        if (readers[id].connectionStatus === READER_DISCONNECTED) {
            readers[id].connectionStatus = READER_CONNECTING;
            $.get(Routing.generate('connect', {id: id, reader: readers[id]}), function (resp) {
                readers[id].connectionStatus = READER_CONNECTED;
                $spinner.hide();
                $btn.html('check_circle').removeClass('red-text').addClass('green-text').show();
            });
        } else if (readers[id].connectionStatus === READER_CONNECTED) {
            readers[id].connectionStatus = READER_DISCONNECTING;
            $.get(Routing.generate('disconnect', {id: id, reader: readers[id]}), function (resp) {
                readers[id].connectionStatus = READER_DISCONNECTED;
                $spinner.hide();
                $btn.html('cancel').removeClass('green-text').addClass('red-text').show();
            });
        }

    }
});
$('.addNextReader').click(function () {
    $('.readerRow.hide').first().removeClass('hide');
})

function updateReader(reader, change) {
    $.post(Routing.generate('update', {id: reader.id}), {reader: reader, change: change}, function (resp) {

    });
}
