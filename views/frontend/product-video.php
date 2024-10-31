<?php global $wp_embed; ?>

<?php foreach ($urls as $url) : ?>
    <?php
        $urlArray = parse_url($url);
        $parseUrl = [];

        if (isset($urlArray['query'])) {
            parse_str($urlArray['query'], $parseUrl);
        }

        if ($urlArray['host'] == 'www.youtube.com' || $urlArray['host'] == 'youtu.be') {
            $thumbUrl = 'https://img.youtube.com/vi/' . (isset($parseUrl['v']) ? $parseUrl['v'] : trim($urlArray['path'], '/')) . '/0.jpg';
        }
        else if ($urlArray['host'] == 'vimeo.com') {
            $pathParts = explode('/', trim($urlArray['path'], '/'));
            $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $pathParts[count($pathParts) - 1] . '.php'));

            $thumbUrl = $hash[0]['thumbnail_medium'];
        }
    ?>

    <div data-thumb="<?= $thumbUrl ?>" class="woocommerce-product-gallery__image">
        <img style="display: none;" data-large_image="<?= $thumbUrl ?>" data-large_image_width="324" data-large_image_height="260">
        <?= $wp_embed->run_shortcode('[embed width="324" height="260"]' . $url . '[/embed]') ?>
    </div>
<?php endforeach ?>
