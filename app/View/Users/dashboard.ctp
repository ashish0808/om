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
				<span class="line-height-1 smaller-90"> Objections </span>
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
				<span class="line-height-1 bigger-170" id="cases_with_no_next_date_count_div"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> No Date </span>
			</span>

			<span class="btn btn-app btn-sm btn-primary no-hover">
				<span class="line-height-1 bigger-170" id="todos_count_div"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> Todos </span>
			</span>

			<span class="btn btn-app btn-sm btn-default no-hover">
				<span class="line-height-1 bigger-170" id="decided_cases_count_div"> 0 </span>

				<br>
				<span class="line-height-1 smaller-90"> Decided </span>
			</span>
		</div>
		<div class="hr hr32 hr-dotted"></div>

		<div class="row-fluid">
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="icon-book red"></i>
							Cases Pending for Filing (<?php echo $this->Html->link('View All', array('controller' => 'cases', 'action' => 'manage', 'pending_for_filing')); ?>)
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
											<i class="icon-caret-right blue"></i>Case Title
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
							<i class="icon-time red"></i>
							Cases Pending for Filing Objections (<?php echo $this->Html->link('View All', array('controller' => 'cases', 'action' => 'manage', 'pending_for_refiling')); ?>)
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
											<i class="icon-caret-right blue"></i>Case Title
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
							<i class="icon-file red"></i>
							Cases Pending for Registration (<?php echo $this->Html->link('View All', array('controller' => 'cases', 'action' => 'manage', 'pending_for_registration')); ?>)
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
											<i class="icon-caret-right blue"></i>Case Title
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
							<i class="icon-tasks red"></i>
							Cases with Pending Actions (<?php echo $this->Html->link('View All', array('controller' => 'users', 'action' => 'getCasesWithPendingActionsAll'));
					?>)
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
											<i class="icon-caret-right blue"></i>Case Title
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

        <div class="hr hr32 hr-dotted"></div>

        <div class="row-fluid">
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="icon-calendar red"></i>
							Cases with No Proceeding Date (<?php echo $this->Html->link('View All', array('controller' => 'users', 'action' => 'getCasesWithNoNextDateAll'));
					?>)
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="cases_with_no_next_date_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Case Title
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
							<i class="icon-check red"></i>
							Decided Cases Alert (<?php echo $this->Html->link('View All', array('controller' => 'users', 'action' => 'getDecidedCasesAll')); ?>)
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="decided_cases_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Case Title
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Alert
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
							<i class="icon-bell red"></i>
							Pending Todos (<?php echo $this->Html->link('View All', array('controller' => 'Todos', 'action' => 'index'));
					?>)
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<!--i class="ace-icon fa fa-chevron-up"></i-->
								<i class="icon-arrow-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding" id="todos_div">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="icon-caret-right blue"></i>Case No
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Title
										</th>

										<th class="hidden-480">
											<i class="icon-caret-right blue"></i>Due Date
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
    </div>
</div>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php
echo $this->Form->end();
echo $this->Html->script('pages/dashboard');
?>
