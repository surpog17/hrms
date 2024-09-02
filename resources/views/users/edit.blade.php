@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'user-management'])

@section('styles')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('user.update', $user) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Edit User') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('user.index') }}"
                                        class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"
                                            value="{{ old('name', $user->name) }}" required="true"
                                            aria-required="true" />
                                        @if ($errors->has('name'))
                                        <span id="name-error" class="error text-danger"
                                            for="input-name">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="input-email" type="email" placeholder="{{ __('Email') }}"
                                            value="{{ old('email', $user->email) }}" required />
                                        @if ($errors->has('email'))
                                        <span id="email-error" class="error text-danger"
                                            for="input-email">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"
                                    for="input-password">{{ __(' Password') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            input type="password" name="password" id="input-password"
                                            placeholder="{{ __('Password') }}" />
                                        @if ($errors->has('password'))
                                        <span id="name-error" class="error text-danger"
                                            for="input-name">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"
                                    for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="password_confirmation"
                                            id="input-password-confirmation" type="password"
                                            placeholder="{{ __('Confirm Password') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Human Resource') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('hr') ? ' has-danger' : '' }}">
                                        <input id="hr" name="hr" type="checkbox" data-size="mini" data-toggle="toggle"
                                            data-on="Enabled" data-off="Disable" data-onstyle="success"
                                            data-offstyle="danger" {{ $user->hr ? 'checked' : '' }}>
                                        @if ($errors->has('hr'))
                                        <span id="hr-error" class="error text-danger"
                                            for="input-hr">{{ $errors->first('hr') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Finance') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('fin') ? ' has-danger' : '' }}">
                                        <input id="fin" name="fin" type="checkbox" data-size="mini" data-toggle="toggle"
                                            data-on="Enabled" data-off="Disable" data-onstyle="success"
                                            data-offstyle="danger" {{ $user->finance ? 'checked' : '' }}>
                                        @if ($errors->has('fin'))
                                        <span id="fin-error" class="error text-danger"
                                            for="input-fin">{{ $errors->first('fin') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection
