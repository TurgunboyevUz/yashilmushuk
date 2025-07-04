<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Contact Javascript File -->
<script src="{{ asset('mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('mail/contact.js') }}"></script>
<!-- AOS Library -->
<script src="{{ asset('js/aos.js') }}"></script>
<!-- Template Javascript -->
<script src="{{ asset('js/main.js') }}"></script>
<script>
    $(document).ready(function() {
        var a = $(".btn-sm[data-target='#orderModal']");
        a.on("click", function() {
            var b = $(this).closest(".card").find(".text-truncate").text();
            $("#orderModal .modal-title").html("<i class='fas fa-shopping-cart mr-2'></i> " + b)
        });
        $("#orderModal").on("hidden.bs.modal", function() {
            $("#orderModal .modal-body p").remove()
        })
    });

</script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-XXXXX-Y');

</script>

