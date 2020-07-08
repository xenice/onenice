<?php

namespace app\web\model\part;

trait Paginate
{
    protected function paginateLinks($base_url, $pagination_base, $max_page, $paged, $space = 5, $replace='/%#%', $pos = '')
    {
        if ( $max_page == 1 ) {
            return;
        }
        if ( empty( $paged ) ) {
            $paged = 1;
        }
        
        if ( $paged > 1 ) {
            printf( '<li class="page-item"><a class="page-link" href="%s" title="%s">%s</a><li>', $this->paginateUrl($base_url, $pagination_base, $paged - 1, $replace, $pos ), '« Previous', '«' );
        }
        if ( $paged > $space + 2 ) {
            echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
        }
        
        for ( $i = $paged - $space; $i <= $paged + $space; $i ++ ) {
            if ( $i > 0 && $i <= $max_page ) {
                if ( $i == $paged ) {
                    echo '<li class="page-item active"><a class="page-link">' . $i . '</a></li>';
                } else {
                    printf( '<li class="page-item"><a class="page-link" href="%s" title="page %s">%s</a><li>', $this->paginateUrl($base_url, $pagination_base, $i, $replace, $pos ), $i, $i );
                }
            }
        }
        if ( $paged < $max_page - $space - 1 ) {
            echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
        }
        if ( $paged < $max_page ) {
            printf( '<li class="page-item"><a class="page-link" href="%s" title="%s">%s</a></li>',$this->paginateUrl($base_url, $pagination_base, $paged + 1, $replace, $pos ), 'Next »', '»' );
        }
    }
    
    protected function paginateUrl($base_url, $pagination_base, $i, $replace, $pos)
    {
        $url = '';
        if($pagination_base == ''){
            if($i == 1 ){
                $url = $this->addUrlArgs($base_url, ['paged']);
            }
            elseif($pagination_base == ''){ 
                $url = $this->addUrlArgs($base_url);
                $url = add_query_arg( 'paged', $i, $url);
            }
        }
        else{
            if($i==1){
                $url = $this->addUrlArgs($base_url, ['paged']);
            }
            else{
                $replace = str_replace('%#%', $i, $replace);
                $url = $this->addUrlArgs($base_url . $pagination_base . $replace);
            }
        }
        return esc_html(trim($url, '/') . $pos);
    }
    
    protected function addUrlArgs($url, $exclude = [])
    {
        foreach($_GET as $key=>$value){
            if(!in_array($key, $exclude)){
                $url = add_query_arg( $key, $value, $url);
            }
        }
        return $url;
    }
    
}