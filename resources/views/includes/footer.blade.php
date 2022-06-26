<footer class="footer-area bg-gray pb-10 pt-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact-info-wrap">
                    <div class="footer-logo">
                        <a href="#"><img style="margin: 5px 0 0;width: 225px; height: 100px;"
                                         src="{{ asset('uploads/logo.png') }}" alt=""></a>
                    </div>
                    <div class="single-contact-info">
                        <span>Our Location</span>
                        <p>Mirpur-2, Dhaka.</p>
                    </div>
                    <div class="single-contact-info">
                        <span>24/7 hotline:</span>
                        <p>+88018XXXXXXXX</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="footer-right-wrap">
                    <div class="footer-menu">
                        <nav>
                            <ul>
                                <li><a href="/">home</a></li>
                                <!--<li><a href="/services">Services</a></li>-->
                                <li><a href="/about-us">About Us </a></li>
                                <li><a href="/contact-us">Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="social-style-2 social-style-2-mrg">
                        <a href="#"><i class="social_twitter"></i></a>
                        <a href="#"><i class="social_facebook"></i></a>
                        <a href="#"><i class="social_youtube"></i></a>
                    </div>
                    <div class="copyright">
                        <p>Copyright © {{ date('Y') }} BetterMart</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    setTimeout(() => {
        $(document).ready(function () {
            let urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;
            if ((urlParams.search_category !== undefined && urlParams.search_category !== '')
                || (urlParams.search !== undefined && urlParams.search !== '')) {

                if (urlParams.search_category !== undefined && urlParams.search_category !== '') {
                    let categories   = <?php echo json_encode($categories, JSON_HEX_TAG);?>;
                    let categoryId   = urlParams.search_category;
                    let categoryName = categories.filter(function (obj) {
                        return obj.id === parseInt(categoryId);
                    }).map(function (obj) {
                        return obj.name;
                    });
                    $('#categoryName').html('in ' + categoryName[0])
                } else {
                    $('#categoryName').html('')
                }
                $('html, body').animate({
                    scrollTop: $("#products_block").offset().top
                }, 1000);
            }

            if ('orders' in urlParams){
                $('#a_orders')[0].click();
            }
            if ('account-info' in urlParams){
                $('#a_account_info')[0].click();
            }
            if ('change-password' in urlParams){
                $('#a_change_password')[0].click();
            }
        });
    }, 100)

    function searchProduct() {
        let search = $('#search_text').val();
        let url    = window.location.origin + window.location.pathname + "?search=" + search;
        window.location.replace(url);
    }

    function searchProductMobile() {
        let search = $('#mobile_search_text').val();
        let url    = window.location.origin + window.location.pathname + "?search=" + search;
        window.location.replace(url);
    }

    function resetSearch() {
        let url = window.location.origin + window.location.pathname;
        window.location.replace(url);
    }

    function addToCart(productId) {
        $.ajax({
            type   : "GET",
            url    : "{{url('add-to-cart/')}}/" + productId,
            success: function (response) {
                $("#cart_count").load(location.href + " #cart_count");
                $("#cart_count_mobile").load(location.href + " #cart_count_mobile");
                $("#product_cart_div").load(location.href + " #product_cart_div");
                toastr.success(response.message);
            }
        });
    }

    function updateCart(productId, action) {
        if (action === '-') {
            let qnty = parseInt($('#qtyButton_' + productId).val()) - 1;
            if (qnty < 1) {
                $('#qtyButton_' + productId).val(1);
                return;
            } else {
                $('#qtyButton_' + productId).val(qnty);
            }
        }else if (action === '+') {
            let qnty = parseInt($('#qtyButton_' + productId).val()) + 1;
            $('#qtyButton_' + productId).val(qnty)
        }
        else{
            let qnty = parseInt($('#qtyButton_' + productId).val()) - 1;
            if (qnty < 1) {
                $('#qtyButton_' + productId).val(1);
                toastr.error('Quantity must not be less then one');
            }
        }

        let quantity = $('#qtyButton_' + productId).val();

        $.ajax({
            url    : '{{ route('update.cart') }}',
            method : "patch",
            data   : {
                _token  : '{{ csrf_token() }}',
                id      : productId,
                quantity: quantity,
            },
            success: function (response) {
                $("#cart_count").load(location.href + " #cart_count");
                $("#cart_count_mobile").load(location.href + " #cart_count_mobile");
                $("#product_cart_div").load(location.href + " #product_cart_div");
                $("#cart_table").load(location.href + " #cart_table");
                $("#cart_table_total").load(location.href + " #cart_table_total");
                toastr.success(response.message);
            }
        });
    }

    function removeFromCart(productId, from = null) {
        $('#product_tr_' + productId).hide();

        $.ajax({
            url    : '{{ route('remove.from.cart') }}',
            method : "DELETE",
            data   : {
                _token: '{{ csrf_token() }}',
                id    : productId
            },
            success: function (response) {
                toastr.success(response.message);
                if (from === 'cart'){
                    setTimeout(()=>{
                        location.reload();
                    }, 2000);
                }
                else if(from === 'sidebar_cart'){
                    $("#cart_count").load(location.href + " #cart_count");
                    $("#cart_count_mobile").load(location.href + " #cart_count_mobile");
                    $("#product_cart_div").load(location.href + " #product_cart_div");
                }
            }
        });
    }
</script>
