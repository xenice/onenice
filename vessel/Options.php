<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel;

class Options extends Admin
{

    public function __construct($args = [])
    {
        
	    parent::__construct($args);
    }
    
    public function active()
    {
        if(!get_option($this->name)){
            $this->reset();
        }
    }
    
    /**
     * handle reset
     */
    public function reset()
    {

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
                    if(isset($tab['fields'])){
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
        }
        update_option($this->name, $options);
    }
    
    /**
     * handle options
     */
    public function handle($options)
    {
        $arr1 = [$options];
        $arr2 = get_option($this->name);
        foreach($arr1 as $key1=>$val){
            $k1 = $val['id'];
            
            if(isset($val['fields'])){
                foreach($val['fields'] as $key2=>$field){
                    if(isset($field['fields'])){
                        foreach($field['fields'] as $key3=>$f){
                            $k2 = $f['id'];
                            if(isset($arr2[$k1][$k2])){
                                if($arr1[$key1]['fields'][$key2]['fields'][$key3]['type'] == 'label'){ // label类型不赋值
                                    continue;
                                }
                                $arr1[$key1]['fields'][$key2]['fields'][$key3]['value'] =  $arr2[$k1][$k2];
                            }
                        }
                    }
                    else{
                        $k2 = $field['id'];
                        if(isset($arr2[$k1][$k2])){
                            if($arr1[$key1]['fields'][$key2]['type'] == 'label'){ // label类型不赋值
                                continue;
                            }
                            $arr1[$key1]['fields'][$key2]['value'] =  $arr2[$k1][$k2];
                        }
                    }
                }
            }
            
            
            if(isset($val['tabs'])){
                foreach($val['tabs'] as $key3=>$tab){
                    if(isset($tab['fields'])){
                        foreach($tab['fields'] as $key2=>$field){
                            if(isset($field['fields'])){
                                foreach($field['fields'] as $key4=>$f){
                                    $k2 = $f['id'];
                                    if(isset($arr2[$k1][$k2])){
                                        if($arr1[$key1]['tabs'][$key3]['fields'][$key2]['fields'][$key4]['type'] == 'label'){ // label类型不赋值
                                            continue;
                                        }
                                        $arr1[$key1]['tabs'][$key3]['fields'][$key2]['fields'][$key4]['value'] =  $arr2[$k1][$k2];
                                    }
                                }
                            }
                            else{
                                $k2 = $field['id'];
                                if(isset($arr2[$k1][$k2])){
                                    if($arr1[$key1]['tabs'][$key3]['fields'][$key2]['type'] == 'label'){ // label类型不赋值
                                        continue;
                                    }
                                    $arr1[$key1]['tabs'][$key3]['fields'][$key2]['value'] =  $arr2[$k1][$k2];
                                }
                            }
                        }
                    }
                }
            }
        }
        return $arr1[0];
    }
    
    /**
     * update options
     */
    public function update($id, $tab, $fields)
    {
        $arr = get_option($this->name)?:[];
        
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
        return update_option($this->name, $arr);
    }
    
}