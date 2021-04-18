<?php require_once('layouts/header.php'); ?>
<?php require_once('layouts/navbar.php'); ?>
<?php require_once('layouts/style.php'); ?>

<div class="container">
        <?php require_once('layouts/error.php'); ?>

    <form name='courseList' action='course-list' method='post'>
        <table class='tbl-qa'>
            <thead>
            <tr>
                <th class='table-header' width='20%'>Course</th>
                <th class='table-header' width='20%'>Manage</th>
            </tr>
            </thead>
            <tbody id='table-body'>
            <?php
            if (!empty($data) && isset($data['data']['gridData'])) {
                    foreach ($data['data']['gridData'] as $row) {
                            ?>
                        <tr class='table-row'>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <a href="course-add&id=<?= $row['id'] ?>">Edit</a> |
                                <a href="">Delete</a>
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
