<?php if (isset($data['error']) && !empty($data['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please check below errors
            <?php foreach ($data['error'] as $err) { ?>
                <li><?= $err ?></li>
            <?php } ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } else {
    if (isset($data['message']) && !empty($data['message'])) {
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> <?= $data['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } } ?>
