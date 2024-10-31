(function ($) {
    'use strict';

    $(document).on('click', 'a[data-action="delete"]', function () {
        $(this).trigger('mouseout').closest('[data-li="thumb"]').remove();
    });

    $(document).on('keypress', 'input[data-input="new-product-video"]', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            addProductVideo();
        }
    });

    $(document).on('click', 'input[data-input="new-product-video-button"]', function () {
        addProductVideo();
    });

    function addProductVideo() {
        var $input = $('[data-input="new-product-video"]');
        var url = $input.val();

        if (!isValidUrl(url)) {
            woocommerce_admin.i18n_url_not_valid_error = $('[lang-name="url-not-valid"]').attr('lang-value');

            $(document.body).triggerHandler('wc_add_error_tip', [$input, 'i18n_url_not_valid_error']);
            return;
        }

        var urlObj = new URL(url);

        if (urlObj.host != 'www.youtube.com' && urlObj.host != 'youtu.be' && urlObj.host != 'vimeo.com') {
            woocommerce_admin.i18n_only_youtube_vimeo_error = $('[lang-name="only-youtube-vimeo"]').attr('lang-value');

            $(document.body).triggerHandler('wc_add_error_tip', [$input, 'i18n_only_youtube_vimeo_error']);
            return;
        }

        if (url.length > 0) {
            var v = getParameterByName('v', url);

            if (!v) {
                v = urlObj.pathname.replace('/', '');
            }

            var image = $('<img/>', {
                'class': 'attachment-thumbnail size-thumbnail',
                'src': 'https://img.youtube.com/vi/' + v + '/0.jpg',
                'heigth': 150
            });

            var input = $('<input/>', {
                'type': 'hidden',
                'name': 'product_video[]',
                'value': url
            });

            var aDelete = $('<a/>', {
                'class': 'delete tips',
                'data-action': 'delete',
                'data-tip': $('[lang-name="delete-image"]').attr('lang-value'),
                'html': $('[lang-name="delete"]').attr('lang-value')
            });

            var liDelete = $('<li/>', {
                'html': aDelete
            });

            var ulActions = $('<ul/>', {
                'class': 'actions',
                'html': liDelete
            });

            $('<li/>', {
                'class': 'image',
                'data-li': 'thumb',
                'data-url': url,
                'html': [input, image, ulActions]
            }).appendTo('ul[data-ul="product_videos"]');
            $('[data-input="new-product-video"]').val('');
        }
    }
    
    function getParameterByName(name, url) {
        var url_string = url;
        var url = new URL(url_string);
        var param = url.searchParams.get(name);

        return param;
    }

    function isValidUrl(url) {
        var objRE = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return objRE.test(url);
    }

})(jQuery);
