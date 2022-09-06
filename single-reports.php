<?php
/**
 * The template for displaying all single posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bottomline
 */
get_header();
$term = get_the_terms( get_the_ID(), 'report_category' );
 ?>
<section id="breadcrumb">
    <div class="container">
        <div class="row">
            <ol id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="pr-3" href="<?php echo get_bloginfo( 'url' ) ?>">Home</a> ></li>
                <li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="pl-3 pr-3" href="<?php echo get_bloginfo( 'url' ).'\reports' ?>">Report</a> ></li>
                <li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="pl-3 pr-3" href="<?php echo get_bloginfo( 'url' ).'\reports&#47;'. $term[0]->slug; ?>"><?php echo $term[0]->name; ?><a/> ></li>
                <li itemprop="itemListElement" itemtype="http://schema.org/ListItem" class="pl-3"><?php the_title(); ?></li>
            </ol>
        </div>
    </div>
</section>
<section id="intro">
    <div class="container mt-3">
        <div class="row d-flex">
            <div class="col-md-6 d-flex justify-content-end order-md-2">
                <?php the_post_thumbnail('medium'); ?>
            </div>
            <div class="col-md-6 d-flex order-md-1">
                <div class="intro-wrapper justify-content-center align-self-center">
                    <div class="heading"><?php show_sectors(get_the_ID()) ?></div>
                    <h1 class="subheading"><?php the_title() ?></h1>
                    <div class="description"><?php the_field('introduction') ?></div>
                    <?php
                    $link = get_field('call_to_action_button');
                    ?>
                    <button type="button" class="btn btn-one" data-toggle="modal" data-target="#exampleModal"
                    ><?php echo $link['title'] ?></button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (have_rows('report_description')): ?>
    <?php while (have_rows('report_description')): the_row(); ?>
        <?php if (get_row_layout() === '1_column_text'): ?>
            <section class="column-one">
                <div class="one-column">
                <div class="container">
                    <div class="row">
                        <div class="col-12 title"> <?php the_sub_field('heading'); ?></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12"> <?php the_sub_field('description'); ?></div>
                    </div>
                </div>
            </div>
            </section>
        <?php elseif (get_row_layout() === 'call_to_action'): ?>
            <section class="call-to-action">
                <div class="call-to-action-wrapper">
                <div class="container">
                    <div class="row d-flex py-5" >
                        <div class="col-md-6 d-flex justify-content-center justify-content-md-start ">
                            <div class="title"><?php the_sub_field('call_to_action_text'); ?></div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center justify-content-md-end mt-2">
                            <?php
                            $link = get_field('call_to_action_button');
                            ?>
                            <button type="button" class="btn btn-one" data-toggle="modal" data-target="#exampleModal"
                               ><?php echo $link['title'] ?></button>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        <?php elseif (get_row_layout() === '34_image_slider_and_text'): ?>
            <section class="34-column">
                <div class="34-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <?php if (have_rows('slider_images')): ?>

                                    <div class="report-image-slider owl-carousel owl-theme">
                                        <?php while (have_rows('slider_images')) : the_row(); ?>
                                            <?php $image = get_sub_field('slider_image'); ?>
                                            <div class="item">
                                                <img src="<?php echo $image['url'] ?>">
                                            </div>
                                        <?php endwhile; ?>
                                    </div>

                                <?php else : ?>
                                    There is no content to be displayed
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 ">
                                <?php if (have_rows('report_highlights')): ?>
                                    <div class="title">
                                        Report Highlights
                                    </div>
                                    <ul>
                                        <?php while (have_rows('report_highlights')) : the_row(); ?>
                                            <li><?php the_sub_field('highlight'); ?></li>
                                        <?php endwhile; ?>
                                    </ul>
                                <?php else : ?>
                                    There is no content to be displayed
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
<section class="similar-reports">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                $terms = get_the_terms(get_the_ID(), 'report_category');
                if (is_array($terms)) {
                    $term_ids = wp_list_pluck($terms, 'term_id');
                    $args     = array(
                        'post_type' => 'reports',
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'report_category',
                                'field'    => 'id',
                                'terms'    => $term_ids,
                            ),
                        ),
                    );
                    $loop     = new WP_Query($args);
                    if ($loop->have_posts()) { ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="title">Similar Reports</div>
                            </div>
                        </div>
                        <div class="row my-3">
                        <?php while ($loop->have_posts()):
                            $loop->the_post(); ?>

                            <div class="col-md-6 col-sm-12 fix-width card report-box mt-2">
                                <a href="<?php the_permalink(); ?>">
                                    <img class="card-img-top" src="<?php the_post_thumbnail_url(); ?>" alt="Card image cap">
                                    <div class="card-body single-report-content">
                                        <div class="title"><?php the_title(); ?></div>
                                        <div class="category"><?php echo businessBrainz_show_report_category(get_the_ID()); ?></div>
                                    </div>
                                </a>
                            </div>

                        <?php
                        endwhile;
                    }
                    wp_reset_postdata(); ?>
                    </div>
                    <?php
                } ?>

            </div>
        </div>
    </div>
</section>

<?php
include_once('popup-modal.php');
get_footer();
