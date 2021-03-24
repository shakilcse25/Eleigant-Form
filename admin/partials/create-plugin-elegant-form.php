<?php
    $form = get_option('elegant_form','');
    $single_form = array_filter($form, function($data) use($params){
        if($data['form-id'] == $params['id']){
            return true;
        }
        return false;
    });
    $form_title = '';
    if(count($single_form) > 0){
        foreach ($single_form as $key => $value) {
            $form_title = $key;
        }
    }
    $main_form = array();
    if(!empty($form_title)){
        $main_form = $single_form[$form_title];
    }

    if(count($main_form) > 0) {

?>


<div class="elegant-form-div" style="background-color:<?php echo $main_form['bg']; ?>;">
    <div class="elegant-form-title">
        <h3><?php //echo $form_title; ?></h3>
    </div>
    <div class="elegant-form-body">
        <form action="" id="elegant-form" action="#" method="post" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >
            <?php
                foreach ($main_form as $key => $value) {
                    $field_key = strtolower(str_replace(' ','_',$key));
                    switch ($value) {
                        case is_array($value):
                            $options = '<option value="no" hidden > Select '. $key .' </option>';
                            foreach ($value as $optionkey => $optionvalue) {
                                if(!is_int($optionkey)){
                                    continue;
                                }
                                $options .= '<option value="'. $optionvalue .'">'. $optionvalue .'</option>';
                            }
                            echo '<div class="elegant-form-input-wrap"><select class="input-text-select" id="'. $field_key .'" placeholder="'.$key.'" name="'. $field_key .'">'. $options .'</select></div>';
                            break;

                        case 'input':
                            echo '<div class="elegant-form-input-wrap"><input class="input-text-field" id="'. $field_key .'" type="text" name="'. $field_key .'" placeholder="'.$key.'" ></div>';
                            break;

                        case 'text-area':
                            echo '<div class="elegant-form-input-wrap"><textarea class="input-text-area" id="'. $field_key .'" placeholder="'.$key.'" name="'. $field_key .'" ></textarea></div>';
                            break;
                        
                        case 'checkbox':
                            echo '<div class="elegant-form-input-wrap div-checkbox"><input type="checkbox" id="'. $field_key .'" name="'. $field_key .'" class="input-text-checkbox" /><label class="checkbox-label" for="'.$field_key.'">'. $key .'</label></div>';
                            break;
                        
                        default:
                            break;
                    }
                    if($key === 'form-id'){
                        echo '<input type="hidden" name="form_id" value="'. $value .'" />';
                        echo '<input type="hidden" name="action" value="elegant_form_submit" />';
                        
                        echo '<input type="hidden" name="nonce" value="'. wp_create_nonce("elegant-and-form-nonce") .'">';
                    } 
            ?>

            <?php } ?>

            <button class="red" type="submit">SEND</button>

        </form>
    </div>
</div>
<?php }else{ ?>

    <div class="no_data_found">
        <h2>No Form Found!</h2>
    </div>

<?php } ?>

<style>
    .elegant-form-div .input-text-checkbox{
        display: flex;
        align-items: center;
        width: 20px;
        justify-content: center;
    }
    .elegant-form-div .elegant-form-input-wrap{
        margin: 30px 0;
    }
    .elegant-form-div .div-checkbox{
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .elegant-form-div .checkbox-label{
        cursor: pointer;
        color: <?php echo $main_form['text_color']; ?>;
        font-weight: 700;
        opacity: 0.6;
    }

    .elegant-form-div .input-text-checkbox{
        border-radius: 8px !important;
    }

    .input-text-select{
        color: <?php echo $main_form['text_color']; ?>;
        opacity: 0.6;
    }
    .input-text-select option,.input-text-select option:first-child , .input-text-field::placeholder , .elegant-form-div button , .elegant-form-div input, .elegant-form-div select, .elegant-form-div button, .elegant-form-div textarea {
        color: <?php echo $main_form['text_color']; ?> !important;
    }
    .elegant-form-div .input-text-checkbox:checked{
        background-color:  <?php echo $main_form['text_color']; ?> !important;
    }
</style>


