<?php
/**** Pagination begins ****/
$total = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format = isset($format) ? $format : '';

if ($total > 1) {
    global $wp_query;
    $pagination = paginate_links(array(
        'base' => str_replace(9999999, '%#%', esc_url(get_pagenum_link(9999999))),
        'format' => '?paged=%#%',
        'prev_text' => '<i class="left arrow icon"></i>',
        'next_text' => '<i class="right arrow icon"></i>',
        'end_size' => 2,
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'type' => 'array'
    ));

    if (!empty($pagination) && is_array($pagination)) {
        foreach ($pagination as &$link) {
            $link = str_ireplace('page-numbers current', 'item active', $link);
            $link = str_ireplace('page-numbers dots', 'item active', $link);
            $link = str_ireplace('page-numbers', 'item', $link);
        }

        printf(
            '<div class="ui basic inverted center aligned segment"><div class="ui inverted borderless pagination menu">%1$s</div></div>',
            implode(' ', $pagination)
        );
    }
}
    /**** Pagination ends ***/
?>