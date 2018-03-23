<div style="display:none;" data-bind="visible: alert().visible, with: alert">
    <div class="alert" data-bind="css: 'alert-'+type()">
        <div data-bind="text: text" class="alert__msg"></div>
        <span class="alert__close" data-bind="click: $root.closeAlert"></span>
    </div>
</div>