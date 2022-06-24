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

class Box
{
    protected $post;
    protected $js = '';
    
    protected $key;
    protected $name;
    protected $type;
    protected $context;
    protected $priority;
    protected $options  = [];
    protected $defaults = [];
    
    
    
    use Elements;
    
	public function __construct($args = [])
	{
	    //add_action('admin_enqueue_scripts', function(){wp_enqueue_media();});
	    isset($args['defaults']) && $this->defaults = $args['defaults'];
        isset($args['key']) && $this->key = $args['key'];
        isset($args['name']) && $this->name = $args['name'];
        isset($args['type']) && $this->type = $args['type'];
        isset($args['context']) && $this->context = $args['context'];
        isset($args['priority']) && $this->priority = $args['priority'];
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
		add_meta_box( $this->key . '-meta-box', $this->name, [$this, 'metaForm'], $this->type?:$this->key, $this->context?:'normal', $this->priority?:'high' );
		add_action('admin_footer', [$this,'footer']);
	}
	
	public function metaForm($post)
	{
	    ?>
	    <style>
        .postbox .slide-img{
            margin:25px 0 0 0;
            max-height:210px;
        }
        
        .postbox .small-text,.wrap input[type="checkbox"],.wrap input[type="radio"]{
            margin-right:8px;
            margin-bottom:8px;
        }
        
        @media screen and (min-width:768px){
            .postbox .slide-data{
                float:left;
                margin-right:20px;
            }
            .postbox .regular-text{
                margin-right:8px;
            }
            .postbox label textarea{
                vertical-align: top;
            }
        }
        </style>
	    <?php
	    $this->get($post->ID);
	    $this->post = $post;
	    $fields = $this->options;
	    $html = '<table class="form-table">';
	    foreach($fields as $field){
	        $style = (isset($field['style'])&&$field['style']=='none')?'display:none':'';
            if(isset($field['fields'])){
                $field['id'] = $this->key . '_' . $field['id'];
                $html .= '<tr style="'.$style.'" class="'.$field['id'].'"><th>'.$field['name'].'</th><td>';
                foreach($field['fields'] as $f){
                    $f['id'] = $this->key . '_' . $f['id'];
                    $html .= '<p>' . call_user_func_array([$this,$f['type']],[$f]) . '</p>';
                    if($f['type'] == 'radiotab'){
        	            $this->addRadioJs($f['id']);
        	        }
                }
            }
            else{
                $field['id'] = $this->key . '_' . $field['id'];
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
            if(isset($field['fields'])){
                foreach($field['fields'] as $f){
                    $key = $this->key . '_' .  $f['id'];
        	        if($f['type'] == 'checkbox'){
        	            $_POST[$key] = isset($_POST[$key])?true:false;
        	        }
        	        $arr[$f['id']] = $_POST[$key];
                }
            }
            else{
                $key = $this->key . '_' .  $field['id'];
    	        if($field['type'] == 'checkbox'){
    	            $_POST[$key] = isset($_POST[$key])?true:false;
    	        }
    	        $arr[$field['id']] = $_POST[$key];
            }
        }
        
        
		if($arr){
		    remove_action('save_post', [$this,'save']);
		    $this->update($post_id, $arr);
		}
	}
	
    
    public function addJs()
    {
        
    }
    
    private function addRadioJs($name)
    {
        $this->js .=<<<js
$("input[name='$name']").click(function(){
    var curVal = $(this).val();
    $("input[name='$name']").each(function(){
        var val = $(this).val();
        
        if(curVal == val){
            var arr = $(this).attr("data").split(',');
            for(let key in arr) {
                var val = arr[key];
                var str = '.{$this->key}_' + val;
                $(str).show();
               
            }
        }
        else{
            var arr = $(this).attr("data").split(',');
            for(let key in arr) {
                var val = arr[key];
                var str = '.{$this->key}_' + val;
                $(str).hide();
            }
        }
    });
});
$("input[name='$name']:checked").click()
js;
    }
    
	public function footer()
	{
	    ?>
	        <script>
	            
                jQuery(function($){
                  var handle = function(e){
                    $('.xenice-image').each(function(){
                        var value = '';
                        var id = this.name;
                        value += '"url":' + '"' + $('#' + id + '_url').val() + '",';
                        value += '"title":' + '"' + $('#' + id + '_title').val() + '",';
                        value += '"desc":' + '"' + $('#' + id + '_desc').val() + '",';
                        value += '"src":' + '"' + $('#' + id + '_src').val() + '"';
                        value  = '{' + value + '}';
                        this.value = value;
                    });
                    
                    // imgs
                    $('.xenice-imgs').each(function(){
                        var value = '';
                        var id = this.name;
                        $('.xenice-imgs-' + id + ' img').each(function(i, e){
                            value  += '"' + $(this).attr("src") + '",';
                        });
                        value = value.substring(0, value.lastIndexOf(','));
                        this.value = '[' + value + ']';
                        
                    });

                    // slide
                    $('.xenice-slide').each(function(){
                        var value = '';
                        var id = this.name;
                        $('.xenice-image-' + id ).each(function(i, e){
                            if($('#' + id + '_src_' + i).val() != ''){
                                value  += '{'
                                value += '"url":' + '"' + $('#' + id + '_url_' + i).val() + '",';
                                value += '"title":' + '"' + $('#' + id + '_title_' + i).val() + '",';
                                value += '"desc":' + '"' + $('#' + id + '_desc_' + i).val() + '",';
                                value += '"src":' + '"' + $('#' + id + '_src_' + i).val() + '"';
                                value += '},';
                            }
                        });
                        value = value.substring(0, value.lastIndexOf(','));
                        this.value = '[' + value + ']';
                    });
                    
                    //e.preventDefault();
                  }
                  $("#post").submit(handle);
                  
                  
                  
                  <?php echo Theme::get('xenice_admin_ready')?>
                });
                
            </script>
        <?php
	    if(!$this->post)
	        return;
	    echo '<script>jQuery(function($){'.$this->js.'});</script>';
	    $this->addJs();
	}
	
}