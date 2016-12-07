<?php echo head(array('title' => metadata($item, array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

<h1>
    <?php echo metadata($item, array('Dublin Core', 'Title')); ?>
    <?php if ($englishTitle = metadata($item, array('Item Type Metadata', 'Title (English)'))): ?>
        <span class="eng"><?php echo $englishTitle; ?></span>
    <?php endif; ?>
</h1>

<?php if ($item->getProperty('item_type_name') == 'Document'): ?>

<div class="metadata">
    <div class="short">
    <?php
        $shortElements = array(
            array('Dublin Core', 'Date'),
            array('Dublin Core', 'Subject'),
            array('Dublin Core', 'Contributor')
        );
    ?>
    <?php echo rpi_display_custom_element_set($item, $shortElements); ?>
    </div>
    <div class="long">
    <?php
        $longElements = array(
            array('Dublin Core', 'Identifier'),
            array('Dublin Core', 'Publisher'),
            array('Dublin Core', 'Description'),
            array('Item Type Metadata', 'Description (English)'),
            array('Item Type Metadata', 'Comments')
        );
    ?>
    <?php echo rpi_display_custom_element_set($item, $longElements); ?>
    <?php if ($citation = metadata($item, 'citation', array('no_escape' => true))): ?>
    <div class="element">
        <h3><?php echo __('Citation'); ?></h3>
        <?php echo $citation; ?>
    </div>
    <?php endif; ?>    <?php if (metadata($item, 'has files')): ?>
        <h3><?php echo __('Document Images'); ?></h3>
        <?php echo files_for_item(); ?>
    <?php endif; ?>
    </div>
</div>

<div class="document">
    <div class="transcription">
        <h3><?php echo __('Transcription'); ?></h3>
        <?php echo metadata($item, array('Item Type Metadata', 'Transcription')); ?>
    </div>
    <div class="translation">
        <h3><?php echo __('Translation'); ?></h3>
        <?php echo metadata($item, array('Item Type Metadata', 'Translation')); ?>
    </div>
</div>

<?php else: ?>

<div id="primary">
    <?php if ((get_theme_option('Item FileGallery') == 0) && metadata('item', 'has files')): ?>
    <div id="itemfiles" class="element">
        <?php echo files_for_item(array('imageSize' => 'fullsize')); ?>
    </div>
    <?php endif; ?>

    <?php echo all_element_texts($item); ?>

    <?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

</div><!-- end primary -->

<div id="secondary">

    <!-- The following returns all of the files associated with an item. -->
    <?php if ((get_theme_option('Item FileGallery') == 1) && metadata($item, 'has files')): ?>
    <div id="itemfiles" class="element">
        <h2>Files</h2>
        <?php $itemFiles = $item->Files; ?>
        <?php foreach ($itemFiles as $itemFile): ?>
            <div class="poster element-text"><?php echo link_to($itemFile, 'show', file_image('original', array(), $itemFile)); ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>



    <!-- The following prints a list of all tags associated with the item -->
    <?php if (metadata($item, 'has tags')): ?>
    <div id="item-tags" class="element">
        <h2>Tags</h2>
        <div class="element-text tags"><?php echo tag_string('item'); ?></div>
    </div>
    <?php endif; ?>

    <!-- If the item belongs to a collection, the following creates a link to that collection. -->
    <?php if (get_collection_for_item()): ?>
        <div id="collection" class="element">
            <h2>Collection</h2>
            <div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
        </div>
    <?php endif; ?>

    <!-- The following prints a citation for this item. -->
    <div id="item-citation" class="element">
        <h2>Citation</h2>
        <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
    </div>

</div><!-- end secondary -->

<?php endif; ?>

<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>

<script type="text/javascript">
(function($) {
    $(document).ready(function() {
        $('div.metadata').prepend('<div class="toggle open"></div>');
        $('div.metadata').on('click', '.toggle', function() {
            $('.metadata .short, .metadata .long').slideToggle();
            $(this).toggleClass('open').toggleClass('closed');
        });
    });
})(jQuery)
</script>

<?php echo foot();
