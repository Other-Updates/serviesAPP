<?php
if (isset($stock) && !empty($stock)) {
    $i = 1;
    foreach ($stock as $val) {
        ?>
        <tr>
            <td class="action-btn-align"><?= $i ?></td>
            <td><?= $val['categoryName'] ?></td>
            <td><?= $val['brands'] ?></td>
            <td><?= $val['model_no'] ?></td>
            <td><?= $val['product_name'] ?></td>
            <td class="action-btn-align"><?= $val['quantity'] ?></td>
        </tr>
        <?php
        $i++;
    }
} else {
    echo '<tr><td colspan="5">Data not found...</td></tr>';
}
?>