<?php
foreach ($eventscode as $val) {
    ?>
    <tr id="type<?= $val->id ?>"><td ><?= $val->promo_code ?></td>
        <td ><?= $val->value ?>
            <?php
            if ($val->type == 0) {
                echo ' %';
            } else {
                echo ' (' . $val->currency_code . ')';
            }
            ?>
        </td>
        <td>
            <?= date(FORMAT_DATE, strtotime($val->expire_time)) ?>
        </td>
        <td>
            <span data-link="<?php echo site_url('event/delete_promo/' . $val->id) ?>" data-namevalue="<?= $val->promo_code ?>" data-id="<?= $val->id ?>" class="deletetype btn btn-sm btn-danger" title="archive">
                <i class="fa fa-remove"></i>
            </span>  
        </td>
    </tr>
    <?php
}
?>
