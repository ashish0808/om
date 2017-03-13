<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<div class="col-sm-12 widget-container-col ui-sortable">
			<div class="widget-box transparent ui-sortable-handle">
				<?php echo $this->element('Cases/top_menus');?>

				<div class="widget-body edit-case-cnt">
					<div class="widget-main padding-12">
						<div class="tab-content padding-4">
							<div class="tab-pane active">
								<?php echo $this->Form->create('CaseFile', array('type' => 'file', 'url' => '/CaseFiles/add/'.$caseId, 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add', 'novalidate' => true)); ?>

									<div class="">
										<div class="col-sm-12">
											<div class="clearfix buttons-with-spaces">
												<?php //echo $this->Form->input('files.', array('type' => 'file', 'multiple')); ?>

												<div class='file_upload' id='f1'><input name='data[CaseFile][files][]' type='file'/><br /></div>
												<div id='file_tools'>
													<a href="javascript:void(0)" id='add_file' class='btn btn-info'>(+) Add More</a>
													<a href="javascript:void(0)" id='del_file' class='btn btn-info'>(-) Delete</a>
												</div>

											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="clearfix pull-right custom-form-actions">
												<?php echo $this->Html->link('<i class="icon-arrow-left bigger-110"></i> Back To List ', array('controller'=>'CaseFiles','action'=>'manage', $caseId), array('escape' => false, 'class' => 'btn btn-next'))?>
												<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save", array("class" => "btn btn-info", "escape" => false, "type" => "submit"));?>
											</div>
										</div>
									</div>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<script type='text/javascript'>
$(document).ready(function(){
	var counter = 2;
	$('#del_file').hide();
	$('#add_file').click(function(){
		$('#file_tools').before('<div class="file_upload" id="f'+counter+'"><input name="data[CaseFile][files][]" type="file"><br /></div>');
		$('#del_file').fadeIn(0);
	counter++;
	});
	$('#del_file').click(function(){
		if(counter==3){
			$('#del_file').hide();
		}
		counter--;
		$('#f'+counter).remove();
	});
});
</script>