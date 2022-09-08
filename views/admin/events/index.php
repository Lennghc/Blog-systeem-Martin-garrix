<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = 'Events';
    include 'views/admin/layout/header.php';
    ?>
</head>

<body>

    <div id="wrapper">

        <?php include 'views/admin/layout/sidebar.php'; ?>

        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Events Overview</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventaddmodal">
                Create Event
            </button>
        </div>
        <div class="m-3">
            <?= !empty($table) ? $table : null ?>
            <?= !empty($nav) ? $nav : null ?>




            <!-- Modal create form -->
            <div class="modal fade" id="eventaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Event </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="events/create" class="needs-validation" method="POST">

                            <div class="modal-body">

                                <div class="form-group">
                                    <label> Title </label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                                </div>

                                <div class="form-group">
                                    <label> Thumbnail </label><br />
                                    <select name="thumbnail" class="form-control">
                                        <option value="garrix.jpg">Choose Thumbnail</option>
                                        <option value="garrix.jpg">Thumbnail 1</option>
                                        <option value="garrix-2.jpg">Thumbnail 2</option>
                                        <option value="garrix-3.jpg">Thumbnail 3</option>
                                        <option value="garrix-4.jpg">Thumbnail 4</option>
                                    </select>

                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Start at </label>
                                        <input type="datetime-local" min="<?= date('Y-m-d') ?>T00:00" name="startdate" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> End at </label>
                                        <input type="datetime-local" min="<?= date('Y-m-d') ?>T00:00" name="enddate" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Street Name </label>
                                        <input type="text" name="street" class="form-control" placeholder="Enter Street Name" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> HouseNumber </label>
                                        <input type="text" name="housenumber" class="form-control" placeholder="Enter House Number" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Zip Code </label>
                                        <input type="text" name="zipcode" class="form-control" placeholder="Enter Zipcode" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> Place </label>
                                        <input type="text" name="location" class="form-control" placeholder="Enter Place" required>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="createEvent" class="btn btn-primary">Create Event</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Modal EDIT form -->
            <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Edit Event Data </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="events/update" class="needs-validation" method="POST">

                            <div class="modal-body">

                                <input type="hidden" name="event_id" id="edit_id">
                                <input type="hidden" name="user_id" id="user_id">

                                <div class="form-group">
                                    <label> Title </label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
                                </div>

                                <div class="form-group">
                                    <label> Thumbnail </label><br />
                                    <select name="thumbnail" class="form-control">
                                        <option value="garrix.jpg">Choose Thumbnail</option>
                                        <option value="garrix.jpg">Thumbnail 1</option>
                                        <option value="garrix-2.jpg">Thumbnail 2</option>
                                        <option value="garrix-3.jpg">Thumbnail 3</option>
                                        <option value="garrix-4.jpg">Thumbnail 4</option>
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Start at </label>
                                        <input type="datetime-local" name="startdate" id="startdate" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> End at </label>
                                        <input type="datetime-local" name="enddate" id="enddate" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Street Name </label>
                                        <input type="text" name="street" id="street" class="form-control" placeholder="Enter Street Name" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> HouseNumber </label>
                                        <input type="text" name="housenumber" id="housenumber" max='5' class="form-control" placeholder="Enter House Number" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label> Zip Code </label>
                                        <input type="text" name="zipcode" id="zipcode" max="6" class="form-control" placeholder="Enter Zipcode" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> Place </label>
                                        <input type="text" name="location" id="location" class="form-control" placeholder="Enter Place" required>
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
                            <h5 class="modal-title" id="exampleModalLabel"> Delete Event </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="events/delete" class="needs-validation" method="POST">

                            <div class="modal-body">

                                <input type="hidden" name="event_id" id="delete_id">

                                <h4> Do you want to Delete this Event ??</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                                <button type="submit" name="deleteEvent" class="btn btn-primary"> Yes !! Delete it. </button>
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
        $('#eventtable tr > *:nth-child(1)').hide();
        $('#eventtable tr > *:nth-child(2)').hide();
        $('#eventtable tr > *:nth-child(4)').hide();
        $('#eventtable tr > *:nth-child(7)').hide();
        $('#eventtable tr > *:nth-child(8)').hide();

        $('#eventtable tr > *:nth-child(9)').hide();
        $('#eventtable tr > *:nth-child(10)').hide();
        // $('#blogtable tr > *:nth-child(5),#blogtable tr > *:nth-child(6),#eventtable tr > *:nth-child(7)').addClass("text-center");
    </script>

<script src="<?= PATH_DIR ?>/assets/js/EventEditDelete.js"></script>



</body>

</html>