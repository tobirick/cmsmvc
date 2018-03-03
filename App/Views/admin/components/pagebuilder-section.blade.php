<div class="row">
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
                <div class="admin-grid-cols" data-bind="sortable: {data: columnrows, connectClass: 'admin-grid-cols', options: {revert: 'invalid'}}">
                    <div data-bind="foreach: columns">
                        <div data-bind="css: 'col-'+col(), droppable: {data: setElement, options: {greedy: true, accept: '.admin-element-list-item'}}">
                            <div class="admin-grid-col">
                                <div data-bind="ifnot: elementSelected, style: { display: elementSelected() ? 'none' : 'flex'}">
                                    <i class="fa fa-plus"></i> Insert Module(s)
                                </div>
                                <div class="admin-grid-element-wrapper" data-bind="if: elementSelected, style: { display: elementSelected() ? 'flex' : 'none'}">
                                    <div data-bind="with: element" class="admin-grid-element">
                                        <div>
                                            <button data-bind="click: $root.openSettings" class="admin-grid-element__button"><i class="fa fa-bars"></i></button>
                                        </div>
                                        <span data-bind="text: name" class="admin-grid-element__name"></span>
                                        <div>
                                            <button data-bind="click: $parent.deleteElement" class="admin-grid-element__button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <span data-bind="click: addRow" class="admin-grid__add-row"><i class="fa fa-plus"></i> Add Row</span>
    </div>
     </div>
  </div>