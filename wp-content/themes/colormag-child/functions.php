<?php 
/*
 * ColorMag-Child functions related to ColorMag.
 */
function colormag_child_enqueue_styles() {

	$parent_style = 'colormag_style'; //parent theme style handle 'colormag_style'

	//Enqueue parent and chid theme style.css
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' ); 
	wp_enqueue_style( 'colormag_child_style',
	    get_stylesheet_directory_uri() . '/style.css',
	    array( $parent_style ),
	    wp_get_theme()->get('Version')
	);
}
add_action( 'wp_enqueue_scripts', 'colormag_child_enqueue_styles' );

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');

/////////////////////////////////////////////////////////////////////////////
//// MOVE TO CONFIG /////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
function wp03_date($post)
{
    $return = '';
    //2017-03-12 04:13:25
    $return .= wp03_time_elapsed_string($post->post_date, false);
    //$return .= $post->post_date;

    return $return;
}
function wp03_time_elapsed_string($datetime, $full = false) 
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'yr',
        'm' => 'mon',
        'w' => 'wk',
        'd' => 'dy',
        'h' => 'hr',
        'i' => 'min',
        's' => 'sec',
    );
    //TODO Change to minutes to allow multiple color changes at different time 
    //  scales. For example, 10 min & 30 min, or 1 hour & 12 hours.
    $color2 = array(
        'm' => 'color: grey;',//grey
        'w' => 'color: blue;',//blue
        'd' => 'color: green;',//green
        'h' => 'color: red;',//red
        'i' => 'color: orange;',//orange
        's' => 'color: yellow;', //yellow
    );
    if ($diff->m < 3)
    {
        foreach ($string as $k => &$v) 
        {
            if ($diff->$k) 
            {
                $v = '<div style="' . $color2[$k] . '">' . 
                     $diff->$k . ' ' . $v . 
                     ($diff->$k > 1 ? 's</div>' : '</div>');
            } 
            else 
            {
                unset($string[$k]);
            }
        }

        if (!$full) 
        {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . '' : 'just now';
    }
    else
    {
        //March 01, 2017
        return mysql2date('M j, Y', $datetime);
    }
}

?>