    </div>
    <!-- /page content -->

    <div class="daterangepicker dropdown-menu ltr opensleft">
        <div class="calendars">
            <div class="calendar left">
                <div class="calendar-table"></div>
                <div class="daterangepicker_input">
                    <div class="calendar-time" style="display: none;">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="calendar right">
                <div class="calendar-table"></div>
                <div class="daterangepicker_input">
                    <div class="calendar-time" style="display: none;">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ranges">
            <ul>
                <li data-range-key="Today">Today</li>
                <li data-range-key="Yesterday">Yesterday</li>
                <li data-range-key="Last 7 Days">Last 7 Days</li>
                <li data-range-key="Last 30 Days">Last 30 Days</li>
                <li data-range-key="This Month">This Month</li>
                <li data-range-key="Last Month">Last Month</li>
                <li data-range-key="Custom Range">Custom Range</li>
            </ul>
            <div class="daterangepicker-inputs">
                <div class="daterangepicker_input"><span class="start-date-label">Start date:</span><input
                        class="form-control" type="text" name="daterangepicker_start" value=""><i
                        class="icon-calendar3"></i></div>
                <div class="daterangepicker_input"><span class="end-date-label">End date:</span><input
                        class="form-control" type="text" name="daterangepicker_end" value=""><i
                        class="icon-calendar3"></i></div>
            </div>
            <div class="range_inputs"><button class="applyBtn btn btn-sm bg-slate-600 btn-block" disabled="disabled"
                    type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-light btn-block"
                    type="button">Cancel</button></div>
        </div>
    </div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip"
        style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>

    <!-- Core JS files -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/blockui.min.js"></script>
    <!-- /core JS files -->


    <!-- Theme JS files -->
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/d3.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/d3_tooltip.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/switchery.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/bootstrap_multiselect.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- /theme JS files -->

    <!-- <script src="../../../../global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script src="../../../../global_assets/js/plugins/notifications/jgrowl.min.js"></script>

    <script src="assets/js/app.js"></script>
	<script src="../../../../global_assets/js/demo_pages/picker_date.js"></script> -->

    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/select2.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/datatables.min.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?php echo base_url();?>assets/js/dataTables.bootstrap4.min.js"></script> -->

    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/app.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/datatables_api.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/form_checkboxes_radios.js"></script> -->

    <!--  -->
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/dashboard.js"></script>

    <!-- jQuery Validate -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui-localize/datepicker-es.js"></script>

    <script src="/assets/js/tableexport/xlsx/dist/xlsx.core.min.js"></script>
    <script src="/assets/js/tableexport/blobjs/Blob.min.js"></script>
    <script src="/assets/js/tableexport/file-saverjs/FileSaver.min.js"></script>
    <script src="/assets/js/tableexport/js/tableexport.min.js"></script>

    <script src="/assets/js/contextmenu/jquery.contextMenu.min.js"></script>
    <script src="/assets/js/contextmenu/jquery.ui.position.min.js"></script>
    
    <script src="/assets/js/contextmenu.js"></script>
    <script>
        var urlPath = '<?=base_url();?>';
    </script>

    <!-- Js Customizado -->
    <script src="<?php echo base_url();?>assets/js/utils.js?v=1.0"></script>
    <script src="<?php echo base_url();?>assets/js/comun.js?v=1.0"></script>

    <?php if(isset($js)) : ?>
    <?php foreach($js as $script) : ?>
    <script src="<?php echo base_url();?>assets/js/<?php echo $script.(strrpos($script, '.js') ? '' : '.js')?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>
    </body>

    </html>

    <div class="cls-loading"></div>

    <!-- Modales Comunes -->

    <!-- Modal seleccionar tienda -->
    <div class="modal fade" id="modal-select-tienda" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
    </div>

    <!-- Modal atender devolucion -->
    <div class="modal fade" id="modal-atender-alquiler" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
    </div>

    <div id="modal-content">

    </div>

    <div id="m-sale-return"></div>
    <div id="m-show-calendar-reserves"></div>
    <div id="m-register-customer"></div>
    <div id="m-register-article"></div>
    <div id="m-register-purchase"></div>
    <div id="m-register-sale"></div>