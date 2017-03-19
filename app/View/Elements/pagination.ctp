<div class="dataTables_paginate paging_bootstrap" style="line-height: 10px;">
    <ul class="pagination">
        <?php
        /*echo $this->Paginator->prev('<i class="icon-double-angle-left"></i>Prev', array(), null, array('class' => 'prev disabled','escape'=>false));
        echo $this->Paginator->numbers(array('separator' => false));
        echo $this->Paginator->next('Next<i class="icon-double-angle-right"></i>' , array(), null, array('class' => 'next disabled','escape'=>false));*/
        ?>
        <?php
        //echo $this->Paginator->first('&lsaquo;', array('tag' => 'li', 'title' => __('First page'), 'escape' => false));
        echo $this->Paginator->prev('<i class="icon-double-angle-left"></i>', array('tag' => 'li',  'title' => __('Previous page'), 'disabledTag' => 'span', 'escape' => false), null, array('tag' => 'li', 'disabledTag' => 'span', 'escape' => false, 'class' => 'disabled'));
        echo $this->Paginator->numbers(array('separator' => false, 'tag' => 'li', 'currentTag' => 'span', 'currentClass' => 'active'));
        echo $this->Paginator->next('<i class="icon-double-angle-right"></i>', array('tag' => 'li', 'disabledTag' => 'span', 'title' => __('Next page'), 'escape' => false), null, array('tag' => 'li', 'disabledTag' => 'span', 'escape' => false, 'class' => 'disabled'));
        //echo $this->Paginator->last('&rsaquo;', array('tag' => 'li', 'title' => __('First page'), 'escape' => false));
        ?>
    </ul>
</div>
<?php echo $this->Js->writeBuffer();?>