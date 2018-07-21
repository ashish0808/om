<?php
//echo $this->Html->script('jquery'); // Include jQuery library
echo $this->Html->script('listing'); ?>
<?php $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
)); ?>
<div class="page-header position-relative">
    <h1>
        Lawyer Management
        <small>
            <i class="icon-double-angle-right"></i>
            List
        </small>
    </h1>
</div><!-- /.page-header -->

<?php 
$data = $this->Js->get('#userListForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#userListForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'manageLawyers'),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'method' => 'POST'
        )
    )
);
$this->Js->get('#userListForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'manageLawyers'),
        array(
            'update' => '#content',
            'async' => true,
            'dataExpression'=>true,
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('User',array('url' => '/admins/manageLawyers','id'=>'userListForm','name'=>'userListForm')); ?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <?php echo $this->Form->input('User.first_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'First Name')); ?>
                        <?php echo $this->Form->input('User.last_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Last Name')); ?>
                        <?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Email', 'required' => false)); ?>
                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-sm","escape"=>false,
                                "type"=>"submit", "div" => false));
                                ?>
                        <?php
                        echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Reset",
                            array("class"=>"btn btn-sm","escape"=>false,
                                "type"=>"reset", "div" => false));
                        
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


<?php echo $this->element('Admins/manage_lawyers');?>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php echo $this->Form->end(); ?>