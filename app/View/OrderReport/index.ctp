<div class="portlet box yellow">
    <div class="portlet-title">
        <div class="caption">
            <?php echo __($title)?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row-fluid view_info">
            <div class="span12 ">

                <div class="tabbable tabbable-custom tabbable-full-width">
                    <ul class="nav nav-tabs">

                        <li class="active"><a href="#tab_item" data-toggle="tab"><?php echo __('Answer')?>
                            </a></li>

                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane row-fluid active" id="tab_item">

                            <div class="row-fluid">
                                <table class="table table-bordered dataTable" id="table_orders">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">S/N</th>
                                            <th colspan="2">Order Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($order_reports as $k => $order_report):?>
                                        <tr class="item_tr" style="background-color:#fff;">
                                            <td><span class="row-details row-details-close"></span></td>
                                            <td colspan="2"><?php echo $k?></td>
                                        </tr>
                                        <tr class="hide">
                                            <td></td>
                                            <td colspan="2">
                                                <table class="customborder" border="1" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align: center;"><?php echo $k; ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:50%">Dish</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($order_report as $dish => $dish_data):?>
                                                        <tr>
                                                            <td><?php echo $dish ?></td>
                                                            <td><?php echo $dish_data['quantity'] ?></td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                                <br/>
                                                <?php foreach($order_report as $dish => $dish_data):?>
                                                <table class="customborder" border='1' style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align: center;">Ingredient of <?php echo $dish; ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:50%">Name</th>
                                                            <th>Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($dish_data['ingredient'] as $ing => $ing_qty):?>
                                                        <tr>
                                                            <td style="width:50%"><?php echo $ing; ?></td>
                                                            <td><?php echo $ing_qty; ?></td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                                <br/>
                                                <?php endforeach;?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .customborder {
        border-collapse: collapse;
        border-color:#000;
    }
    .customborder tr th:first-child {
        border-left: 1;
        border-left-color:#000;
    }
    .customborder tr td:first-child {
        border-left: 1;
        border-left-color:#000;
    }
</style>
<?php $this->start('script_own')?>
<script>
    $(document).ready(function () {

        $("body").on('click', 'tbody tr.item_tr', function () {

            if ($(this).next().hasClass("hide")) {
                $(this).next().removeClass("hide");
                $(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-close").addClass("row-details-open");
            } else {
                $(this).next().addClass("hide");
                $(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-open").addClass("row-details-close");
            }

            return false;
        });

    })
</script>
<?php $this->end()?>