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

    public function pageRender(){
		$file = ELEGANT_FORM_DIR_PATH.'admin/partials/'.((isset($_GET['page'])) ? $_GET['page'].'.php' : 'no-file.php');
        ob_start();
		if(file_exists($file)){
			include_once($file);
		}
		$template = ob_get_contents();
		ob_end_clean();
		echo $template;
    }
	
}