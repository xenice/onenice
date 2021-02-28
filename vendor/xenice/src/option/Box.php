<?php
/**
 * @name        xenice meta box
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-29
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\option;

class Box
{
    protected $post;
    protected $js = '';
    
    protected $key;
    protected $options  = [];
    protected $defaults = [];
    
    use Elements;
    
	public function __construct($args)
	{
	    isset($args['defaults']) && $this->defaults = $args['defaults'];
        isset($args['key']) && $this->key = $args['key'];
		add_action('add_meta_boxes', [$this, 'createMetaBox']);
		add_action('save_post', [$this,'save']);
		
	}
    /**
     * handle data
     */
    public function handle($id, $options)
    {
        return $options;
    }
    
    /**
     * update data
     */
    public function update($id, $fields)
    {
    }
    
    /**
     * get options
     */
    private function get($id)
    {
        $this->options = $this->handle($id, $this->defaults);
    }
    
	public function createMetaBox()
	{
		add_meta_box( 'markdown-meta-box', _t('Markdown'), [$this, 'metaForm'], '', 'advanced', 'high' );
		add_action('admin_footer', [$this,'footer']);
	}
	
	public function metaForm($post)
	{
	    $this->get($post->ID);
	    $this->post = $post;
	    $fields = $this->options;
	    $html = '<table class="form-table">';
	    $arr = [];
	    foreach($fields as $field){
	        if(isset($arr[$field['id']])){
	            $field['value'] = $arr[$field['id']];
	        }
	        $field['id'] = $this->key . '_' . $field['id'];
	        $html .= '<tr class="'.$field['id'].'"><th>'.$field['name'].'</td>';
	        $html .= '<td>' . call_user_func_array([$this,$field['type']],[$field]) . '</td></tr>';
	        if($field['type'] == 'radio'){
	            $this->addRadioJs($field['id']);
	        }
	    }
	    $html .= '</table>';
	    echo $html;
	    echo '<input type="hidden" name="post_'.$this->key.'_meta_nonce" value="'.wp_create_nonce('update_post_'.$this->key.'_meta').'" />';
	}
    
	function save( $post_id )
	{
	    
		if (empty($_POST['post_'.$this->key.'_meta_nonce']) || !wp_verify_nonce( $_POST['post_'.$this->key.'_meta_nonce'], 'update_post_'.$this->key.'_meta'))
			return;
	   
		if ( !current_user_can( 'edit_posts', $post_id ))
			return;
	    
	    $this->get($post_id);
	    $fields = $this->options;
	    $arr = [];
	    foreach($fields as $field){
	        $key = $this->key . '_' .  $field['id'];
	        if($filed['type'] == 'checkbox'){
	            $_POST[$key] = isset($_POST[$key])?true:false;
	        }
	        $arr[$field['id']] = $_POST[$key];
	    }
        
        
		if($arr){
		    remove_action('save_post', [$this,'save']);
		    $this->update($post_id, $arr);
		}
	}
	
    private function addRadioJs($name)
    {
        $this->js .=<<<js
$("input[name='$name']").click(function(){
    var curVal = $(this).val();
    $("input[name='$name']").each(function(){
        var val = $(this).val();
        var str = '.{$this->key}_' + val;
        if(curVal == val){
            $(str).show();
        }
        else{
            $(str).hide();
        }
        
    });
});
$("input[name='$name']:checked").click()
js;
    }
    
    public function addJs()
    {
        
    }
    
	public function footer()
	{
	    if(!$this->post)
	        return;
	    echo '<script>jQuery(function($){'.$this->js.'});</script>';
	    $this->addJs();
	}
	
}