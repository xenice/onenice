<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\option;

use xenice\theme\Theme;

class Option extends Admin
{
    private $key = "xenice_options"; // Database option key
    
    public function __construct()
    {
        add_action('after_switch_theme', [$this, 'active']);
        $defaults = is_file(OPTIONS_FILE)?require(OPTIONS_FILE):[];
        $args = [
            'defaults'=>Theme::call('xenice_options_init', $defaults),
	        'show_menu'=>true,
	        'main_menu'=>[
	            'prefix' => 'xenice_',
                'name'=>_t('Theme'),
                'auth' => 'manage_options',
                'icon' => 'dashicons-admin-customizer',
                'pos' => 59
	         ]
	    ];
	    parent::__construct($args);
    }
    
    public function active()
    {
        global $pagenow;
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
            // Insert option on first activation
            
            if(!get_option($this->key)){
                $arr = $this->defaults;
                $options = [];
                foreach($arr as $val){
                    $k1 = $val['id'];
                    foreach($val['fields'] as $field){
                        if(isset($field['fields'])){
                            foreach($field['fields'] as $f){
                                $k2 = $f['id'];
                                $options[$k1][$k2] = $f['value'];
                            }
                        }
                        else{
                            $k2 = $field['id'];
                            $options[$k1][$k2] = $field['value'];
                        }
                    }
                }
                add_option($this->key, $options);
            }
        }
    }
    
    /**
     * handle options
     */
    public function handle($options)
    {
        $arr1 = $options;
        $arr2 = get_option($this->key);
        
        foreach($arr1 as $key1=>$val){
            $k1 = $val['id'];
            foreach($val['fields'] as $key2=>$field){
                if(isset($field['fields'])){
                    foreach($field['fields'] as $key3=>$f){
                        $k2 = $f['id'];
                        if(isset($arr2[$k1][$k2])){
                            $arr1[$key1]['fields'][$key2]['fields'][$key3]['value'] =  $arr2[$k1][$k2];
                        }
                    }
                }
                else{
                    $k2 = $field['id'];
                    if(isset($arr2[$k1][$k2])){
                        $arr1[$key1]['fields'][$key2]['value'] =  $arr2[$k1][$k2];
                    }
                }
            }
        }
        return $arr1;
    }
    
    /**
     * update options
     */
    public function update($id, $fields)
    {
        Theme::call('xenice_options_set', $id, $fields);
        $arr = get_option($this->key)?:[];
        if(isset($arr[$id]) && $arr[$id] == $fields){
            return true;
        }
        $arr[$id] = $fields;
        return update_option($this->key, $arr);
    }
}