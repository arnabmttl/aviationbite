<!-- Flagging Modal -->
<div class="modal fade" :id="'flaggingModal'+id" tabindex="-1" :aria-labelledby="'flaggingModal'+ id + 'Label'" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="padding: 25px;text-align: left;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
            <div>
                <div>
                    <p class="title">Report a reply.</p>
                    <p class="desc">Write your reason for reporting (max. 255 characters)</p>
                </div>
                <div>
                    <div class="col-12 form-group">
                        <textarea class="form-control" v-model="reasonForReporting"></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <button class="form-control" v-on:click="report(id)">Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>