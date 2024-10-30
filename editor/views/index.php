<style>
    * {
        box-sizing: border-box
    }

    body, html {
        height: calc(100vh - 32px);
    }

    #wpwrap, #wpbody {
        height: 100%;
    }

    #wpcontent {
        margin-left: 0;
        padding-left: 0;
        margin-right: 0;
        padding-right: 0;
    }

    #wpbody-content {
        display: flex;
        flex-direction: column;
        height: 100%;
        float: none;
        padding-bottom: 0;
        background: #FFFFFF;
    }

    .update-nag {
        display: none;
    }

    .notice {
        display: none !important;
    }

    #adminmenumain {
        position: absolute;
        height: 100%;
        overflow-y: auto;
    }

    #adminmenumain:hover, #adminmenumain:focus {
        width: 300px;
    }

    #mantiq {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: auto;
        display: flex;
        flex-direction: column;
        height: 100%;
        font-size: 14px;
    }
</style>

<div id="mantiq">
    <template>
        <div class="app d-flex flex-column h-100" dir="ltr"></div>
    </template>
</div>
<?php /** @var $templates array */ ?>
<?php foreach ($templates as $id => $content): ?>
    <script type="text/html" id="<?php echo esc_attr($id); ?>">
        <?php echo $content; ?>
    </script>
<?php endforeach; ?>
