@extends('layouts.app')



@section('content')



    <script>
        var trumbowyg_svgPath = "{{ asset('trumbowyg/dist/ui/icons.svg') }}";
        
        var categories = @json($categories);
        var pojects = @json($projects);
        var posts = @json($posts);
        @isset($post)
            var post = @json($post);
        @endisset
    </script>
    <div class="container">
        <h3>Create New Post</h3>
        <form id="create_post_form">
            @csrf
            
            @if(isset($post))
                <input type='hidden' id='update_post_id' value='{{ $post->post_id }}'>
            
            @endif
           <div class="form-group row">
                <div class= "col-12">
                    <b><label for="title">Title</label></b>
                </div>
                <div class= "col-12">
                    @isset($post)
                        <input type="text" class="form-control" name="title" placeholder="Title" value="{{ $post->title }}"> 
                    @else
                        <input type="text" class="form-control" name="title" placeholder="Title"> 
                    @endisset
                    
                </div>
            </div>
        
            <div class='row'>
                <div class='col-md-6'>
                    <h5>Attributes</h5>
                     @include("templates.attributes")
                </div>
                <div class='col-md-6'>
                    <div class='row'>
                        <div class='col-12'>
                            <h5>Projects</h5>
                            <select class='selectpicker' id='projects_select' name='projects_select' title='Link Projects' multiple>
                                @foreach ($projects as $project)
                                    <option value='{{ $project->project_id }}'>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='row break'>
                        <div class='col-md-6'>
                            <h5>Categories</h5>
                            <select class='selectpicker' id='categories_select' name='categories_select' title='Link Categories' multiple>
                                @foreach ($categories as $category)
                                    <option value='{{ $category->category_id }}'>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <!-- padding -->
                </div>
                <div class='col-md-6'>
                    
                </div>
            </div>
            <div class='row'>
                <div class='col-12 content'>
                    <h5>Content</h5>
                    <div class='content'>
                        <div id="content-wysiwyg">
                            
                        </div>
                    </div>
                    <div class='content-add-section'>
                        
                    </div>
                </div>
            </div>
            
            
            <div class='col-12 col-md-4'>
                <button type="submit" class="btn btn-block btn-primary">Create Post</button>
            </div>
            
        </form>
    </div>
    <script rel="script" src="{{ asset('js/app/attributes.js?v=1') }}" defer></script>
    <script rel="script" src="{{ asset('js/app/create_post.js?v=1') }}" defer></script>
    <script src="{{ asset('trumbowyg/dist/trumbowyg.min.js') }}" defer></script>
    <script src="{{ asset('trumbowyg/dist/plugins/upload/trumbowyg.upload.js')}}" defer></script>
    

@endsection