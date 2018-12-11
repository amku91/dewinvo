
<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>	
			</tr>
		</thead>
                <tbody>
                    
                </tbody>
	</table>
</div>
<?php $this->start('script_own')?>
<script type="text/javascript">
$(document).ready(function () {
        console.log("DOCUMENT REaDY");
        $("#table_records").dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $this->Html->Url(array('controller' => 'Record', 'action' => 'data')); ?>",
            "aoColumns": [
                {mData:"Record.id"},
                {mData:"Record.name"}
            ],
        });
    });
</script>
<?php $this->end()?>