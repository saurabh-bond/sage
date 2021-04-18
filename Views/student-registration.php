<?php require_once('layouts/header.php'); ?>
<?php require_once('layouts/navbar.php'); ?>
<?php require_once('layouts/style.php'); ?>

<div class="container">
        
        
        <?php require_once('layouts/error.php'); ?>

    <form action="student-registration<?php echo isset($_POST['id']) ? '&id='.$_POST['id'] : ''; ?>"
          method="post" name="student_registration_form">
        <div class="form-group row">
            <label for="firstname" class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstname" id="firstname"
                       value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="lastname" class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="lastname" id="lastname"
                       value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="dob" class="col-sm-2 col-form-label">DOB</label>
            <div class="col-sm-6">
                <input type="date" class="form-control" name="dob" id="dob"
                       value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="contact_no" class="col-sm-2 col-form-label">Contact No</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="contact_no" id="contact_no"
                       value="<?php echo isset($_POST['contact_no']) ? $_POST['contact_no'] : ''; ?>">
            </div>
        </div>
        <input type="text" class="form-control" name="id"
               value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>" hidden>

        <div class="form-group row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary" name="registration" value="registration">
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
        $("form[name='student_registration_form']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                firstname: "required",
                lastname: "required",
                dob: "required",
                contact_no: "required",

            },
            // Specify validation error messages
            messages: {
                firstname: "Please enter firstname",
                lastname: "Please enter lastname",
                dob: "Please enter date of birth",
                contact_no: "Please enter contact number",

            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

