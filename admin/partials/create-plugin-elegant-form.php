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

?>

<div class="elegant-form-div">
    <div class="elegant-form-title">
        <h3><?php echo $form_title; ?></h3>
    </div>
    <div class="elegant-form-body">
        <form action="" class="elegant-form">
            <?php
                foreach ($main_form as $key => $value) {
                    switch ($value) {
                        case is_array($value):
                            $options = '';
                            foreach ($value as $optionkey => $optionvalue) {
                                if(!is_int($optionkey)){
                                    continue;
                                }
                                $options .= '<option value="'. $optionvalue .'">'. $optionvalue .'</option>';
                            }
                            echo '<div class="elegant-form-input-wrap"><div class="elegant-form-label">'.$key.'</div><select name="'. strtolower(str_replace(' ','_',$key)) .'">'. $options .'</select></div>';
                            break;

                        case 'input':
                            echo '<div class="elegant-form-input-wrap"><div class="elegant-form-label">'.$key.'</div><input type="text" name="'. strtolower(str_replace(' ','_',$key)) .'" ></div>';
                            break;
                        
                        
                        default:
                            # code...
                            break;
                    }
            ?>

            <?php } ?>
        </form>
    </div>
</div>