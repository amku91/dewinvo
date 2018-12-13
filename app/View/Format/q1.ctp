
<div id="message1">


<?php echo $this->Form->create(false, array('id'=>'form_type', 'action' => 'q1_save','type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(				
				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>

<?php echo __("Hi, please choose a type below:")?>
    <br><br>

<?php $options_new = array(
 		'Type1' => __('<span class="showPopup" data-id="1" title="Type 1" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Loading..." style="color:blue">Type1</span><div id="popup_1" class="hide dialog">
 				<span style="display:inline-block"><ul><li>Description .......</li>
 				<li>Description 2</li></ul></span>
 				</div>'),
		'Type2' => __('<span class="showPopup" data-id="2" title="Type 2" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Loading..." style="color:blue">Type2</span><div id="popup_2" class="hide dialog">
 				<span style="display:inline-block"><ul><li>Desc 1 .....</li>
 				<li>Desc 2...</li></ul></span>
 				</div>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'checked' => false, 'class' => 'select-radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>


<?php
$options_save = array(
    'label' => 'Save',
    'class' => 'btn red-stripe blue',
    'div' => array(
        'id' => 'submit-save-btn',
        'class' => 'margin-top-20'
    )
);
echo $this->Form->end($options_save);
?>

</div>

<style>
    .showPopup:hover{
        text-decoration: underline;
    }

    #message1 .radio{
        vertical-align: top;
        font-size: 13px;
    }

    .control-label{
        font-weight: bold;
    }

    .wrap {
        white-space: pre-wrap;
    }
    .margin-top-20{
        margin-top: 20px;
        display: none;
    }
    .btn-primary{
        
    }

</style>

<?php $this->start('script_own')?>
<script>
    $('[data-toggle="popover"]').hover(function () {
        var _this = $(this);
        var id = $(this).attr('data-id');
        var content = $("#popup_" + id).html();
        if ($(".popover:hover").length != 0) {
            $(".showPopup").popover("destroy");
            //$(this).parent().find('.select-radio').prop('checked', false);
        }
        _this.popover({
            placement: 'right',
            trigger: 'hover',
            html: true,
            content: content
        }).on("mouseout", function () {
                if (!$(".popover:hover").length) {
                    $(".popover").popover("destroy");
                    //$(this).parent().find('.select-radio').prop('checked', false);
                }
        });
        _this.popover('show');
        /*Show button also*/
        $("#submit-save-btn").show();
        /*Select nearest radio*/
        $(this).parent().find('.select-radio').prop('checked', true);
        setTimeout(function () {
            $('.popover-content').on("mouseleave", function () {
                $(".popover").popover("destroy");
                //$(this).parent().find('.select-radio').prop('checked', false);
            });
        }, 300);
    });
</script>
<?php $this->end()?>