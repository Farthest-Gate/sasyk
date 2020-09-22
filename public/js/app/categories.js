var _CATEGORY_TABLE = null;
var _CATEGORY_FV = null;

$(document).ready(function(){
    
    set_icon_picker();
    set_category_table(categories)
    set_formvalidation();

    
    $(".category-row").on("click", function(e){
        var category_id = $(this).find(".row_category_id").val();
        show_update_category(category_id)
        $("#category-modal").modal("show");
    })
    
    $("#category-modal").on('hidden.bs.modal', function () {
        clear_category_form()
    });
    
    
})

function show_update_category(category_id){
    var category = get_category(category_id);
    $("#category_id").val(category_id);
    $("input[name=name]").val(category.name);
    $("textarea[name=description]").val(category.description);
    icon_selected("<i class='"+category.icon+"'>");
    $("#category-modal .modal-title").html('Update Category');

}

function get_category(id){
    for(var i = 0; i < categories.length; i++){
        if(categories[i].category_id == id){
            return categories[i];
        }
    }
}

function clear_category_form(){
    $("input[name=name]").val(''),
    $("textarea[name=description]").val(''),
    icon_selected('');
    $(".icon-individual").removeClass("text-primary");
    
    if(_CATEGORY_FV != null){
        _CATEGORY_FV.resetField('name', true)
    }
    $("#category-modal .modal-title").html('Create New Category');
    $("#category_id").val("");
}

function set_formvalidation(){
    _CATEGORY_FV = FormValidation.formValidation(
        document.getElementById('category-form'), {
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter a name'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                })
            }
        }
    ).on('core.form.valid', function () {
        submit_category_form()
    });
}

function submit_category_form(){
    var data = {
        name:$("input[name=name]").val(),
        description:$("textarea[name=description]").val(),
        icon:$(".icon-selected i").attr("class")
    };
    if($("#category_id").val() != null && $("#category_id").val() != ""){
        data.category_id = $("#category_id").val();
    }
    $.ajax({
        url: '/categories',
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response);
            if(response.error == false){
                location.reload();
            }
        },
        error: function () {
            console.log("no success");
        }
    });
}




function set_category_table(data){
    
    columns = [
        {
            data: "name",
            title: "Name"
        },
        {
            data: "description",
            title: "Description",
            orderable: false,
            render: function (data, type, row) {
                if(data == null){
                    return "No Description"
                }
                if(data.length > 100){
                    return data.substring(0, 97) + "...";
                }
                return data;
            }
        },
        {
            data: "updated_by_name",
            title: "Updated By"
        },
        {
            title: "Updated",
            data: "updated_at",
            render: function (data, type, row) {

                if(type=="display"){
                    var html = "<input type='hidden' class='row_category_id' value='"+row.category_id+"'>";
                    var date = moment(data).fromNow()
                    return date + html;
                }
                return data;
            }
        }
    ];

    if(_CATEGORY_TABLE != null){
        _CATEGORY_TABLE.destroy();
    }
    _CATEGORY_TABLE = $("#categories-table").DataTable({
        responsive: true,
        paging: true,
        info: false,
        order: [[ 0, "asc" ]],
        language: {
            emptyTable: "No categories added"
        },
        data: data,
        columns: columns,
        'createdRow': function( row, data, dataIndex ) {
            $(row).addClass('clickable category-row');
        }
    });
}