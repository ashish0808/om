<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Title: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('Todo.title', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <span class="required">*</span>Completion Date: </label>
				<div class="col-sm-8">
					<?php 
					echo $this->Form->input('Todo.completion_date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Date of Todo', 'data-date-format' => 'yyyy-mm-dd', 'required' => 'required', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Compute File No: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('Todo.computer_file_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'value' => $computer_file_no, 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Priority: </label>
				<div class="col-sm-8">
					<?php
					$priorities = array('normal' => 'Normal', 'high' => 'High', 'urgent' => 'Urgent', 'low' => 'Low');
					echo $this->Form->input('Todo.priority', array('options' => $priorities, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Description: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->textarea('Todo.description', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Status: </label>
				<div class="col-sm-8">
					<?php
					$statuses = array('pending' => 'Pending', 'completed' => 'Completed');
					echo $this->Form->input('Todo.status', array('options' => $statuses, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
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
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[Todo][submit]", "value" => "submit"));
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Reset", array("class" => "btn btn-info", "escape" => false, "type" => "reset", "name" => "data[Todo][reset]", "value" => "reset"));
			?>
			<?php
			} else {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[Todo][submit]", "value" => "submit"));
			?>
			<?php echo $this->Html->link("Back", array('controller' => 'Todos', 'action' => 'index'), array('class' => 'btn btn-info'));
			?>
			<?php
			}
			?>
		</div>
	</div>
</div>