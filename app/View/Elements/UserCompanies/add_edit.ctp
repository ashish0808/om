<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Title: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('UserCompany.name', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Description: </label>
				<div class="col-sm-8">
					<?php 
					echo $this->Form->textarea('UserCompany.description', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right">
			<?php
			if ($this->action == 'add') {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[UserCompany][submit]", "value" => "submit"));
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Reset", array("class" => "btn btn-info", "escape" => false, "type" => "reset", "name" => "data[UserCompany][reset]", "value" => "reset"));
			?>
			<?php
			} else {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[UserCompany][submit]", "value" => "submit"));
			?>
			<?php echo $this->Html->link("Back", array('controller' => 'UserCompanies', 'action' => 'index'), array('class' => 'btn btn-info'));
			?>
			<?php
			}
			?>
		</div>
	</div>
</div>