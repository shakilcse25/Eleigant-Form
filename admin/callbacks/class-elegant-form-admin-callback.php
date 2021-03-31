<?php

/**
 * The admin-specific callbacks of the plugin.
 *
 * @link       https://codesforprogress.com
 * @since      1.0.0
 *
 * @package    Elegant_Form
 * @subpackage Elegant_Form/admin/callbacks
 */

class Elegant_Form_Admin_Callback{
    
    /**
     * This default page render callback. this return template based on value and parameter of page
     *
     * @return void
     */
    public function pageRender(){
        $page = (isset($_GET['page'])) ? $_GET['page'] : '';
        $action = (isset($_GET['action'])) ? $_GET['action'] : '';

        $file = '';
        if(!empty($page)){
            if(empty($action)){
                $file = ELEGANT_FORM_DIR_PATH.'admin/partials/'.$page.'.php';
            }else{
                $file = ELEGANT_FORM_DIR_PATH.'admin/partials/'.$page.'-'.$action.'.php';
            }
        }
        ob_start();
		if(file_exists($file)){
			include_once($file);
		}
		$template = ob_get_contents();
		ob_end_clean();
		echo $template;
    }
	
	/**
	 * set section of create form section
	 *
	 * @return void
	 */
	public function efSectionManager(){
    }
    
    /**
     * sanitize of all value and output the required format
     *
     * @param  mixed $input
     * @return void
     */
    public function efSanitize($input){
        $output = get_option('elegant_form');
        $fileter_form = array();
        $update = false;

        if(isset($_POST['method']) && $_POST['method'] == 'update'){
            foreach($output as $key => $value){
                if($key = $input['form_name']){
                    $fileter_form = $value;
                    $update = true;
                    break;
                }
            }
        }
        

        $combine_array = array_combine($input['field_name'],$input['field_type']);
        $combine_array['form-id'] = ($update) ? $fileter_form['form-id'] : md5(uniqid(rand(), true));
        $combine_array['bg'] = $input['bg'];
        $combine_array['text_color'] = $input['text_color'];
        $options = isset($input['options']) ? $input['options'] : array();

        foreach ($combine_array as $key => $value) {
            if($value == 'dropdown' && array_key_exists($key,$options)){
                $options[$key]['type'] = $value;
                $combine_array[$key] = $options[$key];
            }
        }

        $output[$input['form_name']] =  $combine_array;
        return $output;
    }
    
    /**
     * structure of any text field of form
     *
     * @param  mixed $args
     * @return void
     */
    public function textField($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $type = 'text';
        $readonly = '';

        
        switch ($name) {
            case 'bg':
                $value = '#EBECF0';
                $type = 'color';
                break;
            case 'text_color':
                $value = '#000000';
                $type = 'color';
                break;
        }


        if(isset($_GET['action']) && $_GET['action'] == 'update'){
            $form = get_option( 'elegant_form' );
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            foreach ($form as $key => $formvalue) {
                if($formvalue['form-id'] == $id){
                    if($name == 'form_name'){
                        $value = $key;
                        $readonly = 'readonly';
                    }else{
                        foreach ($formvalue as $fieldkey=>$fieldvalue) {
                            if($fieldkey == $name){
                                $value = $fieldvalue;
                            }
                        }
                    }
                }
            }
        }

        echo '<input type="'.$type.'" '. $readonly .' class="form-control input-field" id="'.$name.'" name="'.$option_name.'['.$name.']" value="'.$value.'" placeholder="'. $args['placeholder'] .'" required>';
    }
	
}