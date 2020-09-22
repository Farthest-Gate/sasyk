@extends('layouts.app')



@section('content')

    <script>
        var posts = @json($posts);
    </script>
    <div class="container">
        <h3>Posts</h3>



        <div class="table-responsive">  
            <table id="posts-table" class="table table-hover table-bordered dt-responsive">

            </table>
        </div>

        <div class='col-12 col-md-4'>
            <a href="{{ route('create-post') }}" class="btn btn-block btn-primary rounded-0">New Post</a>
        </div>
    </div>
    <script rel="script" src="{{ asset('js/app/posts.js?v=1') }}" defer></script>


@endsection