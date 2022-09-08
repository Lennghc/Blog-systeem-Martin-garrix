<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = 'Blogs';
    include 'views/admin/layout/header.php';
    ?>
    <link href="assets/css/SideBar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php include 'views/admin/layout/sidebar.php'; ?>

        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Blogs Overview</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#blogaddmodal">
                Create Blog
            </button>
        </div>
        <div class="m-3">
        <?= !empty($table) ? $table : null ?>
        <?= !empty($nav) ? $nav : null ?>





            <!-- Modal create form -->
            <div class="modal fade" id="blogaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Blog </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="blogs/create" class="needs-validation" method="POST">

                            <div class="modal-body">
                                <div class="form-group">
                                    <label> Title </label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                                </div>

                                <div class="form-group">
                                    <label> Thumbnail </label><br/>
                                    <select name="thumbnail" class="form-control">
                                        <option value="garrix.jpg">Choose Thumbnail</option>
                                        <option value="garrix.jpg">Thumbnail 1</option>
                                        <option value="garrix-2.jpg">Thumbnail 2</option>
                                        <option value="garrix-3.jpg">Thumbnail 3</option>
                                        <option value="garrix-4.jpg">Thumbnail 4</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label> Content </label>
                                    <textarea type="textarea" id="message" name="message" rows="4" cols="50"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="createBlog" class="btn btn-primary">Create Blog</button>
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
                            <h5 class="modal-title" id="exampleModalLabel"> Edit Blog Data </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="blogs/update" method="POST">

                            <div class="modal-body">

                                <input type="hidden" name="blog_id" id="edit_id">
                                <input type="hidden" name="user_id" id="user_id">

                                <div class="form-group">
                                    <label> Title </label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label> Thumbnail </label><br/>
                                    <select name="thumbnail" class="form-control">
                                        <option value="garrix.jpg">Choose Thumbnail</option>
                                        <option value="garrix.jpg">Thumbnail 1</option>
                                        <option value="garrix-2.jpg">Thumbnail 2</option>
                                        <option value="garrix-3.jpg">Thumbnail 3</option>
                                        <option value="garrix-4.jpg">Thumbnail 4</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label> Content </label>
                                    <textarea type="textarea" id="message" name="message" rows="4" cols="50"></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel"> Delete Blog </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="blogs/delete" method="POST">

                            <div class="modal-body">

                                <input type="hidden" name="blog_id" id="delete_id">

                                <h4> Do you want to Delete this Blog ??</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                                <button type="submit" name="deleteBlog" class="btn btn-primary"> Yes !! Delete it. </button>
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
        $('#blogtable tr > *:nth-child(1)').hide();
        $('#blogtable tr > *:nth-child(2)').hide();
        $('#blogtable tr > *:nth-child(4)').hide();
        $('#blogtable tr > *:nth-child(5),#blogtable tr > *:nth-child(6),#blogtable tr > *:nth-child(7)').addClass("text-center");
    </script>

<script src="<?= PATH_DIR ?>/assets/js/BlogEditDelete.js"></script>

</body>

</html>