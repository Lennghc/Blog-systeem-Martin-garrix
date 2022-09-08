$(document).ready(function () {

    $('.editbtn').on('click', function () {

        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        console.log(data);
        let start = data[4].replace(' ', 'T');
        let end = data[5].replace(' ', 'T');

        $('#edit_id').val(data[0]);
        $('#user_id').val(data[1]);
        $('#title').val(data[2]);
        $('#thumbnail').val(data[3]);

        $('#startdate').val(start);
        $('#enddate').val(end);
        $('#street').val(data[6]);
        $('#housenumber').val(data[7]);
        $('#zipcode').val(data[8]);
        $('#location').val(data[9])
    });
});



$(document).ready(function () {

    $('.deletebtn').on('click', function () {

        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#delete_id').val(data[0]);

    });
});
