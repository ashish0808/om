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
$data = $this->Js->get('#DispatchSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#DispatchSearchForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'index'),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
$this->Js->get('#DispatchSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'index'),
        array(
            'update' => '#content',
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('Dispatch',array('url' => '/Dispatches/index','id'=>'DispatchSearchForm','name'=>'DispatchSearchForm'));?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <?php
                        echo $this->Form->input('Dispatch.date_of_dispatch', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'input-medium search-query date-picker', 'placeholder' => 'Application Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
                        ?>
                        <?php
                        echo $this->Form->input('Dispatch.computer_file_no', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Computer File No', 'autocomplete' => 'off'));
                        ?>
                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-sm","escape"=>false,
                                "type"=>"submit", "div" => false));
                        ?>
                        <?php
                        echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Reset",
                            array("class"=>"btn btn-sm","escape"=>false,
                                "type"=>"reset", "div" => false));
                        echo $this->Form->end();
						echo $this->Js->writeBuffer();
						?>
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
        <?php echo $this->element('Dispatches/case_dispatches'); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>