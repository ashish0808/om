<div class="center">
    <h1>
        <i class="icon-leaf green"></i>
        <span class="red">Office Management</span>
        <!--<span class="white">Application</span>-->
    </h1>
    <!--<h4 class="blue">&copy; Company Name</h4>-->
</div>

<div class="space-6"></div>
<div class="position-relative">
    <div id="login-box" class="login-box visible widget-box no-border">
        <?php echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "register")));
        echo $this->Form->hidden("action", array("value" => "login"));
        echo $this->Form->hidden("token", array("value" => $token));
        ?>
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="icon-coffee green"></i>
                    Please Enter Your Information
                </h4>

                <div class="space-6"></div>
                <div id="loginStatus">
                    <?php echo $this->Session->flash();?>
                </div>
                <fieldset>
                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
								<?php echo $this->Form->input('User.first_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'class' => 'form-control', 'placeholder' => 'First Name', "required" => "required")); ?>
                                <div class="clear"></div>
								<?php echo $this->Form->error('User.first_name'); ?>
                            </span>
                    </label>
                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
								<?php echo $this->Form->input('User.last_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'class' => 'form-control', 'placeholder' => 'Last Name', "required" => "required")); ?>
                                <div class="clear"></div>
								<?php echo $this->Form->error('User.last_name'); ?>
                            </span>
                    </label>					
                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
								<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'error' => false, 'class' => 'form-control', 'placeholder' => 'Email', "required" => "required")); ?>
                                <div class="clear"></div>
								<?php echo $this->Form->error('User.email'); ?>
                            </span>
                    </label>
                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
								<?php echo $this->Form->input('User.user_pwd', array('label' => false, 'div' => false, 'error' => false, 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Password', "required" => "required")); ?>
                                <div class="clear"></div>
								<?php echo $this->Form->error('User.user_pwd'); ?>
                            </span>
                    </label>
                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
								<?php echo $this->Form->input('User.confirm_password', array('label' => false, 'div' => false, 'error' => false, 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Confirm Password', "required" => "required")); ?>
                                <div class="clear"></div>
								<?php echo $this->Form->error('User.confirm_password'); ?>
                            </span>
                    </label>
                    <div class="space"></div>

                    <div class="clearfix">
                        <?php 
                        echo $this->Form->button("<i class='icon-key'></i>Register",
                            array("class"=>"width-35 pull-right btn btn-sm btn-primary","escape"=>false,
                                "type"=>"submit")); ?>
                    </div>
                    <div class="space-4"></div>
                </fieldset>
            </div>
            <!-- /widget-main -->

            <div class="toolbar clearfix">
				<div>
					<?php echo $this->Html->link('Go to login <i class="icon-arrow-right"></i>', array('controller'=>'users','action'=>'login'), array('class' => 'forgot-password-link', 'escape' => false))?>
				</div>
            </div>
        </div>
        <!-- /widget-body -->
        <?php echo $this->Form->end();?>
    </div>
    <!-- /login-box -->
</div><!-- /position-relative -->