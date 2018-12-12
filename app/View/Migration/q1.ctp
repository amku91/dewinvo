<div class="row-fluid">
	<div class="alert alert-info">
		<h3>Migrate CSV</h3>
	</div>
<?php
echo $this->Form->create(false, array('type' => 'file'));
echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file'));
echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>

</div>