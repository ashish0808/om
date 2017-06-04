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
        <?php echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "login")));
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
                                <?php echo $this->Form->input("login_email", array("class" => "form-control","required" => "required","placeholder" => "Email","label"=>"Email"));?>
                                <i class="icon-user"></i>
                            </span>
                    </label>

                    <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <?php echo $this->Form->input("user_pwd", array("class" => "form-control","required" => "required", "placeholder" => "Password", "type" => "password","label"=>"Password"));?>
                                <i class="icon-lock"></i>
                            </span>
                    </label>

                    <div class="space"></div>

                    <div class="clearfix">
                        <label class="inline">
                            <input type="checkbox" class="ace"/>
                            <!--<span class="lbl"> Remember Me</span>-->
                        </label>

                        <?php
                        /*echo $this->Js->submit('Login', array(
                            'before'=>$this->Js->get('#sending')->effect('fadeIn'),
                            'success'=>$this->Js->get('#sending')->effect('fadeOut'),
                            'update'=>'#success',
                            "class"=>"width-35 pull-right btn btn-sm btn-primary",
                            "escape"=>false,
                        ));*/
                        echo $this->Form->button("<i class='icon-key'></i>Login",
                            array("class"=>"width-35 pull-right btn btn-sm btn-primary","escape"=>false,
                                "type"=>"submit")); ?>
                    </div>
                    <!--<div id="sending" style="display: none; background-color: lightgreen;">Sending...</div>-->
                    <div class="space-4"></div>
                </fieldset>
            </div>
            <!-- /widget-main -->

            <div class="toolbar clearfix">
				<div>
					<?php echo $this->Html->link("<i class='icon-arrow-left'></i> I forgot my password", array('controller'=>'users','action'=>'forgot_password'), array('class' => 'forgot-password-link', "escape" => false)); ?>
				</div>
            </div>
        </div>
        <!-- /widget-body -->
        <?php echo $this->Form->end();?>
    </div>
    <!-- /login-box -->
</div><!-- /position-relative -->