@extends('layouts.app')



@section('content')
<style>
    .landing .fa{
        font-size:9em;
        padding:50px;
        transition: font-size 1s; /* transition is set to 'font-size 12s' */
        transition: color 1s; 
        color:#ddd;
    }
    .landing .fa:hover{
        font-size:11em;
        color:black;
    }
    
</style>
<div class="landing text-center">
</div>

<div class="landing outer">
  <div class="middle">
    <div class="inner text-center">
        <i class="fas fa-share-alt"></i>

     <i class="fas fa-brain"></i>

    </div>
  </div>
</div>
@endsection