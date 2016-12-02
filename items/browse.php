<?php
$pageTitle = __('Browse Documents');
echo head(array('title'=>$pageTitle, 'bodyclass' => 'items browse'));
?>

<div id="primary" class="browse">

    <h1><?php echo $pageTitle;?> <?php echo __('(%s total)', $total_results); ?></h1>

    <?php echo item_search_filters(); ?>

    <!--<ul class="items-nav navigation" id="secondary-nav">
        <?php echo public_nav_items(); ?>
    </ul>-->

    <?php echo pagination_links(); ?>

    <?php if ($total_results > 0): ?>

    <?php
    $sortLinks[__('Title')] = 'Dublin Core,Title';
    $sortLinks[__('Date')] = 'Item Type Metadata,Sortable Date';
    ?>
    <div id="sort-links">
        <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
    </div>

        <?php foreach (loop('items') as $item): ?>
            <div class="item hentry">
                <h3>
                    <?php echo link_to_item(metadata($item, array('Dublin Core', 'Title'), array('class'=>'permalink'))); ?><br>
                    <?php echo ($english = metadata('item', array('Item Type Metadata', 'Title (English)'))) ? $english : ''; ?>
                </h3>
                <div class="item-meta">
                    <span><strong><?php echo __('Document ID'); ?>:</strong> <?php echo ($docID = metadata('item', array('Dublin Core', 'Identifier'))) ? $docID : ''; ?></span>
                    <span><strong><?php echo __('Date'); ?>: </strong> <?php echo ($date = metadata('item', array('Dublin Core', 'Date'))) ? $date : ''; ?></span>
                    <?php if (metadata($item, 'has tags')): ?>
                    <span><strong><?php echo __('Tags'); ?>: </strong> <?php echo tag_string('items'); ?></span>
                    <?php endif; ?>
                </div>


                <?php if (metadata($item, 'has thumbnail')): ?>
                    <span class="feature"><?php echo __('Image Available'); ?></span>
                    <div class="item-img">
                    <?php echo link_to_item(item_image('thumbnail')); ?>
                    </div>
                <?php endif; ?>

                <?php if (metadata($item, array('Item Type Metadata', 'Transcription'))): ?>
                    <span class="feature"><?php echo __('Transcription'); ?></span>
                <?php endif; ?>

                <?php if (metadata($item, array('Item Type Metadata', 'Translation'))): ?>
                    <span class="feature"><?php echo __('Translation'); ?></span>
                <?php endif; ?>

                <?php echo fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>
            </div><!-- end class="item hentry" -->
        <?php endforeach; ?>
    <?php endif; ?>
    <?php echo fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

    <?php echo pagination_links(); ?>
</div>

</div><!-- end primary -->

<?php echo foot(); ?>
