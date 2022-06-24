<?php

namespace app\pro\model\pointer;

use xenice\theme\Theme;

class Article extends \app\web\model\pointer\Article
{
    private $shotcodes = [];
    
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
    /*
    public function shortcode($tagname = 'data')
    {
        if(isset($this->shotcodes[$tagname])){
           return $this->shotcodes[$tagname];
        }
        $shortcode = [];
        $pattern = get_shortcode_regex([$tagname]);
        if (preg_match_all( '/'. $pattern .'/s', $this->row('post_content'), $matches) && array_key_exists(2, $matches)){
            $shortcode['code'] = $matches[0][0];
            $shortcode['atts'] = shortcode_parse_atts($matches[0][0]);
            unset($shortcode['atts'][0]);
            unset($shortcode['atts'][1]);
            $shortcode['value'] = $matches[5][0];
            $this->shotcodes[$tagname] = $shortcode;
            return $shortcode;
        }
    }
    
    public function atts($name, $tagname = 'data')
    {
        if(isset($this->shotcodes[$tagname]['atts'][$name])){
           return $this->shotcodes[$tagname]['atts'][$name];
        }
        if(isset($this->shotcodes[$tagname])){ // already execute
           return;
        }
        $shortcode = $this->shortcode($tagname);
        return $shortcode['atts'][$name]??null;
    }
    
    public function thumbnail($type = 'full')
    {
       if(empty($this->atts('image'))){
            return parent::thumbnail($type);
       }
       else{
            return $this->atts('image');
       }
    }
   
    public function price()
    {
       if(empty($this->atts('price'))){
            return _t('Free');
       }
       else{
            return '￥' . $this->atts('price');
       }
    }
   
    public function cnt($tags = ['data'])
    {
        $content = $this->content();
        $pattern = get_shortcode_regex($tags);
        //$pattern = '\[(\[?)([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
        $content = preg_replace("/$pattern/", '', $content);
        return $content;
    }*/
}