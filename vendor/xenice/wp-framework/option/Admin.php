<?php
/**
 * @name        xenice Admin
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2020-03-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\option;

use xenice\theme\Base;
use xenice\theme\Theme;

class Admin extends Base
{
    private $show_menu = false;
    private $main_menu = [];
    
    protected $options  = [];
    protected $defaults = [];
    
    use Elements;
    
    public function __construct($args = [])
    {
        isset($args['defaults']) && $this->defaults = $args['defaults'];
        isset($args['show_menu']) && $this->show_menu = $args['show_menu'];
        isset($args['main_menu']) && $this->main_menu = $args['main_menu'];
        $this->get();
        
        if($this->show_menu){
            add_action( 'admin_menu', [$this, 'menu']);
        }
    }
    
    public function menu()
    {
        if($this->main_menu){
            if(!isset($this->options[0]['id'])){
                return;
            }
            $main = $this->main_menu;
            // main menu id
            $id = $main['prefix'] . $this->options[0]['id'];
            
            add_menu_page($main['name'], $main['name'], $main['auth'], $id, [$this, $this->options[0]['id']], $main['icon'],$main['pos']);
            foreach($this->options as $option){
                add_submenu_page( $id, $option['name'], $option['name'], $main['auth'], $main['prefix'] . $option['id'], [$this,$option['id']]);
            }
        }
        else{
            $main = $this->options[0];
            add_menu_page($main['name'], $main['name'], $main['auth'], $id, [$this, $main['id']], $main['icon'], $main['pos']);
        }
    }

	public function __call($method, $args)
    {
        $key = array_search($method, array_column($this->options, 'id'));
        if($key === false){
            throw new \Exception('Call to undefined method ' . get_called_class() . '::' . $method);
        }
        $option = $this->options[$key];
        
        if(isset($option['func'])){ // show custom page
            call_user_func_array($option['func'],[]);
            return;
        }
        
        if(!isset($option['submit'])){
            $option['submit'] = _t('Save Changes');
        }
        if(isset($_POST['xenice_option_key']) && check_admin_referer('xenice-options-update')){
            // Delete useless elements
            $data = $_POST;
            unset($data['_wpnonce']);
            unset($data['_wp_http_referer']);
            unset($data['xenice_option_key']);
            Theme::bind('xenice_options_result',[$this,'post']);
            if(Theme::call('xenice_options_save', $_POST['xenice_option_key'], $data)){
                $result = [];
                if($this->set($_POST['xenice_option_key'],$data)){
                    $this->get();
                    $option = $this->options[$key];
                    $result['success'] = 'true';
                }
                else{
                    $result['success'] = 'false';
                }
                Theme::call('xenice_options_result', $result);
            }

        }
        
        if(isset($_POST['success'])){
            if($_POST['success'] == 'true'){
                 ?>
                <div id="message" class="updated notice is-dismissible">
                <p><strong><?=$_POST['message']??$option['title'].' '._t('save success')?></strong></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?=_t('Ignore this notice')?></span></button>
                </div>
                <?php
            }
            else{
                 ?>
                <div id="message" class="error settings-error notice is-dismissible">
                <p><strong><?=$_POST['message']??$option['title'].' '._t('save failed')?></strong></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?=_t('Ignore this notice')?></span></button>
                </div>
                <?php
            }
        }
        
        ?>
        <style>
        .wrap .slide-img{
            margin:25px 0 0 0;
            max-height:150px;
        }
        
        .wrap .small-text,.wrap input[type="checkbox"],.wrap input[type="radio"]{
            margin-right:8px;
        }
        
        @media screen and (min-width:768px){
            .wrap .slide-data{
                float:left;
                margin-right:20px;
            }
            .wrap .regular-text{
                margin-right:8px;
            }
            .wrap label textarea{
                vertical-align: top;
            }
        }
        </style>
        <div class="wrap">
            <h2><?=$option['title']?></h2>
            <?=isset($option['desc'])?'<div style="margin-top:8px">'.$option['desc'].'</div>':''?>
            <form method="post" action="" id="xenice_option_form">
                <?php wp_nonce_field('xenice-options-update'); ?>
                <input type="hidden" name="xenice_option_key" value="<?=$option['id']?>">
                <table class="form-table">
                    <tbody>
                    <?php
                    $str = '';
                    foreach ( $option['fields'] as $field ) {
                        $top = '<tr valign="top"><th scope="row"><label>'.$field['name'].'</label></th><td><p>';
                        
                        if(isset($field['fields'])){
                            $main = '';
                            foreach($field['fields'] as $f){
                                $main .= '<p>' . call_user_func_array([$this,$f['type']],[$f]) . '</p>';
                            }
                        }
                        else{
                            $main = call_user_func_array([$this,$field['type']],[$field]);
                        }
                        
                        $bottom = '</p>';
                        if ( isset($field['desc']) && $field['desc']) {
                            $bottom .= '<p class="description">'.$field['desc'] . '</p>';
                        }
                        $bottom .= '</td></tr>';
                        
                        
                        $str .= $top . $main . $bottom;
                    }
                    echo $str;
                    ?>
                    </tbody>
                </table>
                <p class="submit">
                    <?php 
                        $buttons = '<input type="submit" class="button-primary" value="'.$option['submit'].'"/>';
                        echo Theme::call('xenice_options_button',$buttons, $option['id']);
                    ?>
                </p>
            </form>
        </div>
        <script>
            jQuery(function($){
              $("#xenice_option_form").submit(function(e){
                // image
                $('.xenice-image').each(function(){
                    var value = '';
                    var id = this.name;
                    value += '"url":' + '"' + $('#' + id + '_url').attr('value') + '",';
                    value += '"title":' + '"' + $('#' + id + '_title').attr('value') + '",';
                    value += '"path":' + '"' + $('#' + id + '_path').attr('value') + '"';
                    value  = '{' + value + '}';
                    this.value = value;
                });
                
                //e.preventDefault();
              });
            })
            
        </script>
    <?php
    }
    
    /**
     * show single page
     */
    public function show()
    {
        if(isset($this->options[0]['id'])){
            call_user_func([$this, $this->options[0]['id']]);
        }
    }
    
    /**
     * return updated results
     */
    public function post($result)
    {
        $result = Theme::call('xenice_options_result_data', $result);
        $str = "<form style='display:none;' id='form_result' name='form_result' method='post' action=''>";
        if(isset($result['message'])){
            $str .= "<input name='message' type='text' value='{$result['message']}' />";
        }
        $str .= "<input name='success' type='text' value='{$result['success']}' /></form>";
        $str .= "<script type='text/javascript'>document.form_result.submit();</script>";
        echo $str;
    }
    
    /**
     * get options
     */
    private function get()
    {
        if($this->main_menu){
            $this->options = $this->handle($this->defaults);
        }
        else{
            $this->options[] = $this->handle($this->defaults);
        }
    }
    
    /**
     * handle data
     */
    public function handle($options)
    {
        return $options;
    }
    
    /**
     * set options
     */
    private function set($id, $fields)
    {
        $checkboxs = $this->names($id, 'checkbox');
        foreach($checkboxs as $checkbox){
            // Checkbox is not submitted when unchecked
            if(!isset($fields[$checkbox])){
                $fields[$checkbox] = false;
            }
            else{
                $fields[$checkbox] = true;
            }
        }
        
        $textareas = $this->names($id, 'textarea');
        foreach($textareas as $textarea){
            $fields[$textarea] = stripslashes($fields[$textarea]);
        }
        
        $images = $this->names($id, 'image');
        foreach($images as $image){
            $fields[$image] = json_decode(stripslashes($fields[$image]), true);
        }
        
        return $this->update($id, $fields);
        //Theme::call('xenice_options_set', $id, $fields);
        
        
    }
    
    /**
     * update data
     */
    public function update($id, $fields)
    {
        return false;
    }
    
    
    /**
     * Get names of the specified type
     */
    private function names($id, $type)
    {
        $arr = [];
        $key = array_search($id, array_column($this->defaults, 'id'));
        $fields = $this->defaults[$key]['fields'];
        foreach($fields as $field){
            if(isset($field['fields'])){
                foreach($field['fields'] as $f){
                    if($f['type'] == $type){
                        $arr[] = $f['id'];
                    }
                }
            }
            else{
                if($field['type'] == $type){
                    $arr[] = $field['id'];
                }
            }
        }
        return $arr;
    }
}