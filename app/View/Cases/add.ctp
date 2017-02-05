<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('Case', array('url' => '/cases/add/'.$caseId, 'class' => 'form-horizontal dropzone', 'name' => 'add', 'id' => 'add')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Case Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
              <div class="col-sm-6">
                <div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Case Title: </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('Case.id', array('label' => false, 'div' => false, 'error' => false)); ?>
											<?php echo $this->Form->input('Case.file_num', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-sm-12 col-xs-12', 'placeholder' => 'Title', "required" => "required")); ?>
										</div>
									</div>
								</div>
              </div>
            </div>
					</div>
				</div>
			</div>
		</div>
		
    <div class="col-sm-12 col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-info", "escape" => false, "type" => "submit"));?>
                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset">
                    <i class="icon-undo bigger-110"></i>
                    Reset
                </button>
            </div>
        </div>

        <div class="hr hr-18 dotted hr-double"></div>
    </div>

        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->