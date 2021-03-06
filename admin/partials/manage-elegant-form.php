<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://codesforprogress.com
 * @since      1.0.0
 *
 * @package    Elegant_Form
 * @subpackage Elegant_Form/admin/partials
 */
?>

<?php
    $elegant_form = get_option('elegant_form');
?>

<div class="card card-table">
    <div class="card-header">
        <h3>Manage Elegant Form</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Form Name</th>
                    <th scope="col">ShortCode</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $key = 0;
                foreach ($elegant_form as $innerkey => $innervalue) {
                    $key++;
            ?>
                <tr>
                    <th scope="row"><?php echo $key; ?></th>
                    <td><?php echo $innerkey; ?></td>
                    <td> <code>[elegant-form id=<?php echo $innervalue['form-id']; ?>] </code></td>
                    <td>
                        <a href="<?php echo admin_url().'admin.php?page=manage-elegant-form&action=update&id='.$innervalue['form-id']; ?>" class="btn btn-primary"> Update Form </a>
                        <a href="<?php echo admin_url().'admin.php?page=manage-elegant-form&action=user_data&id='.$innervalue['form-id']; ?>" class="btn btn-info"> User Data </a>
                    </td>
                </tr>
            <?php }  ?>

            </tbody>
        </table>
    </div>
</div>