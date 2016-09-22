<?php

?>

<div id="<?= $id ?>" class="country-search-item" data-id="<?= $id ?>" data-country_code="<?= $country_code ?>">

    <span class="country-search-item-tick glyphicon glyphicon-ok hide"></span>
    <span class="flag-icon flag-icon-<?= strtolower($country_code) ?>"></span>
    <?= $country_name ?>
</div>
