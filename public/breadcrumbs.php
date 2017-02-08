<?php

function lj_breadcrumbs($class = 'breadcrumbs') {

	// Global post variable
	global $post;

	echo '<div class="' . $class . '">';
	echo '<ul>';

	// If isn't the home page then provide link to home page
	if(!is_page('home')) {
		echo '<li><a href="' . home_url() . '">Home</a></li>';
	}

	// If page has parent(s), output the trail
	if(is_page() && $post->post_parent) {

		$trail = '';
		$parent = $post->post_parent;

		if($post->post_parent) {
			 $parent_id = $post->post_parent;

			while($parent_id) {
				$page = get_page($parent_id);
				$pages[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
				$parent_id = $page->post_parent;
			}

			$pages = array_reverse($pages);

			foreach ($pages as $page) {
				$trail .= $page;
			}

			echo $trail;
		}

	}

	// Indicate if on blog index
	if(is_home()) {
		$blog_title = get_the_title(get_option('page_for_posts', true));

		echo '<li>' . $blog_title . '</li>';
	}

	// If is a single blog post provide trail back to main index
	if(is_singular('post') || is_category()) {
		$blog_title = get_the_title(get_option('page_for_posts', true));
		$blog_link = get_permalink(get_option('page_for_posts', true));

		echo '<li><a href="' . $blog_link . '">' . $blog_title . '</a></li>';
	}

	if(is_category()) {
		$cat_title = single_cat_title('', false);

		echo '<li>' . $cat_title . '</li>';
	}

	if(is_post_type_archive()) {
		echo '<li>';
		post_type_archive_title();
		echo '</li>';
	}

	// If singular output title with no link
	if(is_singular()) {
		echo '<li>' . get_the_title() . '</li>';
	}

	echo '</ul>';
	echo '</div>';
}