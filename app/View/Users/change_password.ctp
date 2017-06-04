<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Change Password</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
                        	<div class="col-sm-12">
                        		<div class="form-group">
                        			<div class="col-sm-6 col-xs-12">
                        				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Current Password: </label>
                        				<div class="col-sm-8">
                        					<?php
                        					echo $this->Form->input('id');
                        					echo $this->Form->input('current_password', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off', 'type' => 'password', 'value' => ''));
                        					?>
                        				</div>
                        			</div>
                        		</div>
                        	</div>
                        </div>
						<div class="row">
                        	<div class="col-sm-12">
                        		<div class="form-group">
                        			<div class="col-sm-6 col-xs-12">
                        				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> New Password: </label>
                        				<div class="col-sm-8">
                        					<?php echo $this->Form->input('new', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off', 'type' => 'password')); ?>
                        				</div>
                        			</div>
                        		</div>
                        	</div>
                        </div>
						<div class="row">
                        	<div class="col-sm-12">
                        		<div class="form-group">
                        			<div class="col-sm-6 col-xs-12">
                        				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Confirm Password: </label>
                        				<div class="col-sm-8">
                        					<?php echo $this->Form->input('confirm', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off', 'type' => 'password')); ?>
                        				</div>
                        			</div>
                        		</div>
                        	</div>
                        </div>

                        <div class="row">
                        	<div class="col-sm-12">
                        		<div class="clearfix pull-right">
                        			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "value" => "submit")); ?>
                        		</div>
                        	</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->