
<div id="message1">
    <?php if($validRequest){ ?>
    <div class="jumbotron">
        <div class="container">
            <h3>Selected Type</h3>
            <br/>
            <strong>
            <?php echo ($selectedOption == "" ? "No Type Selected" : $selectedOption); ?>
            </strong>
            <br/>
            <br/>
            Not happy with selected type?  <a class="btn blue red-stripe" href="<?php echo $this->Html->Url(array('controller' => 'Format', 'action' => 'q1')); ?>" role="button">Go Back</a>
        </div>
    </div>
    <?php } ?>

</div>

<?php $this->start('script_own')?>
<?php $this->end()?>