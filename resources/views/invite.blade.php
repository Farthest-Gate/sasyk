@extends('layouts.app')

@section('content')
<div class="container">
    
    @if(isset($exists) && $exists)
        <h4 class='row justify-content-center break text-danger'>
            {{ $email }} is already registered
        </h4>
    @elseif(isset($sent) && $sent)
        <h4 class='row justify-content-center break text-danger'>

            An invite has been sent to {{ $email }}
        </h4>
    @endif
        <form method="POST" action="{{ route('invite') }}" class='break'>
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Invite
                    </button>

                </div>
            </div>

        </form>
    
</div>
@endsection
