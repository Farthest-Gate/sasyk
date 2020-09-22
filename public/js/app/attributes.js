var _ATTRIBUTES = {};

$(document).ready(function(e){
    $(".add-attribute-row").hide();
    $(".add_attribute_button").on("click", function(e){
        add_attribute();
    })
    
    $(".attribute_confirm").on("click", function(e){
        confirm_attribute();
    });
    
    $(".attribute_cancel").on("click", function(e){
        cancel_attribute();
    });
    
    $(".attribute_name").on("keyup change", function(e){
        $(this).val($(this).val().replace(" ", "_"));
    })
    
    $("body").on("click", ".attribute_remove", function(e){
        remove_attribute($(this).attr("key"));
    })
    
    
})

function add_attribute(){
    $(".add-attribute-row").show(); 
    $(".add_attribute_button").hide();
}

function remove_attribute(key){
    delete _ATTRIBUTES[key];
    show_attributes()
}

function reset_attribute(){
    $(".attribute_name").css("border-color", "#ced4da");
    $(".attribute_value").css("border-color", "#ced4da");
    $(".attribute_name").val("");
    $(".attribute_value").val("");
    $(".add-attribute-row").hide();
    $(".add_attribute_button").show();
    show_attributes();
}

function cancel_attribute(){
    _ATTRIBUTES[$(".attribute_name").val()] = $(".attribute_value").val()
    reset_attribute()
}

function confirm_attribute(){
    var valid = true;
    
    var name = $(".attribute_name").val();
    if(name == null || name.length == 0){
        $(".attribute_name").css("border-color", "#e3342f");
        valid = false;
    }
    var value = $(".attribute_value").val();
    if(value == null || value.length == 0){
        $(".attribute_value").css("border-color", "#e3342f");
        valid = false;
    }
        
    if(!valid){
        return;
    }
    
    _ATTRIBUTES[$(".attribute_name").val()] = $(".attribute_value").val()
    reset_attribute();
}

function show_attributes(){
    var html = "";
    
    for(var k in _ATTRIBUTES){
        html += "<div class='row attribute_row'>";
        html += "<div class='col-4'>"+k+"</div>";
        html += "<div class='col-6'>"+_ATTRIBUTES[k]+"</div>";
        html += "<div class='col-1'></div>";
        html += "<div class='col-1'><i class='fas fa-times-circle text-danger clickable attribute_remove' key='"+k+"'></i></div>";
        html += "</div>";
    }
       
    $(".attributes_cont").html(html);
}