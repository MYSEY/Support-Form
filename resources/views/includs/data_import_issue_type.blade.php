<script type="text/javascript">
    $(function() {

        $("#result_file_e").on("change", function(){
            $(".thanLess-e").hide();
            $("#thanLess-e").text("");
        });

        $(".upload_file_data").on("click", function() {
            if ($('#result_file_e').val() == "") {
                $("#thanLess-e").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css(
                    "color", "red");
                $(".thanLess-e").show();
                return false;
            }
            var file_data = $('#result_file_e').prop('files')[0];
            var fileName = file_data['name'];
            var form_data = new FormData();
            var fileExtension = fileName.split('.').pop();
            var fileSize = file_data['size'];
            form_data.append('file', file_data);
            form_data.append('_token', "{{ csrf_token() }}");
            if (fileExtension == "xls" || fileExtension == "xlsx" || fileExtension == "csv" && fileSize < 1048576) {
                $(".upload_file_data").prop('disabled', true);
                $(".btn-text-submit").hide();
                $("#e-btn-loading").css('display', 'block');

                $("#importModal").modal("show");
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/issue-type/import') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            $("#thanLess-e").text("Please check data for imports. Because some data is duplicated").css("color", "red");
                            $(".thanLess-e").show();
                            $(".btn-text-submit").show();
                            $("#e-btn-loading").css('display', 'none');
                            return false;
                        }
                        if (response == 1) {
                            $("#importModal").modal("hide");
                            toastr.success('Data has been save success');
                            window.location.replace("{{ URL('/admin/issue-type') }}");
                        }
                        if (response == 2) {
                            $("#importModal").modal("hide");
                            $("#thanLess-e").text("Data duplicate").css("color", "red");
                            $(".thanLess-e").show();
                        }
                        if (response == 0) {
                            $("#importModal").modal("show");
                            response == 0;
                            $("#thanLess-e").text(
                                "@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')"
                                ).css("color", "red");
                            $(".thanLess-e").show();
                        }
                    }
                });
            }else{
                $("#thanLess-e").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css(
                    "color", "red");
                $(".thanLess-e").show();
            }
        });
    });
</script>