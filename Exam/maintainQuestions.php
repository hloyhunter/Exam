<!DOCTYPE html>
<html>
<head>
    <title>題目維護</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/sweetalert.css"/>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert.min.js"></script>

    <style>
        table td:first-child {
            text-align: center;
            width: 150px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#AddModal">新增題目
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table id="QuestionTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>題目敘述</th>
                    <th>分數</th>
                </tr>
                </thead>
                <tbody id="QTBody"></tbody>
            </table>
        </div>
    </div>
</div>

<!--Add Modal-->
<div id="AddModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">新增題目</h4>
            </div>
            <div class="modal-body">
                <form id="AddForm">
                    <div class="form-group form-inline">
                        <label for="QuestionScore">分數：</label>
                        <input type="text" class="form-control" id="QuestionScore"
                               style="width: 50px; text-align: right"
                               maxlength="3">
                        <label>分</label>
                    </div>
                    <div class="form-group">
                        <label for="QuestionText">題目敘述：</label>
                        <textarea class="form-control" rows="5" id="QuestionText"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" id="btnAddConfirm" class="btn btn-primary" value="確認"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>

    </div>
</div>
<!--Add Modal End-->

<script>
    function BindRowDelete() {
        $('.Delete').click(function () {
            var QID = $(this).find('+.QID').val();
            swal({
                    title: '確定要刪除此題目？',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                    closeOnConfirm: false
                },
                function () {
                    $.ajax({
                        url: 'maintainQuestionsController.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            Job: 'Delete',
                            QuestionID: QID,
                            QuestionText: '',
                            QuestionScore: ''
                        },
                        success: function (res) {
                            if (res == 1) {
                                swal('刪除成功', '', 'success');
                            }
                            else {
                                swal('刪除失敗', '', 'error');
                            }
                        },
                        error: function (xhr, status, error) {
                            swal(status, error, 'error');
                        },
                        complete: function () {
                            LoadTable();
                        }
                    });
                });
        });
    }

    function BindRowModify() {
        $('.Modify').click(function () {
            var QID = $(this).find('++.QID').val();

        });
    }

    function LoadTable() {
        $.ajax({
            url: 'maintainQuestionsController.php',
            type: 'POST',
            dataType: 'html',
            data: {
                Job: 'Read',
                QuestionID: '',
                QuestionText: '',
                QuestionScore: ''
            },
            success: function (res) {
                $('#QTBody').html(res);
                BindRowDelete();
                BindRowModify();
            },
            error: function (xhr, status, error) {
                swal(status, error, 'error');
            }
        });
    }

    $(function () {

        LoadTable();

        $('#btnAddConfirm').click(function () {
            $.ajax({
                url: 'maintainQuestionsController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    Job: 'Add',
                    QuestionID: '',
                    QuestionText: $('#QuestionText').val(),
                    QuestionScore: $('#QuestionScore').val()
                },
                success: function (res) {
                    if (res == 1) {
                        swal('新增成功', '', 'success');
                    }
                    else {
                        swal('新增失敗', '', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    swal(status, error, 'error');
                },
                complete: function () {
                    LoadTable();
                    $('#AddModal').modal('hide');
                }
            });
        });

        $('#AddModal').on('hidden.bs.modal', function () {
            $('#AddForm')[0].reset();
        });
    });
</script>
</body>
</html>