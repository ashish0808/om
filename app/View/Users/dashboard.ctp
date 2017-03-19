<div class="page-header position-relative">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
</div>

<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
        <!-- #section:pages/dashboard.infobox.dark -->
		<div class="center">
			<span class="btn btn-app btn-sm btn-yellow no-hover">
				<span class="line-height-1 bigger-170 blue" id="pending_for_filing_count_div"> 0 </span>
				<br>
				<span class="line-height-1 smaller-90"> Filing </span>
			</span>

			<span class="btn btn-app btn-sm btn-danger no-hover">
				<span class="line-height-1 bigger-170" id="pending_for_refiling_count_div"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> ReFiling </span>
			</span>

			<span class="btn btn-app btn-sm btn-grey no-hover">
				<span class="line-height-1 bigger-170" id="pending_for_registration_count_div"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> To Register </span>
			</span>

			<span class="btn btn-app btn-sm btn-pink no-hover">
				<span class="line-height-1 bigger-170" id="cases_with_pending_actions_count_div"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> To Action </span>
			</span>

			<span class="btn btn-app btn-sm btn-success no-hover">
				<span class="line-height-1 bigger-170"> 7 </span>

				<br>
				<span class="line-height-1 smaller-90"> Albums </span>
			</span>

			<span class="btn btn-app btn-sm btn-primary no-hover">
				<span class="line-height-1 bigger-170"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> Filing </span>
			</span>
		</div>
		<div class="hr hr32 hr-dotted"></div>

		<div class="row-fluid">
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="icon-book red"></i>
							Cases Pending for Filing
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="pending_for_filing_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Party Name
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Limitation Expiry
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="4" class="center"><i class="icon-spinner icon-spin orange bigger-170"></i></td>
									</tr>
								</tbody>
							</table>
						</div><!-- /.widget-main -->
					</div><!-- /.widget-body -->
				</div><!-- /.widget-box -->
			</div><!-- /.col -->
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="icon-bell red"></i>
							Cases Pending for Re-Filing
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="pending_for_refiling_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Party Name
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Limitation Expiry
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="4" class="center"><i class="icon-spinner icon-spin orange bigger-170"></i></td>
									</tr>
								</tbody>
							</table>
						</div><!-- /.widget-main -->
					</div><!-- /.widget-body -->
				</div><!-- /.widget-box -->
			</div><!-- /.col -->
        </div>

        <div class="hr hr32 hr-dotted"></div>

        <div class="row-fluid">
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="icon-bullhorn red"></i>
							Cases Pending for Registration
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="pending_for_registration_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Party Name
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Limitation Expiry
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="4" class="center"><i class="icon-spinner icon-spin orange bigger-170"></i></td>
									</tr>
								</tbody>
							</table>
						</div><!-- /.widget-main -->
					</div><!-- /.widget-body -->
				</div><!-- /.widget-box -->
			</div><!-- /.col -->
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="icon-star red"></i>
							Cases with Pending Actions
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="cases_with_pending_actions_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Party Name
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Pending Actions
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="4" class="center"><i class="icon-spinner icon-spin blue bigger-170"></i></td>
									</tr>
								</tbody>
							</table>
						</div><!-- /.widget-main -->
					</div><!-- /.widget-body -->
				</div><!-- /.widget-box -->
			</div><!-- /.col -->
        </div>
    </div>
</div>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php
echo $this->Form->end();
echo $this->Html->script('pages/dashboard');
?>
