<div class="col-12 col-md-6">
    <{foreach item=block from=$xoBlocks.page_bottomleft}>
    <div class="xoops-bottom-blocks">
        <{if $block.title}><h4><{$block.title}></h4><{/if}>
        <{include file="$theme_name/tpl/blockContent.tpl"}>
    </div>
    <{/foreach}>
</div>