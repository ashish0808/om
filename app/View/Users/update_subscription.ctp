<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>

		<div class="col-sm-12 col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="">
				
				<?php if (isset($plansData) && !empty($plansData)) {
					foreach ($plansData as $planData) { ?>
				<div class="col-xs-6 col-sm-4 pricing-box">
					<div class="widget-box widget-color-orange">
						<div class="widget-header">
							<h5 class="widget-title bigger lighter"><?php echo $planData['Plan']['name']; ?></h5>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								<ul class="list-unstyled spaced2">
									<li>
										<i class="ace-icon fa fa-check green"></i>
										<?php echo $planData['Plan']['description']; ?>
									</li>
								</ul>

								<hr>
								<div class="price">
									Rs. <?php echo $planData['Plan']['price']; ?>
									<small> for <?php echo $planData['Plan']['no_of_days']; ?> days</small>
								</div>
							</div>

							<div>
								<?php echo $this->Html->link('<i class="ace-icon fa fa-shopping-cart bigger-110""></i> <span>Buy</span>', array('controller'=>'Users','action'=>'update_subscription_action', $planData['Plan']['id']), array('escape' => false, 'class' => 'btn btn-block btn-primary'))?>
							</div>
						</div>
					</div>
				</div>
				<?php } } ?>
			</div>
		</div>
	</div>
</div><!-- /.page-content -->