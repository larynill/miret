<style>
    .tagTable{
        font-size: 12px;
        border-collapse: collapse;
    }
    .tagTable>tbody>tr>td{
        padding-right: 10px;
    }
    .tagsGrid{
        height: 580px;
        border: 1px solid #000000;
        font-size: 11px!important;
    }

    .slick-row, .alt_drop_div{
        font-size: 12px!important;
    }

    .slick-cell{
        font-size: 11px!important;
        cursor: pointer;
        text-align: center;
    }
    .slick-header-column{
        background: #000000!important;
        padding:5px 10px!important;
        color:#FFF!important;
        text-align: center!important;
        font-size: 12px!important;
    }
    .slick-row:hover {
        background: #44a7cc!important;
    }
    .slick-row.active{
        background: #ff8f47!important;
    }
    .slick-cell.description, .slick-cell.text{
        text-align: left;
    }

    .filterArea{
        border-collapse: collapse;
        font-size: 12px;
    }
    .filterArea tr td:first-child{
        font-weight: bold;
    }
    .filter, .exclude{
        padding: 5px 8px!important;
    }

    .tagBtn{
        cursor: pointer;
    }

    .rowSelected{
        text-align: right;
        font-size: 10px;
        font-weight: bold;
        color: #515151;
    }

    .slickTitle{
        font-family: "Arial", sans-serif!important;
        background: #000000;
        padding: 10px;
        z-index: 999;
        font-size: 12px;
        position: absolute;
        color: #ffffff;
        border-radius: 5px;
        width: 450px;
        word-break: break-all;
    }
</style>
<div class="row">
    <div class="col-sm-8">
        <div class="tagsGrid grid"></div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 20px;font-size: 16px;">
                    <a href="#" class="insertBtn tagBtn" title="insert" style="color: #008000;"><i class="glyphicon glyphicon-plus"></i></a>
                </td>
                <td style="width: 20px;font-size: 16px;">
                    <a href="#" class="removeBtn tagBtn disabled" id="delete" title="remove" style="color: #ff0000;"><i class="glyphicon glyphicon-minus"></i></a>
                </td>
                <td class="rowSelected"></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4">
        <table class="filterArea">
            <tr>
                <td style="vertical-align: middle;">Filter:</td>
                <td style="padding: 5px;">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="text" name="filter" class="filter form-control input-sm" />
                        </div>
                        <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="exact" class="exact" value="1"> &nbsp;&nbsp;&nbsp;Exact
                                </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle;">Excluding:</td>
                <td style="padding: 5px;">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="text" name="exclude" class="exclude form-control input-sm" />
                        </div>
                        <div class="col-sm-3">
                            <button type="button" name="print" value="Print" class="printBtn btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> Print</button>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <hr style="width: 100%;"/>

        <div id="trussDetail" style="display:none;width: 100%;"></div>
    </div>
</div>

<script language="JavaScript">
    //region Variables
    var tagsGrid, tagsGridJson = [], tagsDataView,
        scrollToGridRef,
        tagsGridSortCol = "seq",
        tagsGridSort = true,
        tagsGridColumns = [
            /*{id: "tag_id", name: "ID", field: "tag_id", width: 40, sortable: true},*/
            {id: "description", name: "Description", field: "description", width: 150, cssClass: "description", sortable: true},
            {id: "text", name: "Text", field: "text", width: 270, cssClass: "text", sortable: true}
        ],
        tagsGridOptions = {
            enableCellNavigation: true,
            enableColumnReorder: true,
            multiColumnSort: true,
            forceFitColumns: true
        },
        tagsGridActiveId = "<?php echo $activeId ? $activeId : ""; ?>",
        tagCurrentRow,
        $includes, $excludes,
        filterContainsAll, filterContainsAny;
    //endregion

    $(function(e){
        var trussDetail = $('#trussDetail');
        var rowSelected = $('.rowSelected');
        var insertBtn = $('.insertBtn');
        var removeBtn = $('.removeBtn');
        var franchise = $('.franchise');
        var printBtn = $('.printBtn');

        tagsGridJson = <?php echo $tags ? $tags : '[]'; ?>;

        tagsDataView = new Slick.Data.DataView({ inlineFilters: true });
        tagsGrid = new Slick.Grid(".tagsGrid", tagsDataView, tagsGridColumns, tagsGridOptions);
        tagsGrid.setSortColumn(tagsGridSortCol, tagsGridSort);
        tagsGrid.setSelectionModel(new Slick.RowSelectionModel());

        //region Filter Area
        $includes = $('.filter');
        $excludes = $('.exclude');
        var lastIncludes = $includes.val(),
            lastExcludes = $excludes.val();
        //start
        $('.filter, .exclude')
            .stop()
            .on('propertychange keyup input paste', function(e) {
                // clear on Esc
                if (e.which == 27) {
                    $includes.val('');
                    $excludes.val('');
                }

                tagsGrid.resetActiveCell();
                $('.slick-cell').removeClass('selected');

                if ($includes.val() !== lastIncludes ||
                    $excludes.val() !== lastExcludes){
                    execFilter();
                }
            });
        franchise.change(function(e){
            execFilter();
        });

        var execFilter = function(){
            Slick.GlobalEditorLock.cancelCurrentEdit();
            setFilterArgs();
            tagsDataView.refresh();
        };

        filterContainsAll = function(val, search) {
            for (var i = search.length - 1; i >= 0; i--) {
                if (val.indexOf(search[i]) === -1) {
                    return false;
                }
            }

            return true;
        };

        filterContainsAny = function(val, search) {
            for (var i = search.length - 1; i >= 0; i--) {
                if (val.indexOf(search[i]) > -1) {
                    return true;
                }
            }

            return false;
        };

        var setFilterArgs = function() {
            var filterTextSplitFn = function(val) {
                    var thisVal = $('.exact').is(':checked') ? val : val.toLowerCase();
                    return $.unique($.grep(thisVal.split(' '), function(v) { return v !== ''; }));
                },
                includesVal = $includes.val(),
                excludesVal = $excludes.val(),
                fId = franchise.val(),
                includes = filterTextSplitFn(includesVal),
                excludes = filterTextSplitFn(excludesVal);

            tagsDataView.setFilterArgs({
                includes: includes,
                excludes: excludes,
                fId: fId,
                options: {
                    'tag_id': 1,
                    'description': 1
                }
            });

            lastIncludes = includesVal;
            lastExcludes = excludesVal;
        };

        var filterFn = function(item, args) {
            var exact = $('.exact');
            var match = false,
                tag_id = item.tag_id ? item.tag_id : "",
                description = exact.is(':checked') ? item.description : item.description.toLowerCase();

            if(args.fId){
                match = (args.fId == item.franchise_account_id);
                if (!match) return false;
            }

            match = (
                (args.options.tag_id && filterContainsAll(tag_id, args.includes)) ||
                    (args.options.description && filterContainsAll(description, args.includes))
                );
            if (!match) return false;

            match = !(
                (args.options.tag_id && filterContainsAny(tag_id, args.excludes)) ||
                    (args.options.description && filterContainsAny(description, args.excludes))
                );

            return match;
        };
        //endregion

        //region wire up model events to drive the grid
        tagsDataView.onRowCountChanged.subscribe(function (e, args) {
            tagsGrid.updateRowCount();
            tagsGrid.render();
        });

        tagsDataView.onRowsChanged.subscribe(function (e, args) {
            tagsGrid.invalidateRows(args.rows);
            tagsGrid.render();
        });
        //endregion

        tagsGrid.onClick.subscribe(function(e, args) {
            clickColumn(args.row, false);
            trussDetail.html("");
        });
        tagsGrid.onDblClick.subscribe(function(e, args) {
            clickColumn(args.row, true);
        });
        tagsGrid.onSelectedRowsChanged.subscribe(function(e, args) {
            var rowSelectedCount = tagsGrid.getSelectedRows().length;
            rowSelected.html(' Row' + (rowSelectedCount > 1 ? 's' : '') + ' Selected: ' + rowSelectedCount);
        });

        jQuery.fn.activeBtn = function(img, disabled){
            if(disabled){
                img = "disabled" + img;
                $(this)
                    .addClass('disabled')
                    .attr('disabled', 'disabled');
            }
            else{
                $(this)
                    .removeClass('disabled')
                    .removeAttr('disabled');
            }

            $(this).attr({
                'src': bu + "images/" + img + ".png"
            });
        };

        insertBtn.click(function(e){
            var thisUrl = bu + 'tagAdd';
            trussDetail
                .css('display','inline')
                .load(thisUrl);
        });
        removeBtn.click(function(e){
            var selectedJobId = [], selectedIndexes, selectedCount = 0, firstRef = "";

            selectedIndexes = tagsGrid.getSelectedRows();
            $.each(selectedIndexes, function (index, value) {
                if(selectedCount == 0){
                    firstRef = tagsDataView.getItem(value).id;
                    firstRef = firstRef > 2 ? firstRef - 2 : firstRef;
                }
                selectedJobId.push(tagsDataView.getItem(value).id);
                selectedCount ++;
            });

            var msg = 'You are about to delete <strong>' + selectedCount + '</strong> line';
            msg += selectedCount > 1 ? 's' : '';
            msg += '. OK?';
            $(this).newForm.formDeleteQuery({
                msg: msg,
                callBack: function(e){
                    $(this).newForm.formSizeChange({
                        toFind: '.queryTable'
                    });
                }
            });

            $('.yesBtn').unbind().on('click', function(e){
                $(this).newForm.forceClose({
                    callBack: function(e){
                        trussDetail.html('');
                        $(this).newForm.addLoadingForm();
                        $.post(
                            bu + 'tagDelete',
                            {
                                id: selectedJobId
                            },
                            function(data){
                                location.replace(bu + 'tag?id=' + firstRef);
                            }
                        );
                    }
                });
            });

            $('.noBtn').unbind().on('click', function(e){
                $(this).newForm.forceClose();
            });
        });

        var clickColumn = function(row, display){
            tagCurrentRow = row;
            var thisData = tagsDataView.getItem(tagCurrentRow);
            tagsGridActiveId = thisData.id;

            removeBtn.activeBtn('minusicon');
            if(tagsGridActiveId && display){
                var thisUrl = bu + 'tagEdit/' + tagsGridActiveId;
                trussDetail
                    .css('display','inline')
                    .load(thisUrl);
            }
            else{
                trussDetail.html('');
            }
        };

        //region for sorting a column - start
        tagsGrid.onSort.subscribe(function (e, args) {
            var col = args.sortCols;

            for (var i = 0, l = col.length; i < l; i++) {
                var field = col[i].sortCol.field;
                var sign = col[i].sortAsc ? 1 : -1;
                tagsGridSort = col[i].sortAsc ? 1 : -1;
                tagsGridSortCol = field;
                tagsDataView.sort(compare, col[i].sortAsc);
            }
        });

        function compare(a, b) {
            var x = a[tagsGridSortCol], y = b[tagsGridSortCol];
            return (x == y ? 0 : (x > y ? 1 : -1));
        }
        //endregion

        tagsDataView.beginUpdate();
        tagsDataView.setFilter(filterFn);
        setFilterArgs();
        tagsDataView.setItems(tagsGridJson);
        tagsDataView.endUpdate();
        //endregion

        if(tagsGridActiveId){
            var scrollToRef = tagsDataView.getRowById(tagsGridActiveId);

            var scrollToRowMiddleRow = scrollToRef - 11;
            scrollToRowMiddleRow = scrollToRowMiddleRow > 0 ? scrollToRowMiddleRow : scrollToRef;
            tagsGrid.scrollRowIntoView(scrollToRowMiddleRow, 1);
        }

        printBtn.click(function(e){
            var thisUrl = bu + 'tag?isPrint=1';
            if(lastIncludes){
                thisUrl += "&incld=" + lastIncludes;
            }
            if(lastExcludes){
                thisUrl += "&xcld=" + lastExcludes;
            }
            if(franchise.val()){
                thisUrl += "&fId=" + franchise.val();
            }

            var myWindow = window.open(
                thisUrl,
                'PDF',
                'width=842,height=595;toolbar=no,menubar=no,location=no,titlebar=no'
            );
        });

        var slickTitle = $('.auditGrid.slickTitle');
        var thisTitle = "";
        var hoverEle = '<span class="slickTitle"></span>';
        var slickCell = $('.slick-cell.text');
        slickCell
            .on({
                mouseenter: function(e) {
                    var thisId = $(this).parent('').parent('').parent('').parent('').attr('id');

                    var thisTitle = $(this).html();
                    if(thisTitle){
                        if(!$(this).parent('').hasClass('no_hover')){
                            $('body').after(hoverEle);
                            slickTitle = $('.slickTitle');
                            slickTitle.html(thisTitle);

                            var thisTop = $(this).offset().top + $(this).innerHeight();
                            var thisLeft = parseFloat($(this).offset().left);
                            slickTitle.css({
                                top: thisTop + 'px',
                                left: thisLeft + "px"
                            });
                        }
                    }
                },
                mouseleave: function(e) {
                    if(slickTitle.length != 0){
                        slickTitle.remove();
                    }
                }
            });
    });
</script>