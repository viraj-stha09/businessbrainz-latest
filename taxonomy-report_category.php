<?php
get_header();
$term = get_queried_object();
?>
<input type="hidden" value="<?php echo $term->slug; ?>" id="custom_taxonomy">
<div class="report-hero">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 order-md-2 d-flex justify-content-end">
                <?php
                $image = get_field('featured_image', $term);

                if($image):
                $image_srcset = wp_get_attachment_image_srcset($image['id']);
                ?>
                <img class="report-feature-image" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>"
                     srcset="<?php echo $image_srcset ?>">
                <?php endif; ?>
            </div>
            <div class="col-md-6 order-md-1">
                <div class="content-wrapper">
                    <div>
                        <h2 class="heading"><?php the_field('sub_heading', $term); ?></h2>
                        <h3 class="subheading mt-2"><?php echo $term->name; ?></h3>
                        <div class="description mt-3"><?php echo $term->description; ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="report-listing-wrapper mb-3">
        <div class="container">
            <section id="breadcrumb">
                <div class="row">
                    <ol id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="pr-3" href="<?php echo get_bloginfo( 'url' ) ?>">Home</a> ></li>
                        <li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="pl-3 pr-3" href="<?php echo get_bloginfo( 'url' ).'\reports' ?>">Report</a> ></li>
                        <li itemprop="itemListElement" itemtype="http://schema.org/ListItem" class="pl-3"><?php echo $term->name; ?></li>
                    </ol>
                </div>
            </section>
            <div class="row">
                <div id="filter-section" class="col-lg-3">
                    <div class="container ">
                        <div class="col-12">
                            <div class="heading">Filter Resources</div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="col-12">
                            <div class="search-section">
                                <form id="search-research">
                                    <div class="input-group mb-3 mt-2">
                                        <input type="text" placeholder="Search" id="search-report" class="form-control"
                                               aria-label="search" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sub-heading">
                                Categories
                            </div>
                            <div class="category-list">
                                <ul>
                                    <?php render_category_list($term) ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="report-list" class="col-lg-9">
                    <?php
                    $args = array(
                        'post_type'      => 'reports',
                        'order'          => 'ASC',
                        'posts_per_page' => 6,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'report_category',
                                'field'    => 'slug',
                                'terms'    => $term->slug,
                            ),
                        ));
                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()) : ?>
                        <div class="row">
                            <?php while ($the_query->have_posts()) :
                                $the_query->the_post(); ?>
                                <div class="col-md-6 col-sm-12 fix-width-3 card report-box mt-2">
                                    <a href="<?php the_permalink(); ?>">
                                        <div style="background: url('<?php the_post_thumbnail_url('thumbnail'); ?>');background-repeat:no-repeat;background-position: center; height: 200px"></div>
                                        <div class="card-body single-report-content">
                                            <div class="title"><?php the_title(); ?></div>
                                            <div class="category"><?php echo show_sectors(get_the_ID()); ?></div>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php wp_reset_postdata();
                    else: ?>
                        <div class="row">
                            <div class="col-12 mt-5 text-center">
                                <h3>No reports found</h3>
                            </div>
                        </div>
                    <?php endif;
                    ?>
                    <div class="d-flex justify-content-center">
                        <img id="loader" src="<?php echo get_stylesheet_directory_uri() ?>/images/loader.gif" alt="loader" width="250px" style="display: none">
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
get_footer();
