<?php require_once('layouts/header.php'); ?>
<?php require_once('layouts/navbar.php'); ?>
<?php require_once('layouts/style.php'); ?>

<div class="container">
        <?php require_once('layouts/error.php'); ?>

    <form name='studentList' action='student-list' method='post'>
        <table class='tbl-qa'>
            <thead>
            <tr>
                <th class='table-header' width='20%'>First Name</th>
                <th class='table-header' width='20%'>Last Name</th>
                <th class='table-header' width='20%'>DOB</th>
                <th class='table-header' width='20%'>Contact</th>
                <th class='table-header' width='20%'>Manage</th>
            </tr>
            </thead>
            <tbody id='table-body'>
            <?php
            if (!empty($data) && isset($data['data']['gridData'])) {
                    foreach ($data['data']['gridData'] as $row) {
                            ?>
                        <tr class='table-row'>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td>
                                <a href="student-registration&id=<?= $row['id'] ?>">Edit</a> |
                                <a data-id="<?= $row['id'] ?>" class="deleteStudent"
                                   style="cursor: pointer; text-decoration: underline; color: blue;">Delete</a>
                            </td>
                        </tr>
                            <?php
                    }
            }
            ?>
            </tbody>
        </table>
            <?php echo (!empty($data) && isset($data['data']['paginationHtml'])) ? $data['data']['paginationHtml'] : ''; ?>
    </form>
</div>
<?php require_once('layouts/footer.php'); ?>
<script>
    $(document).ready(function () {
        $('.deleteStudent').click(function () {
            if (confirm("Are you sure to deactivate this student?")) {
                $.ajax({
                    url: "removeStudentAjaxHandler",
                    type: 'POST',
                    data: {id: $(this).attr("data-id")},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 200) {
                            toastr["success"](response.message);
                            location.reload();
                        } else {
                            toastr["error"](response.message);
                        }
                    }
                });
            }
        });
    });
</script>
