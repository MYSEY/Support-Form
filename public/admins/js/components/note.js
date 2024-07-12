$(document).ready(function() {
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    showNote(id)
   $("#btn-add-note").click(function(){
        $(".form-noted").toggle();
        $("#ticket-textarea").addClass("is-valid");
        $("#ticket-textarea").removeClass("is-invalid");
    });

    $("#btn-save-note").click(function() {
        if ($("#ticket-textarea").val() == null || $("#ticket-textarea").val() == "") {
            $("#ticket-textarea").addClass("is-invalid");
            $("#ticket-textarea").removeClass("is-valid");
            toastr.error("Please input text!");
        }else{
            $.ajax({
                type: "POST",
                url: "{{url('admin/note/save')}}",
                data: {
                    "_token":                   "{{ csrf_token() }}",
                    ticket_id:                  $("#e_id_ticket").val(),
                    message:                    $("#ticket-textarea").val(),
                    // attachments:             $("#attachments").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status == "error") {
                        toastr.error(response.message);
                    }else{
                        toastr.success('Data create successfully.');
                        var url = "{{ URL('admin/ticket/detail/') }}/" + id;
                        window.location.replace(url); 
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error(error);
                }
            });
        }
    });
});
function nl2br(str) {
    return str.replace(/\n/g, '<br>');
}
function showNote(ticket_id){
    $.ajax({
        type: "GET",
        url: "{{url('admin/note/show')}}",
        data: {
            ticket_id:ticket_id
        },
        dataType: "JSON",
        success: function (response) {
            let datas = response.datas;
            console.log("response: ",response.datas);
            let text = "";
            if (datas.length > 0) {
                datas.forEach(function(value, index) {
                    var message = nl2br(value.message);
                    let created_at = moment(value.created_at).format('D-MMM-YYYY h:mm');
                    text +='<div class="panel-tag">'+
                            '<div>'+
                                '<a style="float: right;" href="javascript:void(0);" data-toggle="tooltip" title="Delete" class="btn btn-outline-primary btn-sm btn-icon waves-effect waves-themed">'+
                                    '<i class="fal fa-trash-alt"></i>'+
                                '</a>'+
                                '<a style="float: right;" href="javascript:void(0);" data-toggle="tooltip" title="Edit" class="mr-1 btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed">'+
                                    '<i class="fal fa-edit"></i>'+
                                '</a>'+
                                '<p class="card-text">Note by: <strong>'+value.created_by.name+'</strong> , '+created_at+'</p>'+
                            '</div>'+
                            '<p class="card-text mt-1">'+message+'</p>'+
                        '</div>';
                });
                $("#show-notes").html(text);
            }
        }
    });
}