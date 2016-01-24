$(function () {
    var wsuri = (document.location.protocol === "http:" ? "ws:" : "wss:") + "//" +
        document.location.hostname + ":8080/ws";

    var connection = new autobahn.Connection({
        url: wsuri,
        realm: "default"
    });

    var onMessage = function (args, kwargs) {
        var task = args[0];
        if (task === 'progress') {
            getElement(kwargs.taskId).html('Task: '+ kwargs.task + ', done ' +kwargs.done +'/'+kwargs.total);

            if (kwargs.done === kwargs.total) {
                setTimeout(function () {
                    getElement(kwargs.taskId).fadeOut(function () {
                        $(this).remove();
                    });
                }, 500);
            }
        }
        if(task === 'message'){
            alert(kwargs.msg);
        }
    };

    var getElement = function (id) {
        if ($('#' + id).length == 0) {
            $('#output').append('<div id="' + id + '"></div>');
        }

        return $('#' + id);
    };

    connection.onopen = function (session, details) {
        console.log("Connected");

        $.get('/homepage/get-topics', function (topics) {
            topics.forEach(function (topic) {
                session.subscribe(topic, onMessage);
            });
        });

    };

    connection.onclose = function (reason, details) {
        console.log("Connection lost: " + reason);
    };

    connection.open();


    $('#doSomethingHeavy').click(function () {
        $.get('/homepage/heavy-action', function () {
            console.log('heavy action done');
        });
    });

});
