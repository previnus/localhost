jQuery(document).ready(function($) {
   $('.popup').click(function() {
     var NWin = window.open($(this).prop('href'), '', 'scrollbars=1,height=650,width=450');
     if (window.focus)
     {
       NWin.focus();
     }
     return false;
    });
});