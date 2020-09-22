@extends('layouts.app')



@section('content')

    <script>
        var categories = @json($categories);
        var icons = @json($icons);
    </script>
    <div class="container">
        <h3>Categories</h3>



        <div class="table-responsive">  
            <table id="categories-table" class="table table-hover table-bordered dt-responsive">

            </table>
        </div>

        <div class='col-12 col-md-4'>
            <button type="button" class="btn btn-block btn-primary rounded-0"  data-toggle="modal" data-target="#category-modal" >New Category</button>
        </div>
    </div>
    <script rel="script" src="{{ asset('js/app/categories.js?v=1') }}" defer></script>
    <script rel="script" src="{{ asset('js/app/icons.js?v=1') }}" defer></script>

@include("modals.categories")

@endsection