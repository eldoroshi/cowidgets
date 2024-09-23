					<!-- Testimonial Block -->
					<div class="ce-testimonial-item ">
						<div class="inner-box">
							<div class="author-image">
								<?php the_post_thumbnail('thumbnail'); ?>
							</div>
							<h4><?php echo esc_html(get_the_title()) ?></h4>
							<div class="rating">
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
							</div>
							<div class="text"><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></div>

						</div>
					</div>