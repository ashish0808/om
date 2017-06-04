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
                        Retrieve Password
                    </h4>

                    <div class="space-6"></div>
                    <p>
                        Enter your email to reset password
                    </p>
                    <?php echo $this->Session->flash();?>
                    <?php echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "login"), "id" => "forgotPassword")); ?>
                        <fieldset>
                            <label class="block clearfix">
                    			<span class="block input-icon input-icon-right">
                    				<?php
                    				echo $this->Form->hidden("action", array("value" => "forgot"));
                    				echo $this->Form->input("forgot_email", array("class" => "form-control","required" => "required","placeholder" => "Email","label"=>"Email","value"=>""));?>
                    				<i class="icon-envelope"></i>
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