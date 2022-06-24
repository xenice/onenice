<?php
/**
 * @name        xenice meta box
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-29
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\option;

use xenice\theme\Theme;

class Form
{

    protected $args = [];

    use Elements;
    
	public function __construct($args = [])
	{
	    $this->args = $args;
	}
	
	public function show()
	{
	    $html = '';
	    
	    $html .= '<div class="wrap">';
	    
	    if(!empty($this->args['name'])){
	         $html .= '<h2>'.$this->args['name'].'</h2>';
	    }
	    
	    if(!empty($this->args['error'])){
	        $html .= '<div class="notice notice-error is-dismissible"><p><strong>'.$this->args['error'].'</strong></p></div>';
	    }
	    
	    if(!empty($this->args['desc'])){
	         $html .=  '<div style="margin-top:8px">'.$this->args['desc'].'</div>';
	    }
	    $button = _t('Submit');
	    if(!empty($this->args['submit'])){
	        $button = $this->args['submit'];
	    }
	    
	    
	    
	    $html .= '<form method="post" action="'.$this->args['action'].'" >';
	    
	    if(!empty($this->args['fields'])){
	        $fields = $this->args['fields'];
    	    $html .= '<table class="form-table">';
    	    foreach($fields as $field){
    	        $style = (isset($field['style'])&&$field['style']=='none')?'display:none':'';
                if(isset($field['fields'])){
                    //$field['id'] = $this->key . '_' . $field['id'];
                    $html .= '<tr style="'.$style.'" class="'.$field['id'].'"><th>'.$field['name'].'</th><td>';
                    foreach($field['fields'] as $f){
                        //$f['id'] = $this->key . '_' . $f['id'];
                        $html .= '<p>' . call_user_func_array([$this,$f['type']],[$f]) . '</p>';
                        if($f['type'] == 'radiotab'){
            	            $this->addRadioJs($f['id']);
            	        }
                    }
                }
                else{
                    //$field['id'] = $this->key . '_' . $field['id'];
    	            $html .= '<tr style="'.$style.'" class="'.$field['id'].'"><th>'.$field['name'].'</th><td>';
                    $html .= call_user_func_array([$this,$field['type']],[$field]);
                    if(!empty($field['desc'])){
                         $html .= '<p class="description">'.$field['desc'].'</p>';
                    }
                    if($field['type'] == 'radiotab'){
        	            $this->addRadioJs($field['id']);
        	        }
                }
    	        $html .= '</td></tr>';
    	        
    	    }
	        $html .= '</table>';
	    }
	    if(!empty($this->args['nonce'])){
	        $nonce = $this->args['nonce'];
	        $html .= '<input type="hidden" name="nonce" value="'.wp_create_nonce($nonce).'" />';
	    }
        $html .= '<p class="submit"><input type="submit" class="button-primary" value="'.$button.'"/></p>';
        $html .= '</form>';
        $html .= '</div>';
        echo $html;
	}
}