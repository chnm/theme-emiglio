<?php
$pageTitle = __('Browse Documents');
$activeLanguage = (isset($_GET['lang'])) ? $_GET['lang'] : 'rus';
echo head(array('title'=>$pageTitle, 'bodyclass' => 'items browse'));
?>

<div id="primary" class="browse <?php echo $activeLanguage; ?>">

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

    <div id="languages">
        <span class="language-label"><?php echo __('Language'); ?>: </span>
        <?php echo rpi_language_links(); ?>
    </div>

    <table>
        <thead>
            <th><?php echo __('Title'); ?></th>
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('Transcription'); ?></th>
            <th><?php echo __('Translation'); ?></th>
        </thead>
        <tbody>
        <?php foreach (loop('items') as $item): ?>
            <tr class="item hentry">
                <td class="item-meta">
                    <?php if (metadata($item, 'has thumbnail')): ?>
                    <div class="item-img">
                        <?php echo link_to_item(item_image('thumbnail')); ?>
                    </div>
                    <?php endif; ?>
                    <?php
                        $docID = metadata('item', array('Dublin Core', 'Identifier'));
                        $source = '<span class="source"><strong>' . __('Source') . '</strong>: ' . $docID . '</span>';
                        $russianTitle = metadata($item, array('Dublin Core', 'Title'), array('class'=>'permalink'));
                        $englishTitle = metadata('item', array('Item Type Metadata', 'Title (English)'));
                        $russianDesc = metadata('item', array('Dublin Core', 'Description'));
                        $englishDesc = metadata('item', array('Item Type Metadata', 'Description (English)'));
                    ?>

                    <h3>
                    <?php if (($activeLanguage == 'eng') && ($englishTitle !== '')): ?>
                    <?php echo link_to_item($englishTitle); ?>
                    <?php else: ?>
                    <?php echo link_to_item($russianTitle); ?>
                    <?php endif; ?>
                    </h3>

                    <?php if ($russianDesc !== ''): ?>
                    <div class="item-description">
                        <?php if (($activeLanguage == 'eng') && ($englishDesc !== '')): ?>
                        <?php echo $englishDesc; ?>
                        <?php else: ?>
                        <?php echo $russianDesc; ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php echo $source; ?>

                <?php echo fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>

                </td><!-- end class="item-meta" -->
                <td class="item-date"><?php echo ($date = metadata('item', array('Dublin Core', 'Date'))) ? $date : ''; ?></td>
                <td class="check"><?php echo (metadata($item, array('Item Type Metadata', 'Transcription')) ? '&#x2713;' : ''); ?></td>
                <td class="check"><?php echo (metadata($item, array('Item Type Metadata', 'Translation')) ? '&#x2713;' : ''); ?></td>
            </tr><!-- end class="item hentry" -->
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php echo fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

    <?php echo pagination_links(); ?>
</div>

</div><!-- end primary -->

<?php echo foot(); ?>
