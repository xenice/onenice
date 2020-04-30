<?php

namespace app\web\model\part;

use xenice\theme\Theme;

trait Model
{
    public function since($date, $comment_date = false )
    {
        $older_date = strtotime($date);
        $chunks = array(
            array( 24 * 60 * 60, _t( ' days ago') ),
            array( 60 * 60, _t( ' hours ago') ),
            array( 60, _t( ' minutes ago') ),
            array( 1, _t( ' seconds ago') )
        );
    
        $newer_date = time();
        $since      = abs( $newer_date - $older_date );

        if ( $since < 30 * 24 * 60 * 60 ) {
            for ( $i = 0, $j = count( $chunks ); $i < $j; $i ++ ) {
                $seconds = $chunks[ $i ][0];
                $name    = $chunks[ $i ][1];
                if ( ( $count = floor( $since / $seconds ) ) != 0 ) {
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