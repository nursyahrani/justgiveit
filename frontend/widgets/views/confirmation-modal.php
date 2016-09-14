<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!-- Modal -->
<div class="modal fade confirmation-modal" id="<?= $id ?>" tabindex="-1" role="dialog" data-id="<?= $id ?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header confirmation-modal-header">
        <h4 class="modal-title" id="myModalLabel"><?= $title ?></h4>
      </div>
      <div class="modal-body">
          <?= $text ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default confirmation-modal-cancel">Cancel</button>
<button type="button" class="btn btn-warning confirmation-modal-ok">Ok</button>
      </div>
    </div>
  </div>
</div>
