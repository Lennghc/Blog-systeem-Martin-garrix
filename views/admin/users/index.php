<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = 'Users';
    include 'views/admin/layout/header.php';
    ?>
    <link href="assets/css/SideBar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php include 'views/admin/layout/sidebar.php'; ?>

        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Users Overview</h1>
        </div>
        <div class="m-3">
        <?= !empty($table) ? $table : null ?>

        <?= !empty($nav) ? $nav : null ?>



            <!-- Modal EDIT form -->
            <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Edit User Data </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="users/update" class="needs-validation" method="POST">

                            <div class="modal-body">

                                <input type="hidden" name="event_id" id="edit_id">
                                <input type="hidden" name="user_id" id="user_id">

                                <div class="form-group">
                                    <label> Username </label>
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> FirstName </label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> LastName </label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Email </label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> Role </label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="0">None</option>
                                            <option value="1">Admin</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Change password </label>
                                        <input type="text" name="password" id="password" class="form-control">
                                    </div>

                                    <div class="col-sm-6">
                                        <label> Confirm password </label>
                                        <input type="text" name="confirmpassword" id="confirmpassword" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                            </div>


                        </form>

                    </div>
                </div>
            </div>


            <!-- Modal DELETE form -->
            <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="users/delete" class="needs-validation" method="POST">

                            <div class="modal-body">

                                <input type="hidden" name="event_id" id="delete_id">

                                <h4> Do you want to Delete this User ??</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                                <button type="submit" name="deleteUser" class="btn btn-primary"> Yes !! Delete it. </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>



        </div>

    </div>
    </div>

    </div>

    <script>
        $('#userstable tr > *:nth-child(1)').hide();
        $('#userstable tr > *:nth-child(2)').hide();
        $('#userstable tr > *:nth-child(6)').hide();
        $('#userstable tr > *:nth-child(7)').hide();
        // $('#blogtable tr > *:nth-child(5),#blogtable tr > *:nth-child(6),#eventtable tr > *:nth-child(7)').addClass("text-center");
    </script>


<script src="<?= PATH_DIR ?>/assets/js/UserEditDelete.js"></script>


</body>

</html>