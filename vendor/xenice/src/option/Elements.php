<?php
/**
 * @name        xenice options elements
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-10
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\option;

use xenice\theme\Theme;

trait Elements
{
    
    private function label($field)
    {
        return sprintf( '<label>%s</label>', $field['value']);
    }
    
    private function button($field)
    {
        return sprintf( '<input type="button" class="button" name="%s" value="%s" />',$field['id'], $field['value']);
    }
    
    private function text($field)
    {
        $style = $field['style']??'regular';
        $label = $field['label']??'';
        $str = empty($field['show'])?'':$field['show'] . '="' . $field['show'] . '" '; // readonly or disabled
        if(isset($field['auto']) && $field['auto'] == false){
            $str .= 'autocomplete="off"';
        }
        return sprintf( '<label><input type="text" class="%s-text" name="%s" value="%s" %s/>%s</label>', $style, $field['id'], $field['value']??'', $str, $label);
    }

    private function number($field)
    {
        $style = $field['style']??'small';
        return sprintf( '<input type="number" class="%s-text" name="%s" value="%s" step="%s" min="%s" max="%s" />', 
        $style,$field['id'], $field['value'], $field['step']??1,$field['min']??0,$field['max']??'');
    }

    private function textarea($field)
    {
        $style = $field['style']??'regular';
        $label = $field['label']??'';
        return sprintf( '<label><textarea type="textarea" class="%s-text" name="%s" rows="%s" >%s</textarea>%s</label>', $style, $field['id'], $field['rows'], $field['value'], $label);
    }

    private function radio($field)
    {
        $str = '';
        foreach ( $field['opts'] as $key => $val ){
            if($key == $field['value']){
                $str .= sprintf( '<label><input type="radio" name="%s" value="%s" checked />%s</label> &nbsp;&nbsp; ', $field['id'], $key, $val);
            }
            else{
                $str .= sprintf( '<label><input type="radio" name="%s" value="%s" />%s</label> &nbsp;&nbsp; ', $field['id'], $key, $val);
            }
        }
        return $str;
    }
    
    private function select($field)
    {
        $str = '<select name="'.$field['id'].'" >';
        foreach ( $field['opts'] as $key => $val ){
            if($key == $field['value']){
                $str .= sprintf( '<option value ="%s" selected>%s</option>', $key, $val);
            }
            else{
               $str .= sprintf( '<option value ="%s">%s</option>', $key, $val);
            }
        }
        $str .= '</select>';
        
        if(isset($field['label'])){
            $str = sprintf( '<label>%s %s</label>', $str, $field['label']);
        }
        return $str;
    }
    
    private function selectCategories($field)
    {
        $cats= get_categories();
        foreach($cats as $cat){
            $field['opts'][$cat->cat_ID] = $cat->cat_name;
        }
        return $this->select($field);
    }
    
    private function selectPages($field)
    {
        $pages = get_pages();
        foreach($pages as $page){
            $field['opts'][$page->ID] = $page->post_title;
        }
        return $this->select($field);
    }
    
    private function checkbox($field)
    {
        $str = '';
        if($field['value']){
            $str .= sprintf( '<label><input type="checkbox" name="%s" checked />%s</label> ', $field['id'], $field['label']);
        }
        else{
            $str .= sprintf( '<label><input type="checkbox" name="%s" />%s</label> ', $field['id'], $field['label']);
        }
        return $str;
    }
    
    private function img($field)
    {
        $style = $field['style']??'regular';
        $label = $field['label']??'';
        $str = sprintf( '<label><input type="text" class="%s-text" name="%s" value="%s" />%s</label>', $style, $field['id'], $field['value']??'', $label);
        $str .= sprintf( '<img style="display:block;max-height:100px;margin-top:5px" src="%s" />', $field['value']??'');
        return $str;
    }
    
    private function image($field)
    {
        $value = $field['value'];
        $str = sprintf( '<input type="hidden" class="xenice-image" name="%s" value="" />', $field['id']);
        $str .= '<div class="slide-data"><div style="margin-bottom:5px">' . _t('URL:').'</div>';
        $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_url', $value['url']??'');
        $str .=  '<div style="margin-bottom:5px;margin-top:10px">' . _t('Title:').'</div>';
        $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_title', $value['title']??'');
        $str .=  '<div style="margin-bottom:5px;margin-top:10px">' . _t('Description:').'</div>';
        $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_desc', $value['desc']??'');
        $str .=  '<div style="margin-bottom:5px;margin-top:10px">' . _t('Image Path:').'</div>';
        $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" /></div>', $field['id'] . '_src', $value['src']??'');
        $str .= sprintf( '<img class="slide-img" src="%s" />', $value['src']??'');
        return $str;
    }
    
    private function slide($field)
    {
        $add_image = function($index, $value = [])use($field){
            $str = '';
            $str .= sprintf( '<div style="margin-bottom:30px" class="xenice-image-%s">', $field['id']);
            $str .= '<div style="margin-bottom:10px;font-weight:bold;">' . _t('Image') . ' ' . $index .'</div>';
            $str .= '<div class="slide-data"><div style="margin-bottom:5px">' . _t('URL:').'</div>';
            $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_url_' . $index, $value['url']??'');
            $str .= '<div style="margin-bottom:5px;margin-top:10px">' . _t('Title:').'</div>';
            $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_title_' . $index, $value['title']??'');
            $str .= '<div style="margin-bottom:5px;margin-top:10px">' . _t('Description:').'</div>';
            $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_desc_' . $index, $value['desc']??'');
            $str .= '<div style="margin-bottom:5px;margin-top:10px">' . _t('Image Path:').'</div>';
            $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" /></div>', $field['id'] . '_src_' . $index, $value['src']??'');
            $str .= sprintf( '<img class="slide-img" src="%s" />', $value['src']??'');
            $str .= '<div style="clear:both"></div></div>';
            return $str;
        };
        
        $str = sprintf( '<input type="hidden" class="xenice-slide" name="%s" value="" />', $field['id']);
        $str .= sprintf( '<div class="xenice-slide-%s">', $field['id']);
        $index = 0;
        foreach($field['value'] as $value){
            $str .= $add_image($index, $value);
            $index ++;
        }
        $str .= sprintf('</div><button class="button button-default xenice-slide-add-%s">%s</button>', $field['id'], _t('Add'));
        
        // js add image
        $image = $add_image('index');
        $js =<<<js
    $('.xenice-slide-add-{$field['id']}').click(function(){
        var length = $('.xenice-image-{$field['id']}').length;
    	var str = '$image';
    	str = str.replace(RegExp('index', 'g'), length);
    	$('.xenice-slide-{$field['id']}').append($(str));
    	return false;
    });
js;
        Theme::set('xenice_admin_ready', $js, true);
        return $str;
    }
}