<?php
/**
 * @package elegant-plugin
 */

/**
 * 
 */
class SettingsApi
{
    public $settings = array();
    public $sections = array();
    public $fields = array();

    public function register(){
        if(!empty($this->settings)){
            add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
        }
    }

    /**
     * set Settings
     * @return instance
     */
    public function setSettings(array $settings){
        $this->settings = $settings;
        return $this;
    }

    /**
     * set Sections
     * @return instance
     */
    public function setSections(array $sections){
        $this->sections = $sections;
        return $this;
    }

    /**
     * set Fields
     * @return instance
     */
    public function setFields(array $fields){
        $this->fields = $fields;
        return $this;
    }

    /**
     * Register all custom settings , section and fields
     * @return void
     */
    public function registerCustomFields(){
       
        // Register Setting
        foreach ($this->settings as $setting) {
            register_setting( $setting['option_group'], $setting['option_name'], ($setting['callback']) ? $setting['callback'] : '');
        }

        // Add Settings Section
        foreach ($this->sections as $section) {
            add_settings_section( $section['id'], $section['title'], ($section['callback']) ? $section['callback'] : '', $section['page'] );
        }

        // Add Settings Field
        foreach ($this->fields as $field) {
            add_settings_field( $field['id'], $field['title'], ($field['callback']) ? $field['callback'] : '', $field['page'], $field['section'], ($field['args']) ? $field['args'] : '' );
        }
    }

}