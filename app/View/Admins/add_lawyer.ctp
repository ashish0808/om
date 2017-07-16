<div class="page-content">
	<div class="page-header">
		<h1>
			Lawyer Management
			<small>
				<i class="icon-double-angle-right"></i>
				<?php echo $pageTitle; ?>
			</small>
		</h1>
	</div><!-- /.page-header -->

<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<?php echo $this->Form->create('User', array('url' => '/admins/addLawyer', 'class' => 'form-horizontal','name'=>'addLawyer', 'id'=>'addLawyer')); ?>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Name </label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.first_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'placeholder' => 'First Name', "required" => "required")); ?>
			<?php echo $this->Form->input('User.last_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'placeholder' => 'Last Name', "required" => "required")); ?>
		</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> DOB </label>
		<div class="col-sm-4">
			<div class="input-group">
				<?php echo $this->Form->input('Profile.dob', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'DOB', 'id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy', "class" => "form-control datepicker", "required" => "required")); ?>
				<span class="input-group-addon">
					<i class="icon-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-input-mobile"> Mobile </label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('Profile.mobile', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Mobile')); ?>
		</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Email', "required" => "required")); ?>
			<div class="clear"></div>
			<?php echo $this->Form->error('User.email'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-password">Password</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.user_pwd', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'type' => 'password', 'placeholder' => 'Password', "required" => "required")); ?>
			<div class="clear"></div>
			<?php echo $this->Form->error('User.user_pwd'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-confirm-password">Confirm Password</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('User.confirm_password', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'type' => 'password', 'placeholder' => 'Confirm Password', "required" => "required")); ?>
			<div class="clear"></div>
			<?php echo $this->Form->error('User.confirm_password'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-address1">Address 1</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('Profile.street_address_1', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Address 1')); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-address2">Address 2</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('Profile.street_address_2', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Address 2')); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-country">Country</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('Profile.country', array('options' => array('1'=>'India'), 'empty' => '--Select Country--', 'label' => false, 'div' => false, 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Country', 'class' => 'col-xs-10 col-sm-5')); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-state">State</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('Profile.state', array('options' => array('1'=>'Punjab'), 'empty' => '--Select State--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a State')); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-city">City</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('Profile.city', array('options' => array('1'=>'Chandigarh'), 'empty' => '--Select City--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a City')); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Zip</label>
		<div class="col-sm-9">
		<?php echo $this->Form->input('Profile.zip', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Zip')); ?>
		</div>
	</div>

	<div class="hr hr-24"></div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Select Plan</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('UserTransaction.plan_id', array('options' => $listPlans, 'empty' => '--Select Plan--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Plan', "required" => "required")); ?>
            &nbsp;<span id="planAmount"></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Any Discount</label>
		<div class="col-sm-9 displayValueField radioGroupCnt">
			<?php $options = array('y' => 'Yes', 'n' => 'No');
			echo $this->Form->radio('UserTransaction.any_discount', $options, array('legend' => false,'default' => 'n','class' => 'anyDiscount', "required" => "required", "autocomplete" => "off")); ?>
		</div>
	</div>
	
	<div class="form-group" id="addDiscount" style="display: none;">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Select Coupon</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('UserTransaction.coupon_id', array('options' => $listCoupons, 'empty' => '--Select Coupon--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Plan', "required" => "required")); ?>
			&nbsp;<span id="couponAmount"></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Total Amount</label>
		<div class="col-sm-9 displayValueField" id="totalAmount">
			$0.00
		</div>
	</div>
	
	<div class="form-group" id="addDiscount">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Mode of Payment</label>
		<div class="col-sm-9">
			<?php //echo $this->Form->input('UserTransaction.coupon_id', array('options' => $listCoupons, 'empty' => '--Select Coupon--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Plan', "required" => "required")); ?>
			<?php echo $this->Form->input('UserTransaction.mode_of_payment', array('options' => Configure::read('PAYMENT_TYPES'), 'empty' => '--Payment Type--', 'label' => false, 'div' => false, 'class' => '', 'autocomplete' => 'off', 'data-placeholder' => 'Choose Discount Type')); ?>
            <?php echo $this->Form->input('UserTransaction.transaction_id', array('label' => false, 'div' => false, 'class' => '', 'type' => 'text', 'placeholder' => 'Transaction ID')); ?>
		</div>
	</div>
	
	<div class="form-group" id="addDiscount">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Mode of Payment</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('UserTransaction.notes', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5')); ?>
		</div>
	</div>
	
	<!--<div class="row">
		<div class="col-sm-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4>jQuery UI Sliders</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-xs-3 col-md-2">
								<div id="slider-range"></div>
							</div>

							<div class="col-xs-9 col-md-10">
								<div id="eq">
									<span class="ui-slider-green">77</span>
									<span class="ui-slider-red">55</span>
									<span class="ui-slider-purple">33</span>
									<span class="ui-slider-orange">40</span>
									<span class="ui-slider-dark">88</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class"=>"btn btn-info","escape"=>false, "type"=>"submit"));?>
			&nbsp; &nbsp; &nbsp;
			<button class="btn" type="reset">
				<i class="icon-undo bigger-110"></i>
				Reset
			</button>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
	<div class="hr hr-18 dotted hr-double"></div>
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">
    $(document).ready(function(){
		showHideDiscount();
		updateTotalPayment();
        $('#UserTransactionCouponId').on('change', function(){
            updateTotalPayment();
        })

        $('#UserTransactionPlanId').on('change', function(){
            updateTotalPayment();
        })

        $('.anyDiscount').on('click', function(){
            showHideDiscount();
			updateTotalPayment();
        })
    });

	function showHideDiscount(){
		var anyDiscount = $(".anyDiscount:checked").val();
		if(anyDiscount=='y'){
			$('#addDiscount').show();
		}else{
			$('#UserTransactionCouponId').val('')
			$('#addDiscount').hide();
		}
	}
	
    function updateTotalPayment(){
        var planDetail = $('#UserTransactionPlanId').val();
        var planValue = planDetail.split("_").pop();
		var showPlanValue = '';
		
		var couponDetail = $('#UserTransactionCouponId').val();
		var couponValue = couponDetail.split("_");
		var showCouponValue = '';
		
        var showNetAmount = '0.00';
        if(planValue!=''){
			showPlanValue = '$'+planValue;
            showNetAmount = planValue;
            var discountType = '';
            var discountValue = '';
			if($(".anyDiscount:checked").val()=='y' && couponValue[1]!='' && couponValue[2]!=''){
				discountType = couponValue[2];
				discountValue = couponValue[1];
				
				if(discountType==2){
					showCouponValue = discountValue+'%';
				}else if(discountType==1){
					showCouponValue = '$'+discountValue;
				}
			}
			
            if(discountType!='' && discountValue!=''){
               if(discountType==1){
                   showNetAmount = (parseFloat(planValue)-parseFloat(discountValue)).toFixed(1);
               }else if(discountType==2){
                   netDiscount = (parseFloat(discountValue)/parseInt(100)*parseFloat(planValue));
                   showNetAmount = parseFloat(planValue)-parseFloat(netDiscount).toFixed(1);
               }
            }
        }
		$('#planAmount').html(showPlanValue);
		$('#couponAmount').html(showCouponValue);
        $('#totalAmount').html('$'+showNetAmount);
    }
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.datepicker').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: false,
			orientation: "bottom right",
			autoclose: true,
			startDate: '-100y',
			endDate: '-18y',
			todayHighlight: true
		});
	});
</script>