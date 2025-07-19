@extends('layouts.app')

@section('title', 'System Settings')

@section('content_header')
    <h1>System Settings</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('superadmin.settings.system.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                @foreach($settings as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">{{ $setting->label }}</label>
                        @if($setting->type === 'select' && is_array($setting->options))
                            <select name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control">
                                @foreach($setting->options as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ $setting->value == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif($setting->type === 'boolean')
                            <input type="checkbox" name="{{ $setting->key }}" id="{{ $setting->key }}" value="1" {{ $setting->value ? 'checked' : '' }}>
                        @else
                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                        @endif
                        @if($setting->description)
                            <small class="form-text text-muted">{{ $setting->description }}</small>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('superadmin.settings.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@stop 