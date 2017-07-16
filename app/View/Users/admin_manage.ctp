<?php 
$this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
)); 
?>
<div class="page-header position-relative">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
</div>

<?php
$data = $this->Js->get('#UserSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#UserSearchForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'manage', 'admin' => true),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
$this->Js->get('#UserSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'manage', 'admin' => true),
        array(
            'update' => '#content',
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('User',array('url' => '/admin/Users/manage','id'=>'UserSearchForm','name'=>'UserSearchForm'));?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                    
                      <div class="row">
          							<div class="col-sm-3 col-xs-12">
          								<div class="form-group">
          									<div class="col-sm-12 col-xs-12">
          										<label class="col-xs-12 control-label no-padding-right">First Name: </label>
          										<?php echo $this->Form->input('User.first_name', array('label' => false, 'required' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
          									</div>
          								</div>
          							</div>
          							<div class="col-sm-3 col-xs-12">
          								<div class="form-group">
          									<div class="col-sm-12 col-xs-12">
          										<label class="col-xs-12 control-label no-padding-right">Last Name: </label>
          										<?php echo $this->Form->input('User.last_name', array('label' => false, 'required' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
          									</div>
          								</div>
          							</div>
          							<div class="col-sm-3 col-xs-12">
          								<div class="form-group">
          									<div class="col-sm-12 col-xs-12">
          										<label class="col-xs-12 control-label no-padding-right">Email: </label>
          										<?php echo $this->Form->input('User.email', array('label' => false, 'required' => false, 'div' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
          									</div>
          								</div>
          							</div>
          							<div class="col-sm-3 col-xs-12">
          								<div class="form-group">
          									<div class="col-sm-12 col-xs-12">
          									 <label class="col-xs-12 control-label no-padding-right">&nbsp;</label>
          										<?php echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search", array("class"=>"btn btn-purple btn-sm caseSearchBtn","escape"=>false, "type"=>"submit", "div" => false)); ?>
            									<?php echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Reset", array("class"=>"btn btn-sm","escape"=>false, "type"=>"reset", "div" => false)); ?>
          									</div>
          								</div>
          							</div>
          						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
	<div class="span12">
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
    <?php echo $this->element('Users/admin_manage'); ?>
  </div>
</div>
<?php echo $this->Form->end(); ?>