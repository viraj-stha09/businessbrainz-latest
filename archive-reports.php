<?php
get_header();
$page = get_page_by_path('reports');
$slug = get_post_field('post_name', $page->ID);
$form_submitted = isset($_GET['redirected']) ? $_GET['redirected'] : false;
if(get_query_var('reportDownloaded')){ ?>
    <div class="modal fade" id="reportDownloadedConfirmation" tabindex="-1" role="dialog" aria-labelledby="reportDownloadedConfirmation" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close reportDownloadedConfirmationClose" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Thank you for downloading the report. It will shortly arrive in your inbox.
        In the meantime feel free to browse through our reports library:
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary reportDownloadedConfirmationClose" >Close</button>
        </div>
    </div>
  </div>
</div>
    <script>
        (function ($) {
            $( document ).ready(function() {
                $('#reportDownloadedConfirmation').modal({
                    backdrop: 'static',
                    keyboard: false
                },'show');

                $('.reportDownloadedConfirmationClose').on('click',function (e){
                    e.preventDefault();
                    window.location.replace("https://businessbrainz.com/reports");
                })
            });
        })(jQuery)
    </script>
<?php } ?>
    <div class="report-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="content-wrapper justify-content-center align-self-center">
                        <div>
                            <h2 class="heading"><?php the_field('heading', $page->ID); ?></h2>
                            <h3 class="subheading mt-2"><?php the_field('sub_heading', $page->ID); ?></h3>
                            <div class="description mt-3"><?php the_field('description', $page->ID); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    $alt            = get_post_meta(get_post_thumbnail_id($page->ID), '_wp_attachment_image_alt', true);
                    $image_srcset   = wp_get_attachment_image_srcset(get_post_thumbnail_id($page->ID));
                    $featured_image = get_the_post_thumbnail_url($page->ID); ?>
                    <img class="report-feature-image" src="<?php echo $featured_image ?>" alt="<?php echo $alt ?>"
                         srcset="<?php echo $image_srcset ?>">
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
                        <li itemprop="itemListElement" itemtype="http://schema.org/ListItem" class="pl-3">Report</li>
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
                                    <?php render_category_list() ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="report-list" class="col-lg-9">
                    <?php
                    $the_query = new WP_Query(businessbrainz_get_wp_query_args());
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
if($form_submitted){ ?>
    <script>
        (function ($) {
            $('#form-submitted').modal('show');
            let uri = window.location.toString();
            if (uri.indexOf("?") > 0) {
                let clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
        })(jQuery)
    </script>
<?php }
