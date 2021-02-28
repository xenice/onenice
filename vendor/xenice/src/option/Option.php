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
        $defaults = Theme::call('xenice_options_init', $defaults);
        
        // sort
        $i = 0;
        foreach ($defaults as &$arr) {
            if(!isset($arr['pos'])){
                $arr['pos'] = $i;
                $i += 10;
            }
            $poses[] = $arr['pos'];
        }
        
        //array_unshift($pos, null);
        array_multisort($poses, SORT_ASC, $defaults);
        //var_dump($pos);
        $args = [
            'defaults'=>$defaults,
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
                    
                    if(isset($val['fields'])){
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
                    
                    if(isset($val['tabs'])){
                        foreach($val['tabs'] as $tab){
                            foreach($tab['fields'] as $field){
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
            
            if(isset($val['fields'])){
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
            
            
            if(isset($val['tabs'])){
                foreach($val['tabs'] as $key3=>$tab){
                    foreach($tab['fields'] as $key2=>$field){
                        if(isset($field['fields'])){
                            foreach($field['fields'] as $key4=>$f){
                                $k2 = $f['id'];
                                if(isset($arr2[$k1][$k2])){
                                    $arr1[$key1]['tabs'][$key3]['fields'][$key2]['fields'][$key4]['value'] =  $arr2[$k1][$k2];
                                }
                            }
                        }
                        else{
                            $k2 = $field['id'];
                            if(isset($arr2[$k1][$k2])){
                                $arr1[$key1]['tabs'][$key3]['fields'][$key2]['value'] =  $arr2[$k1][$k2];
                            }
                        }
                    }
                }
            }
        }
        return $arr1;
    }
    
    /**
     * update options
     */
    public function update($id, $tab, $fields)
    {
        Theme::call('xenice_options_set', $id, $fields);
        $arr = get_option($this->key)?:[];
        
        if($tab == -1){
            if(isset($arr[$id]) && $arr[$id] == $fields){
                return true;
            }
            $arr[$id] = $fields;
        }
        else{
            $same = true;
            foreach($fields as $key => $value){
                if(!isset($arr[$id][$key]) || $value != $arr[$id][$key]){
                    $arr[$id][$key] = $value;
                    $same = false;
                }
            }
            if($same){
                return true;
            }
        }
        return update_option($this->key, $arr);
    }
}