var _POST_TABLE = null;
$(document).ready(function(e){
    
    set_post_table(posts);
    $("body").on("click", ".post-row", function(e){
        var post_id = $(this).find(".row_post_id").val(); 
        window.location.href = "posts/"+post_id;
    })
})

function set_post_table(data){
    
    columns = [
        {
            data: "title",
            title: "title"
        },
        {
            data: "projects",
            title: "Projects",
            render: function (data, type, row) {
                var html = "";
                for(var i = 0; i < data.length; i++){
                    html += "<a class='btn btn-link' href='projects/"+data[i].project_id+"'>"+data[i].name+"</a><br>";
                }                
                return html;
            }
        },
        {
            data: "categories",
            title: "Categories",
            render: function (data, type, row) {
                var html = "";
                for(var i = 0; i < data.length; i++){
                    html += "<a class='btn btn-link' href='categories/"+data[i].category_id+"'>"+data[i].name+"</a><br>";
                }                
                return html;
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
                    var html = "<input type='hidden' class='row_post_id' value='"+row.post_id+"'>";
                    var date = moment(data).fromNow()
                    return date + html;
                }
                return data;
            }
        }
    ];

    if(_POST_TABLE != null){
        _POST_TABLE.destroy();
    }
    _POST_TABLE = $("#posts-table").DataTable({
        responsive: true,
        paging: true,
        info: false,
        order: [[ 0, "asc" ]],
        language: {
            emptyTable: "No posts added"
        },
        data: data,
        columns: columns,
        'createdRow': function( row, data, dataIndex ) {
            $(row).addClass('clickable post-row');
        }
    });
}