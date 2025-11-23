<?php

/**
 * @name        xenice options elements
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-10
 * @link        http://www.xenice.com/
 * @package     xenice
 */

namespace vessel;

trait Elements
{
    private function none($field)
    {
        return '';
    }

    private function label($field)
    {
        return sprintf('<label>%s</label>', $field['value']);
    }

    private function button($field)
    {
        return sprintf('<input type="button" class="button" name="%s" value="%s" />', $field['id'], $field['value']);
    }

    private function text($field, $input = '')
    {
        $style = $field['style'] ?? 'regular';
        $label = $field['label'] ?? '';
        $str   = empty($field['show']) ? '' : $field['show'] . '="' . $field['show'] . '" '; // readonly or disabled
        if (isset($field['auto']) && $field['auto'] == false) {
            $str .= 'autocomplete="off"';
        }
        if ($input == '') {
            $input = '<label><input type="text" class="%s-text" name="%s" value="%s" %s/>%s</label>';
        }
        return sprintf($input, $style, $field['id'], $field['value'] ?? '', $str, $label);
    }

    private function number($field)
    {
        $style = $field['style'] ?? 'small';
        return sprintf(
            '<label><input type="number" class="%s-text" name="%s" value="%s" step="%s" min="%s" max="%s" />%s</label>',
            $style,
            $field['id'],
            $field['value'],
            $field['step'] ?? 1,
            $field['min'] ?? 0,
            $field['max'] ?? '',
            $field['label'] ?? ''
        );
    }
    
    private function color($field)
    {
        $style = $field['style'] ?? 'small';
        return sprintf(
            '<label><input type="color" class="%s-text" name="%s" value="%s" />%s</label>',
            $style,
            $field['id'],
            $field['value'],
            $field['label'] ?? ''
        );
    }


    private function textarea($field)
    {
        $style = $field['style'] ?? 'regular';
        $label = $field['label'] ?? '';
        $str   = empty($field['show']) ? '' : $field['show'] . '="' . $field['show'] . '" '; // readonly or disabled
        return sprintf('<label><textarea type="textarea" class="%s-text" name="%s" rows="%s" %s>%s</textarea>%s</label>', $style, $field['id'], $field['rows'], $str, $field['value'], $label);
    }

    private function radio($field)
    {
        $str = '';
        foreach ($field['opts'] as $key => $val) {
            if ($key == $field['value']) {
                $str .= sprintf('<label><input type="radio" name="%s" value="%s" checked />%s</label> &nbsp;&nbsp; ', $field['id'], $key, $val);
            } else {
                $str .= sprintf('<label><input type="radio" name="%s" value="%s" />%s</label> &nbsp;&nbsp; ', $field['id'], $key, $val);
            }
        }
        return $str;
    }

    private function radiotab($field)
    {
        $str = '';
        foreach ($field['opts'] as $key => $val) {
            if ($key == $field['value']) {
                $str .= sprintf('<label><input type="radio" name="%s" value="%s" data="%s" checked />%s</label> &nbsp;&nbsp; ', $field['id'], $key, $val[1] ?? '', $val[0]);
            } else {
                $str .= sprintf('<label><input type="radio" name="%s" value="%s" data="%s"/>%s</label> &nbsp;&nbsp; ', $field['id'], $key, $val[1] ?? '', $val[0]);
            }
        }
        return $str;
    }

    private function select($field)
    {
        $str = '<select name="' . $field['id'] . '" >';
        foreach ($field['opts'] as $key => $val) {
            if ($key == $field['value']) {
                $str .= sprintf('<option value ="%s" selected>%s</option>', $key, $val);
            } else {
                $str .= sprintf('<option value ="%s">%s</option>', $key, $val);
            }
        }
        $str .= '</select>';

        if (isset($field['label'])) {
            $str = sprintf('<label>%s %s</label>', $str, $field['label']);
        }
        return $str;
    }

    private function selectCategories($field)
    {
        $cats               = get_categories();
        $field['opts']['0'] = '';
        foreach ($cats as $cat) {
            $field['opts'][ $cat->cat_ID ] = $cat->cat_name;
        }
        return $this->select($field);
    }

    private function selectPages($field)
    {
        $args = array();
        if (! empty($field['author'])) {
            $args['authors'] = $field['author'];
        }
        $pages              = get_pages($args);
        $field['opts']['0'] = '';
        foreach ($pages as $page) {
            $field['opts'][ $page->ID ] = $page->postxxitle;
        }
        return $this->select($field);
    }

    private function checkbox($field)
    {
        $str = '';
        if ($field['value']) {
            $str .= sprintf('<label><input type="checkbox" name="%s" checked />%s</label> ', $field['id'], $field['label']);
        } else {
            $str .= sprintf('<label><input type="checkbox" name="%s" />%s</label> ', $field['id'], $field['label']);
        }
        return $str;
    }

    private function img($field)
    {
        $style  = $field['style'] ?? 'regular';
        $button = sprintf('<button class="button button-default xenice-img-select-%s">%s</button>', $field['id'], esc_html__('Select', 'onenice'));
        $str    = sprintf('<label><input type="text" class="%s-text" id="%s" name="%s" value="%s" />%s</label>', $style, $field['id'], $field['id'], $field['value'] ?? '', $button);
        $str   .= sprintf('<img id="img-%s" style="display:block;max-height:100px;margin-top:5px" src="%s" />', $field['id'], $field['value'] ?? '');
        $js     = <<<js
    $('.xenice-img-select-{$field['id']}').click(function(){
        var media = wp.media({
            title: 'Select Image',
            library: {type: 'image'},
            multiple: false,
            button: {text: 'Select'}
        });
        
        media.on('select', function() {
            var attachment = media.state().get('selection').first().toJSON();
            $('#{$field['id']}').attr('value',attachment.url);
            $('#img-{$field['id']}').attr('src',attachment.url);
        });
        media.open();
    	return false;
    });
js;
        add_filter(
            'xenice_' . $this->key . '_add_js',
            function ($str) use ($js) {
                $str .= "\r\n" . $js;
                return $str;
            }
        );
        return $str;
    }

    private function imgs($field)
    {
        $add_image = function ($src) {
            $str  = '';
            $str .= sprintf('<img class="imgs-img" src="%s" style="max-height:100px;margin-top:5px"/>', $src ?? '');
            return $str;
        };

        $str  = sprintf('<input type="hidden" class="xenice-imgs" name="%s" value="" />', $field['id']);
        $str .= sprintf('<div class="xenice-imgs-%s">', $field['id']);
        foreach ($field['value'] as $src) {
            $str .= $add_image($src);
        }
        $str .= '</div>';
        $str .= sprintf('<button class="button button-default xenice-img-add-%s">%s</button>', $field['id'], esc_html__('Add', 'onenice'));

        $img = $add_image('{src}');
        $js  = <<<js
    $('.xenice-img-add-{$field['id']}').click(function(){ // 增加图片
        var media = wp.media({
            title: 'Add Image',
            library: {type: 'image'},
            multiple: false,
            button: {text: 'Add'}
        });
        
        media.on('select', function() {
            var attachment = media.state().get('selection').first().toJSON();
            var str = '$img';
        	str = str.replace(RegExp('{src}', 'g'), attachment.url);
        	$('.xenice-imgs-{$field['id']}').append($(str));
        	
        	$('.xenice-imgs-{$field['id']} img').dblclick(function(){  // 移除图片
                $(this).remove();
                return false;
            });
        });
        media.open();
    	return false;
    });
js;
        add_filter(
            'xenice_' . $this->key . '_add_js',
            function ($str) use ($js) {
                $str .= "\r\n" . $js;
                return $str;
            }
        );
        return $str;
    }

    private function image($field)
    {
        $value = $field['value'];
        $str   = sprintf('<input type="hidden" class="xenice-image" name="%s" value="" />', $field['id']);
        $str  .= '<div class="slide-data"><div style="margin-bottom:5px">' . esc_html__('URL:', 'onenice') . '</div>';
        $str  .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_url', $value['url'] ?? '');
        $str  .= '<div style="margin-bottom:5px;margin-top:10px">' . esc_html__('Title:', 'onenice') . '</div>';
        $str  .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . 'xxitle', $value['title'] ?? '');
        $str  .= '<div style="margin-bottom:5px;margin-top:10px">' . esc_html__('Description:', 'onenice') . '</div>';
        $str  .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_desc', $value['desc'] ?? '');
        $str  .= '<div style="margin-bottom:5px;margin-top:10px">' . esc_html__('Image Path:', 'onenice') . '</div>';
        $str  .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" /></div>', $field['id'] . '_src', $value['src'] ?? '');
        $str  .= sprintf('<img class="slide-img" src="%s" />', $value['src'] ?? '');
        return $str;
    }

    private function slide($field)
    {
        $add_image = function ($index, $value = array()) use ($field) {
            $str  = '';
            $str .= sprintf('<div style="margin-bottom:30px" class="xenice-image-%s">', $field['id']);
            $str .= '<div style="margin-bottom:10px;font-weight:bold;">' . esc_html__('Image', 'onenice') . ' ' . $index . '</div>';
            $str .= '<div class="slide-data"><div style="margin-bottom:5px">' . esc_html__('URL:', 'onenice') . '</div>';
            $str .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_url_' . $index, $value['url'] ?? '');
            $str .= '<div style="margin-bottom:5px;margin-top:10px">' . esc_html__('Title:', 'onenice') . '</div>';
            $str .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_title_' . $index, $value['title'] ?? '');
            $str .= '<div style="margin-bottom:5px;margin-top:10px">' . esc_html__('Description:', 'onenice') . '</div>';
            $str .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" />', $field['id'] . '_desc_' . $index, $value['desc'] ?? '');
            $str .= '<div style="margin-bottom:5px;margin-top:10px">' . esc_html__('Image Path:', 'onenice') . '</div>';
            $str .= sprintf('<input type="text" class="regular-text" id="%s" value="%s" /></div>', $field['id'] . '_src_' . $index, $value['src'] ?? '');
            $str .= sprintf('<img class="slide-img" src="%s" />', $value['src'] ?? '');
            $str .= '<div style="clear:both"></div></div>';
            return $str;
        };

        $str   = sprintf('<input type="hidden" class="xenice-slide" name="%s" value="" />', $field['id']);
        $str  .= sprintf('<div class="xenice-slide-%s">', $field['id']);
        $index = 0;
        foreach ($field['value'] as $value) {
            $str .= $add_image($index, $value);
            $index++;
        }
        $str .= sprintf('</div><button class="button button-default xenice-slide-add-%s">%s</button>', $field['id'], esc_html__('Add', 'onenice'));

        // js add image
        $image = $add_image('index');
        $js    = <<<js
    $('.xenice-slide-add-{$field['id']}').click(function(){
        var length = $('.xenice-image-{$field['id']}').length;
    	var str = '$image';
    	str = str.replace(RegExp('index', 'g'), length);
    	$('.xenice-slide-{$field['id']}').append($(str));
    	return false;
    });
js;
        add_filter(
            'xenice_' . $this->key . '_add_js',
            function ($str) use ($js) {
                $str .= "\r\n" . $js;
                return $str;
            }
        );
        return $str;
    }
}
