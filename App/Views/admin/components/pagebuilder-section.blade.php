<div data-bind="if: $root.currentLanguage().id === language_id()" class="row">
    <div class="admin-grid-section">
        <div class="admin-grid-section__action">
            <button data-bind="click: $root.openSettings"><i class="fa fa-bars"></i></button>
            <button data-bind="click: cloneSection"><i class="fa fa-clone"></i></button>
            <button data-bind="click: deleteSection"><i class="fa fa-times"></i></button>
        </div>
    <div class="admin-grid-rows-wrapper">
        <div class="admin-grid-rows" data-bind="sortable: {data: rows, connectClass: 'admin-grid-rows', options: {revert: 'invalid'}}">
            <div class="admin-grid-row">
                <div class="admin-grid-row__action">
                    <button data-bind="click: $root.openSettings"><i class="fa fa-bars"></i></button>
                    <button data-bind="click: cloneRow"><i class="fa fa-clone"></i></button>
                    <button data-bind="click: deleteRow"><i class="fa fa-times"></i></button>
                </div>
                <div class="admin-grid-cols" data-bind="css: {empty: columnrows().length === 0}, sortable: {data: columnrows, containment: '.test', connectClass: 'admin-grid-col-wrapper', options: {revert: 'invalid'}}">
                    <div data-bind="foreach: columns" class="test">
                        <div class="admin-grid-col-wrapper" data-bind="css: 'col-'+col(), droppable: {data: setElement, options: {greedy: true, accept: '.admin-element-list-item, .admin-grid-element'}}">
                            <div class="admin-grid-col">
                                <div data-bind="ifnot: elementSelected, style: { display: elementSelected() ? 'none' : 'flex'}">
                                    <i class="fa fa-plus"></i> <span class="smaller">{{$lang['Drag Elements here']}}</span>
                                </div>
                                <div class="admin-grid-element-wrapper" data-bind="if: elementSelected, style: { display: elementSelected() ? 'flex' : 'none'}">
                                    <div data-bind="draggable: {data: $data.element, connectClass: 'admin-grid-element-wrapper', options: {helper: 'clone', appendTo: 'body', revert: 'invalid', greedy: true}}" class="admin-grid-element">
                                        <div>
                                            <button data-bind="click: $root.openSettings" class="admin-grid-element__button"><i class="fa fa-bars"></i></button>
                                        </div>
                                        <span data-bind="text: name() !== '' ? name : item_name" class="admin-grid-element__name"></span>
                                        <div>
                                            <button data-bind="click: $parent.deleteElement" class="admin-grid-element__button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button style="right: 10px;" data-bind="visible: element() === null, click: removeCol" class="admin-grid-element__button center-abs-top"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <span data-bind="click: addRow" class="admin-grid__add-row"><i class="fa fa-plus"></i> {{$lang['Add Row']}}</span>
    </div>
     </div>
  </div>