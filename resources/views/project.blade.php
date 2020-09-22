@extends('layouts.app')



@section('content')

    <script>
    </script>
    <div class="container">
        <h3>Project: {{ $project->name }}
        @if(isset($project->icon))
            <i class="{{ $category->icon }}"></i>
        @endif
        </h3>
        
        
        
        <div class="row">
            <div class="col-12 col-md-6 post-data">
                <h4>Attributes</h4>
                @foreach($project->project_attributes as $attr)
                <label>{{ $attr->attr_name }} </label>: {{ $attr->attr_value}} <br>
                @endforeach

            </div> 
            
            
            <div class="col-12 col-md-6 post-data">
                <h4>Project Details</h4>
                <div class="row">
                    <div class="col-6">
                        <label>Created</label>
                    </div>
                    <div class="col-6">
                        {{ $project->created_at }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Created By</label>
                    </div>
                    <div class="col-6">
                        {{ $project->created_by_name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Last Updated</label>
                    </div>
                    <div class="col-6">
                        {{ $project->updated_at }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Updated By</label>
                    </div>
                    <div class="col-6">
                        {{ $project->updated_by_name }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-6 post-data">
                <h4>Related Posts</h4>

                @foreach($project->posts as $post)
                <label><a href="{{route('view-post', $post['post_id'])}}">{{ $post['title'] }} </a> </label><br>
                @endforeach

            </div> 
        </div>
        
        
        
        <hr class="break">
        <h4>Description</h4>
        {{ $project->description }}
        <hr class="break">

        

        <div class='col-12 col-md-4'>
            <a href="{{route('view-categories')}}" type="button" class="btn btn-block btn-primary rounded-0">View All Categories</a>
        </div>
    </div>


@endsection