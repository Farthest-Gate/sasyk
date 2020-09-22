@extends('layouts.app')

@section('content')
<div class="container">
        
    <div class="sasyk-home">

        <div class="row home_row">
            <h4>Recent Posts <small><a href="{{ route('view-posts') }}">View All</a></small></h4>
            <div class="home_row_carousel">
                @foreach($posts as $post)
                    <div class="home-card">
                        <h4><a href="{{route('view-post', $post->post_id)}}">{{$post->title }}</a></h4>



                        <div class='row'>
                            <div class='col-4'>
                                <label>Updated</label>
                            </div>
                            <div class='col-8'>{{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label>By</label>
                            </div>
                            <div class='col-8'>{{ $post->updated_by_name }}</div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label>Categories</label>
                            </div>
                            <div class='col-8'>@foreach($post->categories as $cat){{ $cat->name }}<br>@endforeach</div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label>Projects</label>
                            </div>
                            <div class='col-8'>@foreach($post->projects as $proj){{ $proj->name }}<br>@endforeach</div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
        <hr>
        <div class="row home_row">
            <h4>Categories <small><a href="{{ route('view-categories') }}">View All</a></small></h4>
            <div class="home_row_carousel">
                @foreach($categories as $category)
                    <div class="home-card">
                        <h4>
                            <a href="{{route('view-category', $category->category_id)}}">
                            @if(isset($category->icon))
                                <i class='{{$category->icon}}'></i>
                            @endif
                            {{$category->name }}</a></h4>



                        <div class='row'>
                            <div class='col-4'>
                                <label>Updated</label>
                            </div>
                            <div class='col-8'>{{ \Carbon\Carbon::parse($category->updated_at)->diffForHumans() }}</div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label>By</label>
                            </div>
                            <div class='col-8'>{{ $category->updated_by_name }}</div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
        <hr>
        <div class="row home_row">
            <h4>Projects <small><a href="{{ route('view-projects') }}">View All</a></small></h4>
            <div class="home_row_carousel">
                @foreach($projects as $project)
                  <div class="home-card">
                        <h4>
                            <a href="{{route('view-project', $project->project_id)}}">
                            @if(isset($project->icon))
                                <i class='{{$project->icon}}'></i>
                            @endif
                            {{$project->name }}</a></h4>



                        <div class='row'>
                            <div class='col-4'>
                                <label>Updated</label>
                            </div>
                            <div class='col-8'>{{ \Carbon\Carbon::parse($project->updated_at)->diffForHumans() }}</div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label>By</label>
                            </div>
                            <div class='col-8'>{{ $project->updated_by_name }}</div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>


    </div>
</div>
@endsection
