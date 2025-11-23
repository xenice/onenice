<?php

class YYThemes_Relative_Date
{
    public function __construct()
    {
        add_filter('yythemes_ext_more_fields', [$this, 'fields']);
        if(yy_ext_get('enable_relative_date')){
            add_filter( 'the_date', [$this, 'format_date'], 20, 1);
            add_filter( 'get_the_date', [$this, 'format_get_date'], 20, 3);
            add_filter( 'the_modified_date', [$this, 'format_modified_date'], 20, 1);
            add_filter( 'get_the_modified_date', [$this, 'format_get_modified_date'], 20,3);
        }
        
    }
    
    public function fields($fields)
    {
        $fields[] = [
            'id'   => 'enable_relative_date',
            'name'  => esc_html__('Relative date', 'onenice'),
            'type'  => 'checkbox',
            'value' => true,
            'label'  => esc_html__('The posts show relative dates', 'onenice')
        ];
        return $fields;
    }
    
    /**
     * Format time
     *
     */
    public function format_date($date){
        $older_date = get_post_time('U', true);
        return $this->since($older_date);
    }
    
    
    public function format_get_date($date, $format, $post){
        $older_date = get_post_time('U', true, $post);
        return $this->since($older_date);
    }
    
    
    
    /**
     * Format modified time
     *
     */
    
    public function format_modified_date($date){
        $older_date = get_post_modified_time('U', true);
        return $this->since($older_date);
    }
    
    
    public function format_get_modified_date($date, $format, $post){
        $older_date = get_post_modified_time('U', true, $post);
        return $this->since($older_date);
    }

    /**
     * Since time
     *
     */
    public function since($older_date, $comment_date = false ){
        
        $chunks = array(
            array( 12 * 30 * 24 * 60 * 60, __( ' years ago', 'onenice') ),
            array( 30 * 24 * 60 * 60, __( ' months ago', 'onenice') ),
            array( 24 * 60 * 60, __( ' days ago', 'onenice') ),
            array( 60 * 60, __( ' hours ago', 'onenice') ),
            array( 60, __( ' minutes ago', 'onenice') ),
            array( 1, __( ' seconds ago', 'onenice') )
        );
    
        $newer_date = time();
        $since      = abs( $newer_date - $older_date );
        
        if ( $since < 10 * 12 * 30 * 24 * 60 * 60 ) {
            for ( $i = 0, $j = count( $chunks ); $i < $j; $i ++ ) {
                
                $seconds = $chunks[ $i ][0];
                $name    = $chunks[ $i ][1];
                if (($count = floor($since / $seconds )) != 0 ) {
                    break;
                }
            }
            $output = $count . $name;
        } else {
            $output = $comment_date ? date( 'Y-m-d H:i', $older_date ) : date( 'Y-m-d', $older_date );
        }
        return $output;
    }
}





