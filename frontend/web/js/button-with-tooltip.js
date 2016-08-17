/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {
   $(document).on('mouseover', '.button-with-tooltip-button', function(e) {
       var id = $(this).data('widget');
       var $widget = $("#" + id);
       var $tooltip = $widget.find('.button-with-tooltip-tooltip');
       $tooltip.removeClass('button-with-tooltip-hide');
   }) ;
   
   $(document).on('mouseout', '.button-with-tooltip-button', function(e) {
       var id = $(this).data('widget');
       var $widget = $("#" + id);
       var $tooltip = $widget.find('.button-with-tooltip-tooltip');
       $tooltip.addClass('button-with-tooltip-hide');
   }) ;
});