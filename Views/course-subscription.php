<?php require_once('layouts/header.php'); ?>
<?php require_once('layouts/navbar.php'); ?>
<?php require_once('layouts/style.php'); ?>

<div class="container">
        
        
        <?php require_once('layouts/error.php'); ?>


    <div class="row">
        <div class="form-group col-lg-5">
            <label for="student_name">Student</label><br>

            <select name="student_name" id="student_name" style="width: 300px;">
                <option value="">Student Name</option>
                    <?php foreach ($data['student'] as $student) { ?>
                        <option value="<?= $student['id'] ?>">
                                <?= $student['firstname'] . ' ' . $student['lastname'] . ' ( ' . $student['id'] . ' )' ?>
                        </option>
                    <?php } ?>
            </select>
        </div>
        <div class="form-group col-lg-5">
            <label for="course_name">Course</label><br>

            <select name="course_name" id="course_name" style="width: 300px;">
                <option value="">Course Name</option>
                    <?php foreach ($data['course'] as $course) { ?>
                        <option value="<?= $course['id'] ?>">
                                <?= $course['name'] ?>
                        </option>
                    <?php } ?>
            </select>
        </div>
        <div class="col-lg-2" style="margin-top: 25px;">
            <button class="btn btn-secondary" id="subscribeCourse">Add</button>
        </div>
    </div>
</div>
<?php require_once('layouts/footer.php'); ?>
<script>

    $(document).ready(function () {
        $('#subscribeCourse').click(function (event) {
            event.preventDefault();
            let course_id = $('#course_name option:selected').val();
            let student_id = $('#student_name option:selected').val();
            if (course_id == "") {
                alert("Please select course.");
                return false;
            }
            if (student_id == "") {
                alert("Please select student.");
                return false;
            }
            $.ajax({
                url: "courseSubscriptionAjaxHandler",
                method: "POST",
                data: {
                    course_id: course_id,
                    student_id: student_id
                },
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == 200) {
                        toastr["success"](response.message);
                    } else {
                        toastr["error"](response.message);
                    }
                }
            });
        });

    });
</script>

