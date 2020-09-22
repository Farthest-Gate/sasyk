var _POST_FV = null;
$(document).ready(function(e){
    set_post_formvalidation()
    setWysiwyg()
    if(isUpdate()){
        populateUpdate()
    }
});

function isUpdate(){
    if($("#update_post_id").val() != undefined && $("#update_post_id").val() != null){
        return true;
    }
    return false;
}

function populateUpdate(){
    _ATTRIBUTES = post.attributes;
    show_attributes
    $("input[name=title]").val(post.title);
    $('#content-wysiwyg').trumbowyg("html", post.content);
    $("#projects_select").val(getProjects(post.projects)).selectpicker("refresh");
    $("#categories_select").val(getCategories(post.categories)).selectpicker("refresh");
}
function getCategories(categories){
    var cats = [];
    for(var i = 0; i<categories.length; i++){
        cats.push(categories[i].category_id);
    }
    return cats;
}

function getProjects(projects){
    var projs = [];
    for(var i = 0; i<projects.length; i++){
        projs.push(projects[i].project_id);
    }
    return projs;
}

function setWysiwyg(){
//    $('#content-wysiwyg').trumbowyg({svgPath: trumbowyg_svgPath});
    $('#content-wysiwyg').trumbowyg({
        svgPath: trumbowyg_svgPath,
        btnsDef: {
            // Create a new dropdown
            image: {
                dropdown: ['insertImage', 'upload'],
                ico: 'insertImage'
            }
        },
        // Redefine the button pane
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['image'], // Our fresh created dropdown
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen'],
            ['upload'],
        ],
        plugins: {
            // Add imagur parameters to upload plugin for demo purposes
            upload: {
                serverPath: '/upload-image',
                fileFieldName: 'document',
                urlPropertyName: 'url',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }
        }
    });
    
}

function add_step(){
    
}


function set_post_formvalidation(){
    _POST_FV = FormValidation.formValidation(
        document.getElementById('create_post_form'), {
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter a title'
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
        title:$("input[name=title]").val(),
        content: $('#content-wysiwyg').trumbowyg("html"),
        attrs: JSON.stringify(_ATTRIBUTES),
        projects: $("#projects_select").val(),
        categories: $("#categories_select").val(),
        update_post_id: $("#update_post_id").val()
    };
    
    
  
    $.ajax({
        url: '/create-post',
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response);
            if(response.error == false){
                window.location.href = "/posts/"+response.post;
            }
        },
        error: function () {
            console.log("no success");
        }
    });
}
