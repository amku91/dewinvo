<div class="alert  ">
    <button class="close" data-dismiss="alert"></button>
    Question: Advanced Input Field</div>

<p>
    1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
    2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

    <?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
    <button class="close" data-dismiss="alert"></button>
    The table you start with</div>
<?php echo $this->Form->create(false, array('id'=>'form_table', 'action' => 'q1_save','type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(				
'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
<table class="table table-striped table-bordered table-hover"  id="dynamic-table">
    <thead>
    <th style="width:10%">
        <span id="add_item_button" class="btn mini green addbutton" onclick="(new dTable()).addNewRow()">
            <i class="icon-plus"></i></span>
    </th>
    <th style="width:50%">Description</th>
    <th style="width:20%">Quantity</th>
    <th style="width:20%">Unit Price</th>
</thead>

<tbody id="dynamic-table-tbody"></tbody>

</table>

<div class="well">
    <?php
    $options_save = array(
    'label' => 'Save',
    'type' => 'button',
    'class' => 'btn red-stripe blue',
    'onclick' => 'globaldTableObj.saveData()',
    'div' => array(
    'class' => 'margin-top-20'
    )
    );
    $options_back = array(
    'class' => 'btn default'
    );
    echo $this->Form->button('Save', $options_save);
    echo $this->Form->button('Save & Next', $options_save);
    echo $this->Html->link('Back','/', $options_back);
    echo $this->form->end();
    ?>
</div>
<p></p>
<div class="alert alert-info ">
    <button class="close" data-dismiss="alert"></button>
    Video Instruction</div>

<p style="text-align:left;">
    <video width="78%" controls>
        <source src="/video/q3_2.mov">
        Your browser does not support the video tag.
    </video>
</p>



<style type="text/css">
    textarea{
        width: 95% !important;
    }
    .margin-top-20{
        margin-top: 20px;
    }
    .btn{
        margin: 0 5px;
    }
</style>
<?php $this->start('script_own');?>
<script>
    var globaldTableObj;
    var rowCount = 0;
    /*If you want to add more column in table just add here.*/
    var fieldList = [
        {label: "Description", name: "description", type: "textarea"},
        {label: "Quantity", name: "quantity", type: "text"},
        {label: "Unit Price", name: "unit_price", type: "text"},
    ];
    var dTable = function () {
        /*Assign current object to global object*/
        globaldTableObj = this;
    };

    dTable.prototype.addNewRow = function () {

        rowCount++;
        /*append to current tbody data*/
        $("#dynamic-table-tbody").append(globaldTableObj.generateEmptyRow(rowCount));
    };
    dTable.prototype.onEditMode = function (_this) {
        console.log("Edit mode on=");
        var $this = $(_this);
        var rowID = $(_this).attr("data-row-id");
        var type = $(_this).attr("data-type");
        var name = $(_this).attr("data-field");
        var textID = '#text-row-' + rowID + '-' + name;
        var formID = '#form-row-' + rowID + '-' + name;
        var $input;
        if (type == "text") {

            $input = $('<input>', {
                value: $(textID).text(),
                type: 'text',
                name: 'data[' + rowID + '][' + name + ']',
                blur: function () {
                    $(formID).hide();
                    $(textID).text(this.value);
                    $(textID).show();
                },
                keyup: function (e) {
//                        if (e.which === 13)
//                            $input.blur();
                }
            });

        } else if (type == "textarea") {

            $input = $('<textarea>', {
                value: $(textID).text(),
                rows: 3,
                cols: 20,
                name: 'data[' + rowID + '][' + name + ']',
                type: 'text',
                blur: function () {
                    //$this.text(this.value);

                    $(formID).hide();
                    $(textID).text(this.value);
                    $(textID).show();
                },
                keyup: function (e) {
//                        if (e.which === 13)
//                            $input.blur();
                }
            });
        }
        /*Append to id*/
        $(formID).html($input);
        $(textID).hide();
        $(formID).show();
        $input.focus();
    };
    dTable.prototype.removeRow = function (rowID) {
        $("#data-row-" + rowID).remove();
    };
    dTable.prototype.generateEmptyRow = function (rowID) {
        var dataHtml = '<tr id="data-row-' + rowID + '">\n\
            <td>\n\
            <a href="javascript:;" class="btn mini red" onclick="globaldTableObj.removeRow(' + rowID + ');">\n\
            <i class="icon-minus"></i>\n\
            </a>\n\
            </td>';
        /*Loop through all dynamic fields. We have to maintain form fields so making like this*/
        $.each(fieldList, function (key, value) {
            dataHtml += '<td onclick="globaldTableObj.onEditMode(this)" data-row-id="' + rowID + '" data-type="' + value.type + '" data-field="' + value.name + '" data-label="' + value.label + '">\n\
            <span id="text-row-' + rowID + '-' + value.name + '"></span><span class="hide" id="form-row-' + rowID + '-' + value.name + '">\n\
            </td>';
        });
        dataHtml += '</tr>';
        return dataHtml;
    };
    dTable.prototype.saveData = function () {
        var $inputs = $('#form_table :input');
        var values = {};
        $inputs.each(function () {
            if(this.name != "")
            values[this.name] = $(this).val();
        });
        alert("Formatted object output consoled. Please open your console to see exact formatted output.\n\n"+JSON.stringify(values));
        console.log(values);
    };
</script>
<?php $this->end();?>

