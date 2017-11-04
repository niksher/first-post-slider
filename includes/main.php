<?php

  function first_news_slider() {
      global $wpdb;
      
      $layout = wi_layout();
      // loop
      $loop = $layout;
      if (strpos($loop,'grid')!==false) $loop = 'grid';
      if (strpos($loop,'masonry')!==false) $loop = 'masonry';


      $table_name = $wpdb->prefix . "first_post_slider_plugin";
      $plugin_posts_temp = $wpdb->get_results("SELECT * FROM $table_name");
      $pliginIds = [];
      foreach ($plugin_posts_temp as $pp) {
          $pliginIds[] = $pp->postId;
      }

      $pliginArgs = [
          'post__in' => $pliginIds
          , 'posts_per_page' => 10
      ];
      $active_plugin = get_option("firstpostslider_status");
      if (count($pliginIds) == 0 || $active_plugin == "0") {
          return "";
      }

      $sliderNews = new WP_Query( $pliginArgs );


      $column_class = get_post_meta( get_the_ID(), '_wi_column_layout', true );
      if ( ! $column_class ) {
          $column_class = get_theme_mod('wi_disable_blog_2_columns') ? 'single-column' : 'two-column';
      }
      $column_class = ( $column_class == 'single-column' ) ? 'disable-2-columns' : 'enable-2-columns';
      ob_start();
      ?>

      <article <?php post_class('post-masonry'); ?>>    
          <div class="wi-flexslider blog-slider firstnews-slider">

              <div class="flexslider">
                  <ul class="slides">
                      <?php while($sliderNews->have_posts()):$sliderNews->the_post();?>
                      <li>
                          
                          
<article id="slide-<?php the_ID(); ?>" <?php post_class('post-slider'); ?>>
    
    <?php wi_display_thumbnail('thumbnail-big','slider-thumbnail',false,false); ?>
    
    <section class="slider-body">
        
        <div class="slider-table"><div class="slider-cell">
        
            <div class="post-content">

                <header class="slider-header">

                    <h2 class="slider-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

                </header><!-- .slider-header -->
                
                <div class="slider-excerpt">
                    <p>
                        <span class="slider-meta">
                            <span class="slider-date">
                                <time datetime="<?php echo get_the_date('c');?>"><?php printf( __('Published on %s','wi'), get_the_date(get_option('date_format')) );?></time>
                            </span><!-- .slider-date -->
                        </span><!-- .slider-meta -->
                        
                        <?php echo wi_subword(get_the_excerpt(),0,20);?>&hellip;
                        
                        <a class="slider-more" href="<?php the_permalink();?>"><?php _e('Keep Reading','wi');?></a>
                    </p>
                
                </div>
                
                <div class="clearfix"></div>

            </div><!-- .post-content -->
            
        </div></div><!-- .slider-cell --><!-- .slider-table -->
        
    </section><!-- .slider-body -->
    
    <div class="clearfix"></div>
    
</article><!-- .post-slider -->

                          
                          
                          
                      </li>
                      <?php endwhile;?>
                  </ul>
              </div><!-- .flexslider -->
              <div class="clearfix"></div>

          </div>
      </article>

      <?php
      $out = ob_get_contents();
      ob_end_clean();
      return $out;
  }

  function limit_posts_per_page() {
      global $firstNewsIsSlider;
      if ( !$firstNewsIsSlider && get_query_var( 'paged' ) < 2) {
          return 9;
      } else {
          return 10;
      }        
  }
  add_filter ('pre_option_posts_per_page', 'limit_posts_per_page');

  /**
   * @global boolean $firstNewsIsSlider
   * @return boolean
   */
  function echo_first_news_slider($firstNewsSlider) {
      global $firstNewsIsSlider;

      if (!$firstNewsIsSlider && get_query_var( 'paged' ) < 2) {
          $firstNewsIsSlider = true;
          echo $firstNewsSlider;

      }
  }
