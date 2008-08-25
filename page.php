<?php get_header()?>
	<div id="content">
		<div id="main">
			<?php if ($posts) : foreach ($posts as $post) : start_wp(); ?>
			<div class="post">
				<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<div class="post-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>				
					<?php $sub_pages = wp_list_pages( 'sort_column=menu_order&depth=1&title_li=&echo=0&child_of=' . $id );?>
					<?php if ($sub_pages <> "" ){?>
						<p class="post-info">Also see these sub-pages.</p>
						<ul><?php echo $sub_pages; ?></ul>
					<?php }?>	
					<p class="post-info">
						<?php the_author_posts_link() ?> :: <?php the_time('M.d.Y'); ?> :: 
						<?php the_category(', ') ?> <?php edit_post_link(); ?> :: 
						<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
					</p>
					<!--
					<?php trackback_rdf(); ?>
					-->
				</div>
				<?php comments_template(); ?>
			</div>
			<?php endforeach; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php  endif; ?>
			<p align="center"><?php posts_nav_link() ?></p>
		</div>
	</div>
<?php get_sidebar();?>
<?php get_footer();?>