<div style="display:none;" data-bind="visible: alert().visible">
    <div class="alert" data-bind="css: 'alert-'+alert().type()">
        <div data-bind="text: alert().text" class="alert__msg"></div>
        <span class="alert__close" data-bind="click: $root.closeAlert"></span>
    </div>
</div>