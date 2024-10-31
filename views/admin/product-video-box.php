<div class="tagsdiv">
    <div class="product-videos-jaxtag">
        <div class="ajaxtag hide-if-no-js">
            <label class="screen-reader-text" for="new-product-video"><?php _e('Add new video', 'premmerce-toolkit'); ?></label>
            <p>
                <input type="text" data-input="new-product-video" size="16" autocomplete="off" aria-describedby="new-tag-product_tag-desc" value="" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="ui-id-1">
                <input class="button" data-input="new-product-video-button" value="<?php _e('Add'); ?>" type="button">
            </p>
        </div>
        <p class="howto"><?= __('YouTube or Vimeo video URL.', 'premmerce-toolkit') ?></p>
    </div>
</div>

<div class="product_videos_container">
    <ul data-ul="product_videos" class="product_images product_videos">
        <?php foreach ($urls as $url) : ?>
            <li data-li="thumb" class="image" data-url="<?= $url; ?>">
                <?php
                    $urlArray = parse_url($url);
                    $parseUrl = [];

                    if (isset($urlArray['query'])) {
                        parse_str($urlArray['query'], $parseUrl);
                    }

                    if ($urlArray['host'] == 'www.youtube.com' || $urlArray['host'] == 'youtu.be') {
                        $thumbUrl = 'https://img.youtube.com/vi/' . (isset($parseUrl['v']) ? $parseUrl['v'] : trim($urlArray['path'], '/')) . '/0.jpg';
                    }
                    else if($urlArray['host'] == 'vimeo.com') {
                        $pathParts = explode('/', trim($urlArray['path'], '/'));
                        $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $pathParts[count($pathParts) - 1] . '.php'));

                        $thumbUrl = $hash[0]['thumbnail_medium'];
                    }
                ?>
                <input type="hidden" name="product_video[]" value="<?= esc_attr($url) ?>" />

                <img class="attachment-thumbnail size-thumbnail" width="78" src="<?= $thumbUrl ?>" />
                <ul class="actions">
                    <li><a class="delete tips" data-action="delete" data-tip="<?php _e('Delete video', 'premmerce-toolkit'); ?>"><?php _e('Delete'); ?></a></li>
                </ul>
            </li>
        <?php endforeach ?>
    </ul>
</div>

<div lang-name="delete-image" lang-value="<?php _e('Delete video', 'premmerce-toolkit'); ?>"></div>
<div lang-name="delete" lang-value="<?php _e('Delete', 'premmerce-toolkit'); ?>"></div>
<div lang-name="url-not-valid" lang-value="<?php _e('Please enter correct URL.', 'premmerce-toolkit'); ?>"></div>
<div lang-name="only-youtube-vimeo" lang-value="<?php _e('Please enter URL of YouTube or Vimeo video.', 'premmerce-toolkit'); ?>"></div>
