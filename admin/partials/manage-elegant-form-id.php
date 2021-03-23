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
    $elegant_form = get_option('elegant_form_submit');
    $id = (isset($_GET['id'])) ? $_GET['id'] : '';
    $form_data = array_filter($elegant_form, function ($data) use ($id) {
        if($data->form_id == $id){
            return true;
        }
        return false;
    });



    $column = array();
    foreach ($form_data as $key => $value) {
        foreach ($value as $form_key => $form_value) {
           if($form_key == 'action' || $form_key == 'nonce' || $form_key == 'form_id'){
                continue;
           }
           $column[] = $form_key;
        }
    }

    $column = array_unique($column);
?>

<div class="card card-table">
    <div class="card-header">
        <h3>Elegant Form Data</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <?php
                        foreach ($column as $value) {
                    ?>
                        <th scope="col"><?php echo $value; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php
                $key = 0;
                foreach ($form_data as $innerkey => $innervalue) {
                    $key++; ?>
                    
                <tr>
                    <th scope="row"><?php echo $key; ?></th>

                    <?php
                        foreach ($column as $value) {
                    ?>
                        <td><?php echo (isset($innervalue->$value) ? $innervalue->$value : ''); ?></td>
                    <?php } ?>
                    
                </tr>
            <?php
                }  ?>

            </tbody>
        </table>
    </div>
</div>