<style>
    .logGrid{
        /*width: 350px;*/
        height: 450px;
        border: 1px solid #000000;
        font-size: 11px!important;
    }

    .slick-row:hover {
        background: #44a7cc!important;
    }
    .column-left{
        text-align: left;
    }
    .is_active{
        background: #ffbab5;
    }
    .is_free{
        background: #55ffa1;
    }
    .slick-row.active{
        background: #ff8f47!important;
    }
    .is_warning{
        background: #ffc5a4;
    }
    .is_alert{
        background: #ff6a6a;
    }
    .is_normal{
        background: #ffffc9;
    }

    #ourDetail, #emailDetail{
        display: none;
        width: 100%;
        border: 1px solid #000000;
        font-size: 12px;
    }
    #emailDetail{
        display: inline-block;
        margin-bottom: 5px;
    }
    .ourHeader{
        background: #000000;
        color: #ffffff;
        padding: 5px 10px;
    }
    .ourForm, .emailForm{
        width: 100%;
        padding: 3px 5px;
    }

    .closeBtn{
        float: right;
        color: #ffffff;
    }

    /*to fix bootstrap problem*/
    .logGrid, .logGrid div {
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
    }

    .recipient-form{
        /*max-height: 220px;
        overflow: scroll;
        overflow-x: hidden;*/
    }
    .btn-email-hide, .btn-remove, .btn-edit, .btn-hide, .closeBtn, .hideBtn, .glyphicon-calendar, .btn-delete{
        cursor: pointer;
    }
</style>
<div class="responsive">
    <div class="col-sm-8" style="padding-bottom: 10px">
            <div class="form-inline">
                <?php
                echo form_dropdown('update_type', $update_type, '', 'class="uType form-control input-sm" style="width: 100px;"');
                ?>
                <input type="text" name="filter" class="searchField form-control input-sm" placeholder="Search Here" style="width: 240px;" />
                <div class="form-group">
                    <div class='input-group date datetimepicker' style="width: 300px;">
                        <input type='text' name="date" class="required form-control input-sm" readonly/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
    </div>
<div class="row">
    <div class="col-sm-9" style="padding-bottom: 10px">
        <div class="logGrid grid responsive"></div>
    </div>
    <div class="col-sm-3">
            <div id="emailDetail"<?php echo !in_array($accountType, array(1,2,4)) ? ' style="display: none;"' : ''; ?>>
                <div class="ourHeader">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    Email Setting
                    <span class="btn-hide glyphicon glyphicon-chevron-up pull-right"></span>
                </div>
                <div class="emailForm collapse in">
                    <?php
                    $counter = 1;
                    echo form_open('', 'data-toggle="validator" role="form"');
                    echo '<div class="recipient-form">';
                    if (count($email_log) > 0) {
                        foreach ($email_log as $v) {
                            echo '<div class="recipient-div editInput' . $v->id . '">';
                                echo '<input type="checkbox" name="test_email[]" class="test_email" value="' . $v->id . '" style="width:5%;"/>&nbsp;';
                                echo
                                    '<strong>
                                        <span class="alias-hide">' . ($v->alias ? $v->alias : '') . '</span>
                                        <span class="counter-hide hidden">Recipient ' . $counter . '</span>
                                    </strong>: ';
                                echo '<div class="pull-right">';
                                    echo '<span class="btn-edit btn-click glyphicon glyphicon-pencil" data-click="0" id="' . $v->id . '"></span>';
                                    echo '<span class="btn-delete btn-click glyphicon glyphicon-remove" id="' . $v->id . '"></span>';
                                    echo '<span class="btn-email-hide glyphicon glyphicon-chevron-down"></span>';
                                echo '</div>';
                                echo '<div class="recipient-div-input collapse">';
                                    ?>
                                    <input type="hidden" name="id_edit[<?php echo $counter; ?>]" class="id_edit"
                                           value="<?php echo $v->id; ?>" disabled/>
                                    <div class="form-inline" style="width: 95%;margin-bottom: 10px!important;">
                                        <div class="form-group">
                                            <input type="text" name="alias_edit[<?php echo $counter; ?>]"
                                                   value="<?php echo $v->alias; ?>" class="input-alias alias_edit form-control input-sm"
                                                   autocomplete="off" placeholder="Alias" disabled required/>
                                        </div>
                                    </div>
                                    <div class="input-group" style="width: 95%;margin-bottom: 10px!important;">
                                        <input type="email" name="email_edit[<?php echo $counter; ?>]"
                                               value="<?php echo $v->email; ?>" class="email_edit form-control input-sm"
                                               autocomplete="off" placeholder="Email" data-error="Email address is invalid"
                                               disabled required/>

                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <?php
                                echo '</div>';
                                echo '<hr style="margin: 10px!important;"/>';
                            echo '</div>';
                            $counter++;
                        }
                    }
                    echo '</div>';
                    echo (count($email_log) > 0) ?
                        '<span class="input-group pull-left" style="width: 90px;font-size: 15px;">
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-sm test-recipient" type="button" disabled>Test Send</button>
                            </span>
                            <span class="input-group-addon sendDate">
                                <input type="hidden" name="sendDate" class="sendDateInput" value="' . date('Y-m-d') . '" />
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </span>'
                        : '';
                    ?>
                    <div class="form-group recipient-area" style="float: right;margin: 5px 0 5px!important;">
                        <button type="submit" name="submit" class="submit-recipient hidden btn btn-sm btn-primary">Submit</button>
                        <button type="button" class="btn btn-primary btn-sm add-recipient">Add</button>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
            <div id="ourDetail">
                <div class="ourHeader">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                    Change Log
                    <div class="pull-right">
                        <span class="hideBtn glyphicon glyphicon-chevron-up"></span>
                        <span class="closeBtn glyphicon glyphicon-remove"></span>
                    </div>
                </div>
                <div class="ourForm collapse in"></div>
            </div>
    </div>
    </div>
</div>
<script src="<?php echo base_url() . "plugins/js/bootstrapValidator.js"; ?>"></script>
<script src="<?php echo base_url() . "plugins/js/bootstrap-select.js"; ?>"></script>
<script src="<?php echo base_url() . "plugins/js/jquery.growl.js" ; ?>"></script>
<link href="<?php echo base_url() . "plugins/css/jquery.growl.css"; ?>" />
<script src="<?php echo base_url() . "plugins/js/bootstrap-waitingfor.js"; ?>"></script>
<script>
    $(document).ready(function(){
        function logCompareSort(a, b) {
            var x = a[logGridSortCol], y = b[logGridSortCol];
            return (x == y ? 0 : (x > y ? 1 : -1));
        }

        //region Variables
        var logGrid, logData = [], logDataView,
            logGridSortCol = "date",
            logGridSort = true,
            logId,
            logGridColumns = [
                {id: "date", name: "Date", field: "date", width: 30, sortable: true},
                {id: "type", name: "Type", field: "type", width: 20, sortable: true},
                {id: "name", name: "Name", field: "name", width: 50, sortable: true},
                {id: "job_num", name: "Job #", field: "job_num", width: 30, sortable: true},
                {id: "ref", name: "Ref", field: "ref", width: 50, sortable: true},
                {id: "client", name: "Client", field: "client", width: 50, sortable: true},
                {id: "job_name", name: "Job Name", field: "job_name", width: 80, cssClass: "column-left", sortable: true}
            ],
            logCurrentRow,
            logGridActiveId = "",
            logSetFilterArgs,

            gridOptions = {
                editable: true,
                enableCellNavigation: true,
                enableColumnReorder: false,
                multiColumnSort: true,
                forceFitColumns: true 
            },
            filterContainsAll, filterMatchAll, filterContainsAny,
            lastFilter;
        //endregion
        //region Filter Functions
        filterContainsAll = function(val, search) {
            if(val){
                return val.indexOf(search) !== -1;
            }
            else{
                return false;
            }
        };
        filterMatchAll = function(val, search) {
            var matchCount = 0;
            for (var i = search.length - 1; i >= 0; i--) {
                if (val.indexOf(search[i]) > -1) {
                    matchCount += 1;
                }
            }

            return (matchCount == search.length);
        };
        filterContainsAny = function(val, search) {
            for (var i = search.length - 1; i >= 0; i--) {
                if (val.indexOf(search[i]) > -1) {
                    return true;
                }
            }

            return false;
        };
        //endregion

        logData = <?php echo $logs ? $logs : '[]'; ?>;
        logExecutePlease();

        //region Edit Log
        function logExecutePlease(){
            logDataView = new Slick.Data.DataView({ inlineFilters: true });
            logGrid = new Slick.Grid(".logGrid", logDataView, logGridColumns, gridOptions);
            logGrid.setSortColumn(logGridSortCol, logGridSort);
            logGrid.setSelectionModel(new Slick.RowSelectionModel());

            //region Filter Area
            var uType = $('.uType');
            var searchField = $('.searchField');
            var date=  $('.date');
            var fId = $('.fId');
            $('.uType, .fId').change(function(e){
                execFilter();
            });
            searchField
                .stop()
                .on('propertychange keyup input paste', function(e) {
                    // clear on Esc
                    if (e.which == 27) {
                        searchField.val('');
                    }

                    if (searchField.val() !== lastFilter){
                        execFilter();
                    }
                });

            date
                .datepicker({
                    format: 'd/m/yyyy',
                    multidate: true
                })
                .on("changeDate",function (e) {
                    execFilter();
                });

            var execFilter = function(){
                Slick.GlobalEditorLock.cancelCurrentEdit();
                setFilterArgs();
                logDataView.refresh();
            };

            var setFilterArgs = function() {
                var filterTextSplitFn = function(val) {
                        var thisVal = val.toLowerCase();
                        return $.unique($.grep(thisVal.split(' '), function(v) { return v !== ''; }));
                    },
                    searchVal = searchField.val(),
                    search = filterTextSplitFn(searchVal),
                    formatDates = function(val) {
                        return $.map(val, function( val, i ) {
                            var d = new Date(val);
                            return d.getDate() + "/" + (d.getMonth() + 1) + '/' + d.getFullYear();
                        });
                    },
                    dateAr = formatDates(date.datepicker('getDates'));
                logDataView.setFilterArgs({
                    uType: uType.val(),
                    search: search,
                    date: dateAr,
                    fId: fId.val()
                });

                lastFilter = searchVal;
            };

            var filterFn = function(item, args) {
                var match = args.uType ? args.uType == item.change_type : true;

                /*match = match && args.search && (
                (filterMatchAll(item.name.toString().toLowerCase(), args.search)) ||
                (filterMatchAll(item.job_num.toString().toLowerCase(), args.search)) ||
                (filterMatchAll(item.ref.toString().toLowerCase(), args.search)) ||
                (filterMatchAll(item.client.toString().toLowerCase(), args.search)) ||
                (filterMatchAll(item.job_name.toString().toLowerCase(), args.search))
                );*/

                match = match && args.date.length > 0 ? $.inArray(item.date_only, args.date) != -1 : match;

                match = match && args.fId ? args.fId == item.fId : match;

                return match;
            };
            //endregion

            logGrid.onClick.subscribe(function(e, args) {
                logCurrentRow = args.row;
                var thisData = logDataView.getItem(logCurrentRow);
                logGridActiveId = thisData.id;

                var ourForm = $('.ourForm');
                var thisDisplay = 'none';
                var thisContent = '';
                if(thisData.changes){
                    thisDisplay = 'inline-block';
                    thisContent = thisData.changes.join('');
                }
                ourForm.html(thisContent);
                $('#ourDetail').css({ display: thisDisplay});

                if(hide.hasClass('glyphicon-chevron-up')){
                    emailForm.collapse('hide');
                    hide
                        .removeClass('glyphicon-chevron-up')
                        .addClass('glyphicon-chevron-down');
                }

                if(!hideBtn.hasClass('glyphicon-chevron-up')){
                    ourForm.collapse('show');
                    hideBtn
                        .removeClass('glyphicon-chevron-down')
                        .addClass('glyphicon-chevron-up');
                }
            });

            //start
            // wire up model events to drive the grid
            logDataView.onRowCountChanged.subscribe(function (e, args) {
                logGrid.updateRowCount();
                logGrid.render();
            });

            logDataView.onRowsChanged.subscribe(function (e, args) {
                logGrid.invalidateRows(args.rows);
                logGrid.render();
            });
            //end

            //for sorting a column - start
            logGrid.onSort.subscribe(function (e, args) {
                var col = args.sortCols;

                for (var i = 0, l = col.length; i < l; i++) {
                    logGridSort = col[i].sortAsc;
                    logGridSortCol = col[i].sortCol.field;
                    logDataView.sort(logCompareSort, col[i].sortAsc);
                }
            });
            //for sorting a column - end

            logDataView.beginUpdate();
            logDataView.setFilter(filterFn);
            setFilterArgs();
            logDataView.setItems(logData);
            logDataView.endUpdate();
        }
        //endregion

        $('.closeBtn').click(function(e){
            e.preventDefault();

            $('#ourDetail').css({
                display: 'none'
            });
        });

        var $counter = <?php echo $counter; ?>;
        var submit = $('.submit-recipient');
        var add = $('.add-recipient');
        var edit = $('.btn-edit');
        var hide = $('.btn-hide');
        var deleteBtn = $('.btn-delete');
        var hideBtn = $('.hideBtn');
        var emailDetail = $('#emailDetail');
        var emailForm = $('.emailForm');
        var test_email = $('.test_email');
        $('.fDp').selectpicker({
            width: '140px'
        });
        add.click(function(e){
            var arEle =
                '<div class="form-inline" style="width: 95%;margin-bottom: 10px!important;">' +
                    '<div class="form-group">' +
                        '<input type="text" name="alias[' + $counter + ']" class="input-alias form-control input-sm" autocomplete="off" placeholder="Alias" required/>' +
                    '</div>' +
                '</div>' +
                '<div class="input-group" style="width: 95%;margin-bottom: 10px!important;">' +
                    '<input type="email" name="email[' + $counter + ']" class="form-control input-sm" autocomplete="off" placeholder="Email" data-error="Email address is invalid" required/>' +
                    '<div class="help-block with-errors"></div>' +
                '</div>';
            var thisEle =
                '<div class="recipient-div">' +
                    '<span style="width: 15px;height: 15px;display: inline-block;">&nbsp;</span>&nbsp;' +
                    '<strong>' +
                        '<span class="alias-hide"></span>' +
                        '<span class="counter-hide">Recipient ' + $counter + '</span>' +
                    '</strong>:' +
                    '<div class="pull-right">' +
                        '<span class="btn-remove btn-click glyphicon glyphicon-remove" data-click="1"></span>' +
                        '<span class="btn-email-hide glyphicon glyphicon-chevron-up"></span>' +
                    '</div>' +
                    '<div class="recipient-div-input collapse in">' +
                        arEle +
                    '</div>' +
                    '<hr style="margin: 10px!important;"/>' +
                '</div>';
            var rForm = $('.recipient-form');
            rForm
                .append(thisEle)
                .find('.btn-remove')
                .stop()
                .on('click', function(e){
                    $(this).parent().parent().remove();
                    if($('.btn-click[data-click="1"]').length == 0){
                        submit.addClass('hidden');
                    }
                });
            rForm
                .find('.btn-email-hide')
                .stop()
                .on('click', function(e){
                    emailHideTrigger($(this));
                });
            $('.fDp').selectpicker({
                width: '140px'
            });
            $counter ++;
            submit.removeClass('hidden');
        });
        edit.click(function(e){
            var thisId = this.id;
            var thisEle = $('.editInput' + thisId);
            var thisEdit = $(this);
            if($(this).attr('data-click') == 0){
                thisEle.find('.id_edit').removeAttr('disabled');
                thisEle.find('.alias_edit').removeAttr('disabled');
                thisEle.find('.franchise_edit').removeAttr('disabled');
                thisEle.find('.email_edit').removeAttr('disabled');
                submit.removeClass('hidden');
                thisEdit.attr('data-click', "1");
                thisEdit
                    .removeClass('glyphicon-pencil')
                    .addClass('glyphicon-remove');
            }
            else{
                thisEle.find('.id_edit').attr('disabled', true);
                thisEle.find('.alias_edit').attr('disabled', true);
                thisEle.find('.franchise_edit').attr('disabled', true);
                thisEle.find('.email_edit').attr('disabled', true);
                thisEdit.attr('data-click', "0");
                thisEdit
                    .removeClass('glyphicon-remove')
                    .addClass('glyphicon-pencil');
                if($('.btn-click[data-click="1"]').length == 0){
                    submit.addClass('hidden');
                }
            }
            thisEle.find('.franchise_edit')
                .selectpicker({
                    width: '140px'
                })
                .selectpicker('val', thisEle.find('.franchise_edit').val())
                .prop('disabled', $(this).attr('data-click') == 0)
                .selectpicker('refresh');
        });
        hide.click(function(e){
            if(hide.hasClass('glyphicon-chevron-up')){
                emailForm.collapse('hide');
                hide
                    .removeClass('glyphicon-chevron-up')
                    .addClass('glyphicon-chevron-down');
            }
            else{
                emailForm.collapse('show');
                hide
                    .removeClass('glyphicon-chevron-down')
                    .addClass('glyphicon-chevron-up');
            }
        });
        hideBtn.click(function(e){
            if(hideBtn.hasClass('glyphicon-chevron-up')){
                $('.ourForm').collapse('hide');
                hideBtn
                    .removeClass('glyphicon-chevron-up')
                    .addClass('glyphicon-chevron-down');
            }
            else{
                $('.ourForm').collapse('show');
                hideBtn
                    .removeClass('glyphicon-chevron-down')
                    .addClass('glyphicon-chevron-up');
            }
        });
        deleteBtn.click(function(e){
            var thisId = this.id;
            $('.deleteModal')
                .modal('show')
                .on('shown.bs.modal', function (e) {
                    $('.yesDeleteBtn')
                        .stop()
                        .on('click', function(e){
                            waitingDialog.show('Please wait...');
                            $.post(
                                bu + 'jobChangeLog',
                                {
                                    del: 1,
                                    id: thisId
                                },
                                function(e){
                                    location.reload();
                                }
                            );

                        });
                });
        });

        var sendDate = $('.sendDate');
        var sendDateInput = $('.sendDateInput');
        var test = $('.test-recipient');
        sendDate
            .datepicker({
                format: 'yyyy-m-d'
            })
            .on('changeDate', function(e){
                var dStr = new Date(e.date);
                var m = dStr.getMonth() + 1;
                m = m < 10 ? "0" + m : m;
                var d = dStr.getDate();
                d = d < 10 ? "0" + d : d;
                sendDateInput.val(dStr.getFullYear() + '-' + m + '-' + d);
            });
        test_email.click(function(e){
            if($('.test_email:checked').length == 0){
                test.attr('disabled', true);
            }
            else{
                test.removeAttr('disabled');
            }
        });
        test.click(function(e){
            var thisEmailIds = $.map($('.test_email:checked'), function(e){
                return e.value;
            });
            $(this).attr('disabled', true);
            $.post(
                bu + 'jobChangeLogCron?date=' + sendDateInput.val(),
                {
                    id: test_email.length == thisEmailIds.length ? '' : thisEmailIds
                },
                function(e){
                    $.growl.notice({
                        duration: 20000,
                        size: "large",
                        title: "",
                        message: 'Test email sent.'
                    });
                    test.removeAttr('disabled');
                }
            );
        });

        var emailHide = $('.btn-email-hide');
        emailHide.click(function(e){
            emailHideTrigger($(this));
        });

        function emailHideTrigger(el){
            var thisDiv = el.parent().parent().find('.recipient-div-input');
            var thisAlias = el.parent().parent().find('.alias-hide');
            var thisCounter = el.parent().parent().find('.counter-hide');
            var thisAliasVal = thisDiv.find('.input-alias').val();
            if(el.hasClass('glyphicon-chevron-up')){
                thisDiv.collapse('hide');
                el
                    .removeClass('glyphicon-chevron-up')
                    .addClass('glyphicon-chevron-down');
                if(thisAliasVal){
                    thisAlias.html(thisAliasVal);
                    thisCounter.addClass('hidden');
                }
            }
            else{
                thisDiv.collapse('show');
                el
                    .removeClass('glyphicon-chevron-down')
                    .addClass('glyphicon-chevron-up');
                thisAlias.html('');
                thisCounter.removeClass('hidden');
            }
        }
    });
</script>