var _PROJECT_TABLE = null;
var _PROJECT_FV = null;

$(document).ready(function(){
    
    set_icon_picker();
    set_project_table(projects)
    set_formvalidation();
    show_attributes();
    
    
    
    $(".project-row").on("click", function(e){
        var project_id = $(this).find(".row_project_id").val();
        show_update_project(project_id)
        $("#project-modal").modal("show");
    })
    
    $("#project-modal").on('hidden.bs.modal', function (e) {
        clear_project_form();
    });
    
   
})










function set_project_attributes(attributes){
    var attrs = {};
    for(var i = 0; i<attributes.length; i++){
        attrs[attributes[i].attr_name] = attributes[i].attr_value;
    }
    return attrs;
}

function show_update_project(project_id){
    $("#project_id").val(project_id);
    var project = get_project(project_id);
    $("input[name=name]").val(project.name);
    $("textarea[name=description]").val(project.description);
    icon_selected("<i class='"+project.icon+"'>");
    $("#project-modal .modal-title").html('Update Project');
    _ATTRIBUTES = set_project_attributes(project.project_attributes);
    reset_attribute();
}



function get_project(id){
    for(var i = 0; i < projects.length; i++){
        if(projects[i].project_id == id){
            return projects[i];
        }
    }
}

function clear_project_form(){
    $("input[name=name]").val(''),
    $("textarea[name=description]").val(''),
    icon_selected('');
    $(".icon-individual").removeClass("text-primary");
    
    if(_PROJECT_FV != null){
        _PROJECT_FV.resetField('name', true)
    }
    $("#project-modal .modal-title").html('Create New Project');
    _ATTRIBUTES = {}
    reset_attribute();
    $("#project_id").val()
}

function set_formvalidation(){
    _PROJECT_FV = FormValidation.formValidation(
        document.getElementById('project-form'), {
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter a name'
                        }
                    }
                },

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
        submit_project_form()
    });
}

function submit_project_form(){
    
    
    var data = {
        name:$("input[name=name]").val(),
        description:$("textarea[name=description]").val(),
        icon:$(".icon-selected i").attr("class"),
        attrs: _ATTRIBUTES
    };
    if($("#project_id").val() != null && $("#project_id").val() != ""){
        data.category_id = $("#project_id").val();
    }
    $.ajax({
        url: '/projects',
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




function set_project_table(data){
    
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
                    var html = "<input type='hidden' class='row_project_id' value='"+row.project_id+"'>";
                    var date = moment(data).fromNow()
                    return date + html;
                }
                return data;
            }
        }
    ];

    if(_PROJECT_TABLE != null){
        _PROJECT_TABLE.destroy();
    }
    _PROJECT_TABLE = $("#projects-table").DataTable({
        responsive: true,
        paging: true,
        info: false,
        order: [[ 0, "asc" ]],
        language: {
            emptyTable: "No projects added"
        },
        data: data,
        columns: columns,
        'createdRow': function( row, data, dataIndex ) {
            $(row).addClass('clickable project-row');
        }
    });
}
