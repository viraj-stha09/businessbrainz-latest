(function ($) {
    var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
        bottomOffset = 1200;

    window.ctaForm = [];

    $('#continue-form-yes').on('click', function(){
        $('.cta-form-page-1').hide();
        $('.cta-form-page-2').show();
    })

    $(document).on('change', '#winning_amount', function() {
        $('#rangeval').html( $(this).val() );
    });

    $( "#cta-form-2" ).on('submit', function(e){
        e.preventDefault();
        window.ctaForm['winning_amount'] = $('input[name="winning_amount"]').val();
        $('.cta-form-page-2').hide();
        $('.cta-form-page-3').show();
    })

    $( "#cta-form-3" ).on('submit', function(e){
        e.preventDefault();
        window.ctaForm['requirement_sector'] = $('input[name="requirement_sector"]').val();
        $('.cta-form-page-3').hide();
        $('.cta-form-page-4').show();
    })

    $( "#cta-form-4" ).on('submit', function(e){
        e.preventDefault();
        let $reasons = [];
        $('input[name="reason_for_appointment"]:checked').each(function() {
            $reasons.push(this.value);
        });
        if($reasons.length === 0){
            $('.error').html("<p>A reason must be selected</p>");
        }else{
            window.ctaForm['reason_for_appointment'] = $reasons;
            $('.cta-form-page-4').hide();
            $('.cta-form-page-5').show();
        }

    })

    $( "#cta-form-5" ).on('submit', function(e){
        e.preventDefault();
        window.ctaForm['email'] = $('input[name="email"]').val() ;
        window.ctaForm['company_name'] = $('input[name="company_name"]').val();
        window.ctaForm['client_role'] = $('input[name="client_role"]').val();
        window.ctaForm['website'] = $('input[name="website"]').val();
        submitCtaForm();

    })

    $( "#cta-form-5" ).validate({
        rules: {
            email:{
                required: true,
                email: true
            },
            company_name: {
                required: true
            },
            client_role: {
                required: true
            },
            website: {
                required: true,
                url: true
            },
        }
    });

    function submitCtaForm(){
        $.ajax({
            url: businessbrainz_php_vars.ajaxUrl,
            data: {
                action: 'businessBrainz_submit_cta_form',
                client_role: window.ctaForm.client_role,
                company_name: window.ctaForm.company_name,
                email: window.ctaForm.email,
                requirement_sector: window.ctaForm.requirement_sector,
                website: window.ctaForm.website,
                winning_amount: window.ctaForm.winning_amount,
                reason_for_appointment: window.ctaForm.reason_for_appointment,
            },
            type: 'POST',
            success: function (response) {
                console.log(response);
                var win = window.open('https://calendly.com/businessbrainz/30min', '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
                window.location.replace("https://businessbrainz.com/reports/?redirected=true");
            }
        });
    }

    window.featuredBlogPageNo = 1;
    $(window).scroll(function () {
        if ($(document).scrollTop() > ($(document).height() - bottomOffset) && canBeLoaded === true) {
            canBeLoaded = false;
            window.featuredBlogPageNo++;
            $.ajax({
                url: businessbrainz_php_vars.ajaxUrl,
                data: {
                    action: 'businessBrainz_load_more_reports',
                    page: window.featuredBlogPageNo,
                    category: $('#custom_taxonomy').val()
                },
                type: 'POST',
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (response) {

                    response = JSON.parse(response);
                    if (response.success) {
                        $('#report-list .row').append(response.html);
                        $("#loader").hide();
                        if (!response.lastPage) {
                            canBeLoaded = true;
                        }else{
                            window.featuredBlogPageNo = 1;
                        }
                    }

                }
            });
        }
    });

    $('#search-research').on('submit',function(e){
        e.preventDefault();
        $search_query = $('#search-report').val();
        $.ajax({
            url: businessbrainz_php_vars.ajaxUrl,
            data: {
                action: 'businessBrainz_search_reports',
                search_query: $search_query
            },
            type: 'POST',
            success: function (response) {
                response = JSON.parse(response);
                if (response.success) {
                    canBeLoaded = false;
                    $('#blog-load-more').hide();
                    $('#report-list .row').html('');
                    $('#report-list .row').append(response.html);
                }
            }
        });
    });

    $('.report-image-slider').owlCarousel({
        nav:true,
        dots: true,
        items:1,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
    });

    $('.report-slider').owlCarousel({
        nav:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        dots: false,
        autoplay: true,
        autoplayTimeout:2000,
        loop:true,
        autoplayHoverPause:true,
        margin:10,
        items:4
    });

    $('.zoho-form-submit').on('click',function (e){
        e.preventDefault();

        let $name = $('input[name="SingleLine"]').val();
        let $email = $('input[name="SingleLine1"]').val();
        let $company = $('input[name="SingleLine2"]').val();
        let $post_id = $('#post_id').val();
        $.ajax({
            url: businessbrainz_php_vars.ajaxUrl,
            data: {
                action: 'businessBrainz_send_report_email',
                name: $name,
                email: $email,
                company: $company,
                post_id: $post_id,
            },
            type: 'POST',
            success: function (response) {
                $('#form').submit();
            }
        });

    });
})(jQuery);
