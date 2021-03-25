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
           $column[] =  $form_key;
        }
    }

    $column = array_unique($column);
    $dir = plugin_dir_url( dirname(dirname( __FILE__ ))).'admin/uploads/';

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
                        <th scope="col"><?php echo strtoupper(str_replace('_', ' ', $value)); ?></th>
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
                            if( isset($innervalue->$value) && is_array($innervalue->$value)){
                    ?>
                        <td><button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#filesModal<?php echo $key; ?>"> All FILES </button></td>


                        <div class="modal fade" id="filesModal<?php echo $key; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ALL FILES</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <ul class="list-group list-group-flush">
                                    <?php foreach($innervalue->$value as $file){ ?>
                                    <li class="list-group-item"> <a href="<?php echo $dir.$file ?>" target="_blank" ><?php echo $dir.$file; ?></a> </li>
                                    <?php } ?>
                                </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>

                    <?php } else {  ?>

                        <td><?php echo (isset($innervalue->$value) ? $innervalue->$value : ''); ?></td>
                    <?php }} ?>
                    
                </tr>
                
            <?php
                }  ?>

            </tbody>
        </table>
    </div>
</div>