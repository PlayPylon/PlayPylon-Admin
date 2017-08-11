
<?php

$pockets = [];
foreach ($balance->pending as $currset) {
    if (empty($pockets[$currset->currency])) $pockets[$currset->currency] = 0;
    $pockets[$currset->currency] += $currset->amount;
}
foreach ($balance->available as $currset) {
    if (empty($pockets[$currset->currency])) $pockets[$currset->currency] = 0;
    $pockets[$currset->currency] += $currset->amount;
}

foreach ($pockets as $curr => $amounts) {
    echo currency(($amounts / 100),$curr);
}
?>