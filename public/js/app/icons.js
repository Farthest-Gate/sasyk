$(document).ready(function(){
    
    set_icon_picker();
    $(".icon-search").on("keyup change", function(e){
        search_icons($(this).val())
    })
    
    $(".icon-individual").on("click", function(e){
        icon_selected($(this).html());
        $(".icon-individual").removeClass("text-primary")
        $(this).addClass("text-primary");
    })
});


function icon_selected(i){
    
    
    $(".icon-selected").html(i);
}

function set_icon_picker(){
    var html = "";
    
    for(var i = 0; i < icons.length; i++){
        html += "<option><i class='"+icons[i]+"'></i></option>"
    }
//    $(".icon-picker").selectpicker().html(html).selectpicker("refresh");
}

function search_icons(text){
    $(".icon-picker i").each(function(e){
        if(text == null || text == null){
            $(this).parent().show()
        } else if($(this).attr('class').includes(text)){
            $(this).parent().show()
                  
        } else {
            $(this).parent().hide()
        }
    })
    
}