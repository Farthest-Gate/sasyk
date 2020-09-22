@extends('layouts.app')



@section('content')

    <script>
        var post = @json($post);
    </script>
    <div class="container">
        <h1>Post: {{ $post->title }} </h1>


        <div class="row">
            <div class="col-12 col-md-6 post-data">
                <h4>Attributes</h4>
                @foreach($post->attributes as $attr)
                <label>{{ $attr->attr_name }} </label>: {{ $attr->attr_value}} <br>
                @endforeach
            </div> 
            
            
            <div class="col-12 col-md-6 post-data">
                <h4>Post Details</h4>
                <div class="row">
                    <div class="col-6">
                        <label>Created</label>
                    </div>
                    <div class="col-6">
                        {{ $post->created_at }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Created By</label>
                    </div>
                    <div class="col-6">
                        {{ $post->created_by_name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Last Updated</label>
                    </div>
                    <div class="col-6">
                        {{ $post->updated_at }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Updated By</label>
                    </div>
                    <div class="col-6">
                        {{ $post->updated_by_name }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-6 post-data">
                <h4>Projects</h4>
                <ul>
                    @foreach($post->projects as $project)
                        <li>{{ $project->name }}</li>    
                    @endforeach
                </ul>
            </div> 
            <div class="col-12 col-md-6 post-data">
                <h4>Categories</h4>
                <ul>
                    @foreach($post->categories as $category)  
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="row">
            <div class="post_content">
                {!! $post->content !!}
            
            </div>
        
        </div>

        
            <a href="{{ route('update-post', $post->post_id) }}" class="btn btn-block btn-primary rounded-0">Update Post</a>
            <a href="{{ route('create-post') }}" class="btn btn-block btn-primary rounded-0">New Post</a>
    </div>
    <script rel="script" src="{{ asset('js/app/view_post.js?v=1') }}" defer></script>


@endsection