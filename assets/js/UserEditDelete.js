$(document).ready(function() {

    $('.editbtn').on('click', function() {

        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

            console.log(data);
        $('#edit_id').val(data[0]);
        $('#user_id').val(data[0]);
        $('#username').val(data[1]);
        $('#firstname').val(data[2]);
        $('#lastname').val(data[3]);
        $('#email').val(data[4]);
        $('#password').val(data[5]);
        $('#role').val(data[6]);

    });
});



$(document).ready(function() {

    $('.deletebtn').on('click', function() {

        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#delete_id').val(data[0]);

    });
});
