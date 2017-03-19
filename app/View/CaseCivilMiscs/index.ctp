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
$data = $this->Js->get('#caseCivilMiscSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#caseCivilMiscSearchForm')->event(
    'submit',
    $this->Js->request(
        array(
        	'action' => 'index/'.$status,
        ),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
$this->Js->get('#caseCivilMiscSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'index/'.$status),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('CaseCivilMiscs',array('url' => '/CaseCivilMiscs/index/'.$status,'id'=>'caseCivilMiscSearchForm','name'=>'caseCivilMiscSearchForm'));?>
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
                        $applicationTypes = array('cm' => 'CM', 'crm' => 'CRM');
						echo $this->Form->input('CaseCivilMisc.cm_type', array('options' => $applicationTypes, 'empty' => 'Application Type','label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Application Type','required' => false, 'autocomplete' => 'off'));
                        
                        ?>
                        <?php
                        echo $this->Form->input('CaseCivilMisc.cm_no', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Application No', 'autocomplete' => 'off'));
                        ?>
                        <?php
                        echo $this->Form->input('CaseCivilMisc.application_date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'input-medium search-query date-picker', 'placeholder' => 'Application Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
                        ?>
                        <?php
                        echo $this->Form->input('CaseCivilMisc.computer_file_no', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Computer File No', 'autocomplete' => 'off'));
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
<?php echo $this->element('CaseCivilMiscs/case_civil_misc');
?>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php echo $this->Form->end(); ?>