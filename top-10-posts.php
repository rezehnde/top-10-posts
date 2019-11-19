<?php
/*
Plugin Name: Top 10 Posts
Plugin URI: https://rezehnde.com/
Description: Show a top 10 list from your popular blog posts easily.
Version: 1.2
Author: Marcos Rezende
Author URI: https://www.linkedin.com/in/rezehnde/
*/
function top10posts_func($atts) {
    extract(shortcode_atts(array(
                    'year' => date("Y"),
                    'month' => date("m")
            ), $atts));

    global $wpdb;
    $top10posts_list = "";
    $top10posts = $wpdb->get_results("SELECT id,post_title FROM {$wpdb->posts} where year(post_date) = coalesce($year, year(post_date)) and month(post_date) = coalesce($month, month(post_date))  and post_type = 'post' ORDER BY comment_count DESC LIMIT 0,10");
    if ($top10posts != null) {
        $top10posts_list = "<ul>";
        foreach($top10posts as $post) {
            $top10posts_list .= "<li><a href='". get_permalink($post->id) ."'>". $post->post_title ."</a></li>";
        }
        $top10posts_list .= "</ul></p>";
    }
    return $top10posts_list;
}
add_shortcode('top10posts', 'top10posts_func');

function top10posts_page() {
?>
<div class="wrap">
	<h2><?php _e('Top 10 Posts') ?></h2>
	by <strong>Marcos Rezende</strong> from <strong>Noxion</strong>
	<hr>
	<div style="float:right; width: 400px; background-color:white;padding: 0px 10px 10px 10px;margin-right:15px;border: 1px solid #ddd;">
		<div style="width:350px;height:130px;">
			<h3>Donate</h3>
			<em>If you like this plugin and find it useful, help keep this plugin free and actively developed by clicking the <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=marcos.ms.rezende%40gmail%2ecom&item_name=Top%2010%20Posts&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=BR&bn=PP%2dDonationsBF&charset=UTF%2d8" target="_blank"><strong>donate</strong></a> button.  Also, don't forget to follow me on <a href="http://twitter.com/insistimento/" target="_blank"><strong>Twitter</strong></a>.</em>
		</div>
		<a target="_blank" title="Donate"
		href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=marcos.ms.rezende%40gmail%2ecom&item_name=Top%2010%20Posts&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=BR&bn=PP%2dDonationsBF&charset=UTF%2d8">
		<img src="<?php echo get_option('siteurl') ?>/wp-content/plugins/top-10-posts/images/donate.jpg" alt="Donate with Paypal" />	</a>

		<a target="_blank" title="Fazer uma doa&ccedil;&atilde;o" href="https://pagseguro.uol.com.br/security/webpagamentos/webdoacao.aspx?email_cobranca=marcos.ms.rezende@gmail.com&moeda=BRL">
		<img src="<?php echo get_option('siteurl') ?>/wp-content/plugins/top-10-posts/images/pagseguro.jpg" alt="Pague com PagSeguro" /> </a>

		<a target="_blank" title="Follow me on Twitter" href="http://twitter.com/insistimento/">
		<img src="<?php echo get_option('siteurl') ?>/wp-content/plugins/top-10-posts/images/twitter.jpg" alt="Follow Me on Twitter" />	</a>
	</div>
        <h3>A little help</h3>
        <p>Put this custom tag inside posts or pages to show a top 10 list from your posts:</p>
        <ul>
            <li><code>[top10posts]</code> to show a top 10 list of posts of current year and current month</li>
            <li><code>[top10posts year=2009]</code> to show a top 10 list of posts of year 2009 and current month</li>
            <li><code>[top10posts year=2009 month=NULL]</code> to show a top 10 list of posts of year 2009 and all months</li>
            <li><code>[top10posts year=NULL month=NULL]</code> to show a top 10 list of posts from all the time</li>
        </ul>
</div>

<?php
}

function top10posts_configure_pages() {
	add_options_page('Top 10 Posts', 'Top 10 Posts', 8, __FILE__, 'top10posts_page');
}
// add_action('admin_menu', 'top10posts_configure_pages');

?>
