<?php require_once('layouts/header.php'); ?>
<?php require_once('layouts/navbar.php'); ?>
<?php require_once('layouts/style.php'); ?>

<div class="container">
        
        
        <?php require_once('layouts/error.php'); ?>

    <form action="course-add<?php echo isset($_POST['id']) ? '&id='.$_POST['id'] : ''; ?>"
          method="post" name="course_add_form">
        <div class="form-group row">
            <label for="firstname" class="col-sm-2 col-form-label">Course Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" id="name"
                       value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="lastname" class="col-sm-2 col-form-label">Course Details</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="details" name="details" rows="3"><?php echo isset($_POST['details']) ? $_POST['details'] : ''; ?></textarea>
            </div>
        </div>
        
        <input type="text" class="form-control" name="id"
               value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>" hidden>

        <div class="form-group row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary" name="course_add" value="course_add">
                        <?php echo isset($_POST['editMode']) ? 'Update' : 'Submit'; ?>
                </button>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </form>
</div>
<?php require_once('layouts/footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
    // Wait for the DOM to be ready
    $(function () {
        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form[name='course_add_form']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                name: "required",
                details: "required"

            },
            // Specify validation error messages
            messages: {
                name: "Please enter course name.",
                details: "Please enter course details."

            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

