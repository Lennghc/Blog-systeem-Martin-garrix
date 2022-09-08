$(document).ready(function() {

    $('.editbtn').on('click', function() {

        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

console.log(data);
        $('#edit_id').val(data[0]);
        $('#user_id').val(data[1]);
        $('#title').val(data[2]);
        $('#thumbnail').val(data[6]);
        var text = data[3];
        tinyMCE.activeEditor.setContent(text);
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
