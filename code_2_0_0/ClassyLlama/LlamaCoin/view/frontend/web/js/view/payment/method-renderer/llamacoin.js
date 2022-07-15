define([
        'jquery',
        // 'Magento_Payment/js/view/payment/cc-form'
        'Magento_Checkout/js/view/payment/default'
    ],
    function ($, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'ClassyLlama_LlamaCoin/payment/llamacoin'
            },

            context: function() {
                console.log(this);
            },

            getCode: function() {
                return 'classyllama_llamacoin';
            },

            getQrcode: function() {
                var isMobile = {
                    Android: function() {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function() {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function() {
                        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function() {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function() {
                        return navigator.userAgent.match(/IEMobile/i);
                    },
                    any: function() {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };

                if (isMobile.any()){
                    var elem = document.getElementById("pay_button");
                    elem.style.visibility = 'visible';
                    var domain_movil = "http://"+window.location.hostname+"/llamacoin/qrcode/movil";
                    $.get(
                        domain_movil,
                        function (result) {
                            var data = JSON.parse(result);
                            console.log(data);
                            document.getElementById("access_id").value = data['access_id'];
                            document.getElementById("type").value = data['type'];
                            document.getElementById("version").value = data['version'];
                            document.getElementById("timestamp").value = data['timestamp'];
                            document.getElementById("content").value = data['content'];
                            document.getElementById("format").value = data['format'];
                            document.getElementById("sign").value = data['sign'];

                            var quote_id = data['quote_id'];
                            console.log(data['quote_id']);
                            var id = setInterval(function(){
                                var domain_verify = "http://"+window.location.hostname+"/llamacoin/qrcode/verify?quote_id="+quote_id;
                                $.get(
                                    domain_verify,
                                    function (result) {
                                        console.log(result);
                                        if(result != 3) {
                                            var order = result.replace(/0/g, "");
                                            var url_order = "http://"+window.location.hostname+"/sales/order/view/order_id/"+order+"/";
                                            //var main_content = '<a id="contentarea" tabindex="-1"></a><div><h1 class="page-title"><span class="base" data-ui-id="page-title-wrapper">Thank you for your purchase!</span></h1></div><div class="page messages"><div data-placeholder="messages"></div></div><div class="columns"><div class="column main"><input name="form_key" type="hidden" value="ErZeEOYiCSGFIN88"/><div id="authenticationPopup" style="display: none;"></div><div id="map-popup-click-for-price" class="map-popup"><div class="popup-header"><strong class="title" id="map-popup-heading-price"></strong></div><div class="popup-content"><div class="map-info-price" id="map-popup-content"><div class="price-box"><div class="map-msrp" id="map-popup-msrp-box"><span class="label">Price</span><span class="old-price map-old-price" id="map-popup-msrp"><span class="price"></span></span></div><div class="map-price" id="map-popup-price-box"><span class="label">Actual Price</span><span id="map-popup-price" class="actual-price"></span></div></div><form action="" method="POST" class="map-form-addtocart"><input type="hidden" name="product" class="product_id" value="" /><button type="button" title="Add to Cart" class="action tocart primary"><span>Add to Cart</span></button><div class="additional-addtocart-box"></div></form></div><div class="map-text" id="map-popup-text">Our price is lower than the manufacturer&#039;s &quot;minimum advertised price.&quot; As a result, we cannot show you the price in catalog or the product page. <br><br> You have no obligation to purchase the product once you know the price. You can simply remove the item from your cart.</div></div></div><div id="map-popup-what-this" class="map-popup"><div class="popup-header"><strong class="title" id="map-popup-heading-what-this"></strong></div><div class="popup-content"><div class="map-help-text" id="map-popup-text-what-this">Our price is lower than the manufacturer&#039;s &quot;minimum advertised price.&quot; As a result, we cannot show you the price in catalog or the product page. <br><br> You have no obligation to purchase the product once you know the price. You can simply remove the item from your cart.</div></div></div><div class="checkout-success"><p>Your order # is: <a href="'+url_order+'">'+result+'</a>.</p><p>Email</p><div class="actions-toolbar"><div class="primary"><a class="action primary continue" href="http://magentocodeals.codeals.es/"><span>Continue Shopping</span></a></div></div></div></div></div>';
                                            //document.getElementById("maincontent").innerHTML = main_content;
                                            window.location.replace(url_order);
                                            clearInterval(id);
                                        }
                                    }
                                );
                            },2000);
                        }
                    );
                }
                else{
                    var domain_qrcode = "http://"+window.location.hostname+"/llamacoin/qrcode/qrcode";
                    $.get(
                        domain_qrcode,
                        function (result) {
                            var split = result.split("&");
                            if (split[0] == "error") {
                                var elem = document.getElementById("error_content");
                                elem.style.visibility = 'visible';
                            }
                            else{
                                var elem = document.getElementById("qr_code");
                                elem.style.visibility = 'visible';
                                var quote_id = split[1];
                                console.log(split[1]);
                                document.getElementById("qr_code").src = split[0];
                                var id = setInterval(function(){
                                    var domain_verify = "http://"+window.location.hostname+"/llamacoin/qrcode/verify?quote_id="+quote_id;
                                    $.get(
                                        domain_verify,
                                        function (result) {
                                            console.log(result);
                                            if(result != 3) {
                                                var order = result.replace(/0/g, "");
                                                var url_order = "http://"+window.location.hostname+"/sales/order/view/order_id/"+order+"/";
                                                //var main_content = '<a id="contentarea" tabindex="-1"></a><div><h1 class="page-title"><span class="base" data-ui-id="page-title-wrapper">Thank you for your purchase!</span></h1></div><div class="page messages"><div data-placeholder="messages"></div></div><div class="columns"><div class="column main"><input name="form_key" type="hidden" value="ErZeEOYiCSGFIN88"/><div id="authenticationPopup" style="display: none;"></div><div id="map-popup-click-for-price" class="map-popup"><div class="popup-header"><strong class="title" id="map-popup-heading-price"></strong></div><div class="popup-content"><div class="map-info-price" id="map-popup-content"><div class="price-box"><div class="map-msrp" id="map-popup-msrp-box"><span class="label">Price</span><span class="old-price map-old-price" id="map-popup-msrp"><span class="price"></span></span></div><div class="map-price" id="map-popup-price-box"><span class="label">Actual Price</span><span id="map-popup-price" class="actual-price"></span></div></div><form action="" method="POST" class="map-form-addtocart"><input type="hidden" name="product" class="product_id" value="" /><button type="button" title="Add to Cart" class="action tocart primary"><span>Add to Cart</span></button><div class="additional-addtocart-box"></div></form></div><div class="map-text" id="map-popup-text">Our price is lower than the manufacturer&#039;s &quot;minimum advertised price.&quot; As a result, we cannot show you the price in catalog or the product page. <br><br> You have no obligation to purchase the product once you know the price. You can simply remove the item from your cart.</div></div></div><div id="map-popup-what-this" class="map-popup"><div class="popup-header"><strong class="title" id="map-popup-heading-what-this"></strong></div><div class="popup-content"><div class="map-help-text" id="map-popup-text-what-this">Our price is lower than the manufacturer&#039;s &quot;minimum advertised price.&quot; As a result, we cannot show you the price in catalog or the product page. <br><br> You have no obligation to purchase the product once you know the price. You can simply remove the item from your cart.</div></div></div><div class="checkout-success"><p>Your order # is: <a href="'+url_order+'">'+result+'</a>.</p><p>Email</p><div class="actions-toolbar"><div class="primary"><a class="action primary continue" href="http://magentocodeals.codeals.es/"><span>Continue Shopping</span></a></div></div></div></div></div>';
                                                //document.getElementById("maincontent").innerHTML = main_content;
                                            	window.location.replace(url_order);
                                                clearInterval(id);
                                            }
                                        }
                                    );
                                },2000);
                            }
                        }
                    );
                }
            },

            isActive: function() {
                return true;
            }
        });
    }
);
