@extends('layouts.app')



@section('content')

    <script>
        var projects = @json($projects);
        var icons = @json($icons);
    </script>
    <div class="container">
        <h3>Projects</h3>



        <div class="table-responsive">  
            <table id="projects-table" class="table table-hover table-bordered dt-responsive">

            </table>
        </div>

        <div class='col-12 col-md-4'>
            <button type="button" class="btn btn-block btn-primary rounded-0"  data-toggle="modal" data-target="#project-modal" >New Project</button>
        </div>
    </div>
    <script rel="script" src="{{ asset('js/app/projects.js?v=1') }}" defer></script>
    <script rel="script" src="{{ asset('js/app/attributes.js?v=1') }}" defer></script>
    <script rel="script" src="{{ asset('js/app/icons.js?v=1') }}" defer></script>

@include("modals.projects")

@endsection