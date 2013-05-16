jQuery(function(){
    var aDGs = {};

    jQuery(".ppecdg-btn").each(function(iIndex, eElement){
        var sID = eElement.id;
        aDGs[sID] = new PAYPAL.apps.DGFlow({
          trigger: sID,
          expType: 'instant'
        });
    });
    
    jQuery('.data-calform-date').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        
        onSelect: function(dateText, ePicker)
        {
          console.log("ePicker =", ePicker);
          var $itemname = jQuery(this).nextAll('.data-calform-name');
          $itemname.val('Sponsor A Day/'+dateText);
          var $price = jQuery(this).nextAll('.data-calform-price');
          var oDate = jQuery.datepicker.parseDate( "yy-mm-dd", dateText );
          var iDay = jQuery.datepicker.formatDate( "o", oDate );
          $price.val(iDay);
        }
    });
  
    jQuery('.data-calform-price').change(function(event){
        var oDate = jQuery.datepicker.parseDate( "o", jQuery(event.target).val() );
        var oNow = new Date();
        
        if(oDate < oNow)
        {
          oDate.setFullYear(oDate.getFullYear() + 1);
        }
        
        var dateText = jQuery.datepicker.formatDate( "yy-mm-dd", oDate);
        var $date = jQuery('.data-calform-date');
        $date.val(dateText);
        var $itemname = jQuery('.data-calform-name');
        $itemname.val('Sponsor A Day/'+dateText);
    });

    
    jQuery('.ppecdg_formlink').click(function(event){
        var $span = jQuery(event.target).children('span');
        var dateText = $span.text().trim();
        var oDate = jQuery.datepicker.parseDate( "yy-mm-dd", dateText );
        var iDay = jQuery.datepicker.formatDate( "o", oDate );
        jQuery('.data-calform-price').val(iDay);
        jQuery('.data-calform-date').val(dateText);
        jQuery('.data-calform-name').val('Sponsor A Day/'+dateText); 
    });
    
});

