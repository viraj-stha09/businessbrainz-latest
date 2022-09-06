<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Download Free Report</h3>
                <input type="hidden" id="post_id" value="<?php echo get_the_ID(); ?>">
                <div class="container">
                    <!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
                    <form action='https://forms.zohopublic.com/admin2730/form/ReportsDownloadform/formperma/iNHLBcw7mdDYJ0wYhjo85yFgAfWFB2H-abZTzDegbiA/htmlRecords/submit'
                          name='form' id='form' method='POST' accept-charset='UTF-8' enctype='multipart/form-data'>
                        <input type="hidden" name="zf_referrer_name" value="">
                        <!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
                        <input type="hidden" name="zf_redirect_url" value="">
                        <!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
                        <input type="hidden" name="zc_gad" value="">
                        <!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
                        <div class="form-group">
                            <label>Name: *</label>
                            <input class="form-control normal-border" type="text" name="SingleLine" value="" fieldType=1
                                   maxlength="255"/>
                        </div>
                        <div class="form-group">
                            <label>Email: *</label>
                            <input class="form-control normal-border" type="text" name="SingleLine1" value="" fieldType=1
                                   maxlength="255"/>
                        </div>
                        <div class="form-group">
                            <label>Company Name: *</label>
                            <input class="form-control normal-border" type="text" name="SingleLine2" value="" fieldType=1 maxlength="255" />
                        </div>
                        <div class="form-group">
                            <!--Decision Box-->
                            <input class=" normal-border" type="checkbox" id="DecisionBox" name="DecisionBox"/>
                            <label for="DecisionBox">Subsribe to our Reports
                            </label>
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">
                                We take privacy seriously. Business Brainz users the information you provide to us to
                                contact you about our relevant content such as Reports, Blogs, Case Studies, E-paper,
                                Videos &amp; podcast. You may unsubscribe from this at anytime. For more information
                                checkout.
                            </small>
                        </div>
                        <div class="text-center">
                            <button class="btn-one zoho-form-submit" type="submit">Download Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
