<div class="center">
    <h1>
        <i class="icon-leaf green"></i>
        <span class="red">Office Management</span>
    </h1>
</div>

<div class="space-6"></div>
<div class="position-relative">
    <div id="forgot-box" class="forgot-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main" id="forgotPasswordContainer">
                    <h4 class="header red lighter bigger">
                        <i class="icon-key"></i>
                        Reset Password
                    </h4>
                    <div class="space-6"></div>
                    <?php echo $this->Session->flash();?>
                    <?php echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "reset_password", $resetKey), "id" => "resetPassword")); ?>
                        <fieldset>
                            <label class="block clearfix">
                    			<span class="block input-icon input-icon-right">
                    				<?php echo $this->Form->input("new", array("class" => "form-control","required" => "required", "placeholder" => "New Password", "type" => "password","label"=>"New Password"));?>
                    				<i class="icon-lock"></i>
                    			</span>
                            </label>
                            <label class="block clearfix">
                    			<span class="block input-icon input-icon-right">
                    				<?php echo $this->Form->input("confirm", array("class" => "form-control","required" => "required", "placeholder" => "Confirm Password", "type" => "password","label"=>"Confirm Password"));?>
                    				<i class="icon-lock"></i>
                    			</span>
                            </label>

                            <div class="clearfix">
                                <?php echo $this->Form->button("<i class='icon-lightbulb'></i> Send Me!", array("class"=>"width-35 pull-right btn btn-sm btn-danger","escape"=>false, "type"=>"submit")); ?>
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end();?>
                </div>
                <!-- /widget-main -->

                <div class="toolbar center">
                    <?php echo $this->Html->link('Back to login <i class="icon-arrow-right"></i>', array('controller'=>'users','action'=>'login'), array('class' => 'back-to-login-link', 'escape' => false))?>
                </div>
            </div>
            <!-- /widget-body -->
    </div>
</div><!-- /position-relative -->