jQuery(document).ready(function() {
    var radioProjectType = 'acf[field_654cfe016645a]';
    var projectAmoutPaid = 'acf[field_6589364ace0e1]';
    jQuery('input[name="' + radioProjectType + '"]').prop('disabled', true);
    jQuery('input[name="' + projectAmoutPaid + '"]').prop('disabled', true);  


    // Replace 'country' with the ID or class of your Select2 field
    var countrySelect = jQuery('#acf-field_654bce08aad84,#acf-field_655f131036f4e,#acf-field_65524381f9997');
    // Disable Select2 dropdown
    countrySelect.on('select2:opening', function(e) {
        e.preventDefault();
    });
    // Disable search
    countrySelect.select2({
        minimumResultsForSearch: Infinity
    });
    // Disable user interaction
    countrySelect.on('select2:opening', function(e) {
        e.preventDefault();
    });
    countrySelect.on('select2:close', function(e) {
        countrySelect.select2('open');
    });    


});

