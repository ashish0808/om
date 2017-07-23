<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
				
				  <?php if(isset($records) && count($records) > 1){ ?>
					<tr role="row">
						<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
                <label>
                    <input type="checkbox" class="ace" name="selectAll" id='checkallBoxes'>
                    <span class="lbl"></span>
                </label>
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                <?php echo $this->Paginator->sort('User.first_name', 'Name', array());?>
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                <?php echo $this->Paginator->sort('User.email', 'Email', array());?>
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                <!--<i class="icon-time bigger-110 hidden-phone"></i>-->
                <?php echo $this->Paginator->sort('User.modified', 'Modified', array());?>
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
                <?php echo $this->Paginator->sort('User.status', 'Status', array());?>
            </th>
            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label="">Action</th>
					</tr>
					<?php } else { ?>
					<tr role="row">
						<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
						  &nbsp;
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                Name
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                Email
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
                Modified
            </th>
            <th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
                Status
            </th>
            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label="">Action</th>
					</tr>
					<?php } ?>					
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i=($this->params['paging']['User']['page']-1)*LIMIT+1;
        if(isset($records) && !empty($records)){
            foreach ($records as $record){ ?>
            <tr class="<?php echo ($i%2==1)?'odd':'even';?>"">
                <td class="center  sorting_1">
                    <label>
                        <input type="checkbox" class="ace rowsCheckbox">
                        <input type="checkbox" class="ace rowsCheckbox" name="box[]" value="<?php echo $record['User']['id']; ?>" >
                        <span class="lbl"></span>
                    </label>
                </td>

                <td class=" ">
                    <?php echo $record['User']['first_name'].' '.$record['User']['last_name'];?>
                </td>
                <td class=" "><?php echo $record['User']['email']; ?></td>
                <td class="hidden-480 ">
                    <?php echo date(Configure::read('VIEW_DATE_FORMAT'),strtotime($record['User']['modified']));?>
                </td>
                <td class="hidden-480 ">
                    <?php $statusClass = ($record['User']['status']==1)?'label-success':'label-warning'; ?>
                    <span class="label <?php echo $statusClass; ?>">
                        <?php $userStatuses = Configure::read('USER_STATUS');
                            echo $userStatuses[$record['User']['status']];
                        ?>
                    </span>
                </td>
                <td class=" ">
                    <div class="hidden-phone visible-desktop action-buttons">

						<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'admins','action'=>'editLawyer',$record['User']['id']), array('escape' => false, 'class' => 'green'))?>
						
						<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'admins','action'=>'deleteLawyer',$record['User']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this lawyer?")?>
						
                    </div>

                    <div class="hidden-desktop visible-phone">
                        <div class="inline position-relative">
                            <button data-toggle="dropdown" class="btn btn-minier btn-yellow dropdown-toggle">
                                <i class="icon-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                <li>
                                    <a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
                                        <span class="green">
                                            <i class="icon-edit bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
                                        <span class="red">
                                            <i class="icon-trash bigger-120"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
                $i++;
            } ?>
            <tFoot>
                <tr role="row">
                    <th role="columnheader" style="border-right: none !important;">
                        <?php
                        $updateStatusOptions = array('Update Status','Activate','Deactivate','Delete');
                        echo $this->Form->input('User.status',array('id'=>'paging_limit','type' =>'select', 'options'=>$updateStatusOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,'id'=>'status',"onchange"=>"updateRecords(this.value,'userListForm');")); ?>
                    </th>
                    <th role="columnheader" colspan="8" style="border-left: none !important;">
                        <?php if($this->params['paging']['User']['count']>LIMIT){?>
                            <?php echo $this->Element('pagination');?>
                        <?php } ?>
                    </th>
                </tr>
            </tFoot>
        <?php }else{
            ?>
                <tr>
                    <td class="center" colspan="7">
                        <label>
                            <span class="notify_message"><?php echo NO_RECORD;?></span>
                        </label>
                    </td>
                </tr>
            <?php
        }?>
				</tbody>
			</table>
			</div>
        </div>
    </div>
</div>