<div class="modal fade" id="cta-form-modal" tabindex="-1" role="dialog" aria-labelledby="cta-form-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Schedule an Appointment</h3>

                <div class="container">
                    <div class="tab cta-form-page-1">
                        <form id="cta-form-1" enctype='multipart/form-data'>
                            <div class="form-group">
                                <label>Do you have sometime to fill up some more information?</label>
                                <div class="text-center">
                                    <a href="javascript:void(0)" id="continue-form-yes" class="btn-one">Yes</a>
                                    <a href="https://calendly.com/businessbrainz" target="_blank"  class="btn-one">No</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab cta-form-page-2" style="display: none">
                        <form id="cta-form-2" enctype='multipart/form-data'>
                            <div class="form-group">
                                <label>What is the value of winning this account?</label>
                                <input type="range" class="form-range" min="0" max="10" step="1" id="winning_amount"
                                       name="winning_amount">
                                About USD <span id="rangeval">5<!-- Default value --></span> Million
                            </div>
                            <div class="text-center">
                                <button class="btn-one" type="submit">Next</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab cta-form-page-3" style="display: none">
                        <form id="cta-form-3" enctype='multipart/form-data'>
                            <div class="form-group">
                                <label>What do you need to win the account? *</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="ABM Account Insight"
                                           name="requirement_sector"
                                           id="abm_account_insight" checked>
                                    <label class="form-check-label" for="abm_account_insight">
                                        ABM Account Insight
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Industry Insight"
                                           name="requirement_sector"
                                           id="industry_insight">
                                    <label class="form-check-label" for="industry_insight">
                                        Industry Insight
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Competitive Intelligence"
                                           name="requirement_sector"
                                           id="competitive_intelligence">
                                    <label class="form-check-label" for="competitive_intelligence">
                                        Competitive Intelligence
                                    </label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn-one" type="submit">Next</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab cta-form-page-4" style="display: none">
                        <form id="cta-form-4" enctype='multipart/form-data'>
                            <div class="form-group">
                                <label>What is the reason you need out magic? *</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="The account is a cold call"
                                           name="reason_for_appointment"
                                           id="abm_account_insight">
                                    <label class="form-check-label" for="abm_account_insight">
                                        The account is a cold call
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="We need someone else to do the research we cant get ourselves"
                                           name="reason_for_appointment"
                                           id="industry_insight">
                                    <label class="form-check-label" for="industry_insight">
                                        We need someone else to do the research we cant get ourselves
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="We require information on the key decision makers"
                                           name="reason_for_appointment"
                                           id="competitive_intelligence">
                                    <label class="form-check-label" for="competitive_intelligence">
                                        We require information on the key decision makers
                                    </label>
                                </div>
                            </div>
                            <div class="error text-danger text-center"></div>
                            <div class="text-center">
                                <button class="btn-one" type="submit">Next</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab cta-form-page-5" style="display: none">
                        <form id="cta-form-5" enctype='multipart/form-data'>
                            <div class="form-group">
                                <label>Your Email *</label>
                                <input class="form-control normal-border" type="email" name="email"
                                       maxlength="255"/>
                            </div>
                            <div class="form-group">
                                <label>Company Name *</label>
                                <input class="form-control normal-border" type="text" name="company_name"
                                       maxlength="255"/>
                            </div>
                            <div class="form-group">
                                <label>Your Role *</label>
                                <input class="form-control normal-border" type="text" name="client_role"
                                       maxlength="255"/>
                            </div>
                            <div class="form-group">
                                <label>Website *</label>
                                <input class="form-control normal-border" type="url" name="website"
                                       maxlength="255"/>
                            </div>
                            <div class="text-center">
                                <button class="btn-one" type="submit">Continue to select meeting dates</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
