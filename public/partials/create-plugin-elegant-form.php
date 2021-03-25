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

    $file_exist = false;
    if(in_array('file',$main_form)){
        $file_exist = true;
    }

    if(count($main_form) > 0) {

?>


<div class="elegant-form-div" style="background-color:<?php echo $main_form['bg']; ?>;">

    <div class="elegant-form-body">
        <form class="<?php echo ($file_exist) ? 'dropzone' : ''; ?>" action="" id="elegant-form" method="post" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" enctype='multipart/form-data' >
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

                        case 'file':
                            echo '<div class="elegant_form_file" ><label for="'.$field_key.'" >'.$key.'</label><div id="dropzoneDragArea" class="dz-default dz-message elegant-form-text-captcha dropzoneDragArea"><span>Upload file</span></div><div id="dropzone-previews"></div></div>';
                            break;
                        
                        case 'text-captcha':
                            echo '<div class="text-captcha"><div id="captcha" class="captcha-svg"></div><span><i class="refresh"><svg xmlns="http://www.w3.org/2000/svg" id="textCaptcha" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16"><path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/><path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/></svg></i></span></div><input type="text" class="input-text-field" placeholder="Captcha" id="cpatchaTextBox"/>';
                            break;
                        
                        case 'math-captcha':
                            echo '<div class="math-captcha"><div class="rand1"></div><div class="plus">+</div><div class="rand2"></div><div class="re"><svg xmlns="http://www.w3.org/2000/svg" id="mathCaptcha" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-arrow-repeat math"><path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"></path><path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"></path></svg></div><input type="text" class="input-text-field" id="total" autocomplete="off" placeholder="Summation" /></div>';
                        
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

            <button class="red" id="sendBtn" type="submit">SEND</button>

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
    .rand1, .rand2{
        border: 1px solid <?php echo $main_form['text_color']; ?> !important;
    }

</style>


