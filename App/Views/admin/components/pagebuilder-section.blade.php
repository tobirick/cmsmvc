<div class="row">
    <div class="admin-grid-section">
        <div class="admin-grid-section__action">
            <button><i class="fa fa-bars"></i></button>
            <button><i class="fa fa-clone"></i></button>
            <button data-bind="click: deleteSection"><i class="fa fa-times"></i></button>
        </div>
    <div class="admin-grid-rows-wrapper">
        <div class="admin-grid-rows" data-bind="sortable: {data: rows, connectClass: 'admin-grid-rows'}">
            <div class="admin-grid-row">
                <div class="admin-grid-row__action">
                    <button><i class="fa fa-bars"></i></button>
                    <button><i class="fa fa-clone"></i></button>
                    <button data-bind="click: deleteRow"><i class="fa fa-times"></i></button>
                </div>
                <div class="admin-grid-cols" data-bind="sortable: {data: columnrows}">
                    <div data-bind="foreach: columns">
                        <div data-bind="css: 'col-'+col()">
                            <div data-bind="click: setElement" class="admin-grid-col">
                                <i class="fa fa-plus"></i> Insert Module(s)
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