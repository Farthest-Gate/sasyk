<div id="project-modal" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="project-form">
                @csrf
                <input type='hidden' id='project_id'>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class= "col-12 col-md-3">
                            <b><label for="name">Name</label></b>
                        </div>
                        <div class= "col-12 col-md-9">
                            <input type="text" class="form-control" name="name"> 
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <div class= "col-12 col-md-3">
                            <b><label for="description">Project Attributes</label></b>
                        </div>
                        <div class= "col-12 col-md-9">
                            @include("templates.attributes")
                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class= "col-12 col-md-3">
                            <b><label for="description">Description</label></b>
                        </div>
                        <div class= "col-12 col-md-9">
                            <textarea rows="4" class="form-control"  name="description"></textarea>
                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class= "col-12 col-md-3">
                            <b><label for="icon">Icon</label></b>
                        </div>
                        <div class= "col-12 col-md-9">
                            
                            @include("templates.icons")

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div> 
