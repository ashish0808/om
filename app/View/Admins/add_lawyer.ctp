<div class="page-content">
	<div class="page-header">
		<h1>
			Lawyer Management
			<small>
				<i class="icon-double-angle-right"></i>
				<?php echo $pageTitle; ?>
			</small>
		</h1>
	</div><!-- /.page-header -->

<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<?php echo $this->Form->create('User', array('url' => '/admins/addLawyer', 'class' => 'form-horizontal','name'=>'addLawyer', 'id'=>'addLawyer')); ?>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Name </label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.first_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'placeholder' => 'First Name', "required" => "required")); ?>
			<?php echo $this->Form->input('User.last_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'placeholder' => 'Last Name', "required" => "required")); ?>
		</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Email', "required" => "required")); ?>
			<div class="clear"></div>
			<?php echo $this->Form->error('User.email'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-password">Password</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.user_pwd', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'type' => 'password', 'placeholder' => 'Password', "required" => "required")); ?>
			<div class="clear"></div>
			<?php echo $this->Form->error('User.user_pwd'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-confirm-password">Confirm Password</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.confirm_password', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'type' => 'password', 'placeholder' => 'Confirm Password', "required" => "required")); ?>
			<div class="clear"></div>
			<?php echo $this->Form->error('User.confirm_password'); ?>
		</div>
	</div>
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class"=>"btn btn-info","escape"=>false, "type"=>"submit"));?>
			&nbsp; &nbsp; &nbsp;
			<button class="btn" type="reset">
				<i class="icon-undo bigger-110"></i>
				Reset
			</button>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
	<div class="hr hr-18 dotted hr-double"></div>
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content -->