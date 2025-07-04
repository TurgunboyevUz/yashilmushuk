$(document).ready(function() {
    function filterProducts() {
        var categories = [];
        var prices = [];
        var colors = [];
        var litrs = [];

        $('#category-filter input[type="checkbox"]:checked').each(function() {
            categories.push($(this).val());
        });

        $('#price-filter input[type="checkbox"]:checked').each(function() {
            prices.push($(this).val());
        });

        $('#color-filter input[type="checkbox"]:checked').each(function() {
            colors.push($(this).val());
        });

        $('#litr-filter input[type="checkbox"]:checked').each(function() {
            litrs.push($(this).val());
        });

        $.ajax({
            url: 'filter_products.php',
            type: 'POST',
            data: {
                categories: categories,
                prices: prices,
                colors: colors,
                litrs: litrs
            },
            success: function(response) {
                $('#product-list').html(response);
            }
        });
    }

    $('#category-filter, #price-filter, #color-filter, #litr-filter').on('change', function() {
        filterProducts();
    });

    filterProducts();
});
