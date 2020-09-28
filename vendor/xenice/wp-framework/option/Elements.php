<?php
/**
 * @name        xenice options elements
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-10
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\option;

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
    
    private function selectCategories($field)
    {
        $cats= get_categories();
        foreach($cats as $cat){
            $field['opts'][$cat->cat_ID] = $cat->cat_name;
        }
        return $this->select($field);
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
        $str .= sprintf( '<input type="text" class="regular-text" id="%s" value="%s" /></div>', $field['id'] . '_path', $value['path']??'');
        $str .= sprintf( '<img class="slide-img" src="%s" />', $value['path']??'');
        return $str;
    }
}