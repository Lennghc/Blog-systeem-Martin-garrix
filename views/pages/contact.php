<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $title = 'Contact';
        include 'views/layout/header.php';
    ?>

</head>

<?php include 'views/layout/navbar.php'; ?>

<body>

<section id="contact">
    <div class="container">
        <h4 class="text-center">Contact us</h4>
        <div class="d-flex justify-content-center">
            <form method="post" class="col-md-5" action="contact">
                <div class="form-group">
                    <label for="inputEmail4">Email *</label>
                    <input type="email" maxlength="255" name="email" placeholder="Type your mail here" class="form-control" id="inputEmail4" required>
                </div>
                <div class="form-group">
                    <label for="inputSubject">Subject *</label>
                    <select class="custom-select" name="subject" id="inputSubject" required>
                        <option value="" selected>Select a option here</option>
                        <option value="events">Events</option>
                        <option value="tickets">Tickets</option>
                        <option value="contact">Contact</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputTextarea">Message *</label>
                    <textarea class="form-control" name="message" id="inputTextarea" rows="3" required></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-block btn-secondary">Submit</button>
            </form>
        </div>
    </div>
</section>

        <?php include 'views/layout/footer.php'; ?>

</body>
</html>