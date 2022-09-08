<div class="modal fade modal-style dark" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-login" role="document">
        <span id="error"></span>
        <div class="modal-content">
            <div class="modal-header p-0">
                <h4 class="modal-title">Login</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" class="mt-3" onsubmit="event.preventDefault();">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="email" id="email_log" class="form-control" name="email" placeholder="Enter your email" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" id="password_log" class="form-control" name="password" placeholder="Enter your password" required="required">
                        </div>
                    </div>
                    <div class="row pl-1 pr-1">
                        <div class="col text-left">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                <span class="custom-control-label dark">&nbsp;Remember Me</span>
                            </label>
                        </div>
                        <div class="col text-right hint-text pt-0">
                            <a href="#passwordResetModal" data-dismiss="modal" data-toggle="modal">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="form-group text-center mt-2 mb-0">
                        <button type="submit" id="login_button" class="btn btn-primary btn-block">Login</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <p>Don't have an account? <a href="#registerModal" data-dismiss="modal" data-toggle="modal">Register</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-style dark" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-login">
        <span id="error"></span>
        <div class="modal-content">
            <div class="modal-header p-0">
                <h4 class="modal-title">Register</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="signup-form" method="POST" class="mt-3" onsubmit="event.preventDefault();">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="username" class="form-control" name="username" placeholder="Enter your username" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Enter email address" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" id="enter" class="form-control" name="password_new" placeholder="Enter password" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-check"></i></span>
                            <input type="password" id="retype" class="form-control" name="password_confirmation" placeholder="Confirm password" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" onclick="showPassword()" class="custom-control-input">
                                <span class="custom-control-label dark">&nbsp;Show Password</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" id="signup_button" class="btn btn-primary btn-block">Register</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <p>Already have an account? <a href="#loginModal" data-dismiss="modal" data-toggle="modal">Login</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-style dark" id="passwordResetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-login">
        <span id="error"></span>
        <div class="modal-content">
            <div class="modal-header p-0">
                <h4 class="modal-title">Password reset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="reset-form" method="POST" class="mt-3" onsubmit="event.preventDefault();">

                    <?php
                        if( isset($_SESSION['resetToken']) ) {
                            echo "<script>$('#passwordResetModal').modal('toggle');</script>";
                            echo '<div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" id="reset_password" class="form-control" name="password" placeholder="Enter password" required="required">
                                    </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                    <input type="password" id="reset_password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm password" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" onclick="showPassword(\'#reset_password\', \'#reset_password_confirmation\')" class="custom-control-input">
                                        <span class="custom-control-label dark">&nbsp;Show Password</span>
                                    </label>
                                </div>
                            </div>';
                        } else {
                            echo '<div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" id="reset_email" class="form-control" name="email" placeholder="Enter email address" required="required">
                                </div>
                            </div>';
                        }
                    ?>

                    <div class="form-group text-center">
                        <button type="submit" id="passwordreset_button" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>