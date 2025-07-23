@extends('layouts.app')

@section('title', 'General Settings')

@section('styles')
<style>
    .settings-card {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }
    .settings-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eaecef;
        padding: 1rem 1.25rem;
    }
    .settings-section {
        border-bottom: 1px solid #eaecef;
        padding: 1.25rem;
    }
    .settings-section:last-child {
        border-bottom: none;
    }
    .setting-item {
        margin-bottom: 1.5rem;
    }
    .setting-item:last-child {
        margin-bottom: 0;
    }
    .setting-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    .setting-description {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .image-preview {
        max-height: 60px;
        border-radius: 4px;
        margin-bottom: 0.75rem;
    }
    .color-input-group {
        display: flex;
        align-items: center;
    }
    .color-preview {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        margin-right: 10px;
        border: 1px solid #ced4da;
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .toggle-slider {
        background-color: #3B82F6;
    }
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    .btn-save {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }
    .tooltip-icon {
        color: #6c757d;
        margin-left: 5px;
        cursor: help;
    }
</style>
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-cog mr-2"></i> General Settings</h1>
        <div>
            <a href="{{ route('superadmin.settings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list mr-1"></i> All Settings
            </a>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('superadmin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="card settings-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-building mr-2"></i> Center Information</h5>
            </div>
            
            <div class="card-body p-0">
                @php
                    $siteSettings = $settings->filter(function($setting) {
                        return in_array($setting->key, ['site_name', 'site_tagline', 'site_description']);
                    });
                @endphp
                
                <div class="settings-section">
                    @foreach($siteSettings as $setting)
                        <div class="setting-item">
                            <label for="{{ $setting->key }}" class="setting-label">
                                {{ $setting->label }}
                                <i class="fas fa-info-circle tooltip-icon" data-toggle="tooltip" title="{{ $setting->description }}"></i>
                            </label>
                            
                            @if($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control" rows="3">{{ $setting->value }}</textarea>
                            @else
                                <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                            @endif
                            
                            <small class="setting-description">{{ $setting->description }}</small>
                        </div>
                    @endforeach
                </div>
                
                @php
                    $contactSettings = $settings->filter(function($setting) {
                        return in_array($setting->key, ['contact_email', 'contact_phone', 'contact_address']);
                    });
                @endphp
                
                <div class="settings-section">
                    <h6 class="mb-3">Contact Information</h6>
                    
                    @foreach($contactSettings as $setting)
                        <div class="setting-item">
                            <label for="{{ $setting->key }}" class="setting-label">
                                {{ $setting->label }}
                                <i class="fas fa-info-circle tooltip-icon" data-toggle="tooltip" title="{{ $setting->description }}"></i>
                            </label>
                            
                            @if($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control" rows="3">{{ $setting->value }}</textarea>
                            @else
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            @if($setting->key === 'contact_email')
                                                <i class="fas fa-envelope"></i>
                                            @elseif($setting->key === 'contact_phone')
                                                <i class="fas fa-phone"></i>
                                            @else
                                                <i class="fas fa-map-marker-alt"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                                </div>
                            @endif
                            
                            <small class="setting-description">{{ $setting->description }}</small>
                        </div>
                    @endforeach
                </div>
                
                @php
                    $socialSettings = $settings->filter(function($setting) {
                        return strpos($setting->key, 'social_') === 0;
                    });
                @endphp
                
                @if($socialSettings->count() > 0)
                    <div class="settings-section">
                        <h6 class="mb-3">Social Media</h6>
                        
                        <div class="row">
                            @foreach($socialSettings as $setting)
                                <div class="col-md-6">
                                    <div class="setting-item">
                                        <label for="{{ $setting->key }}" class="setting-label">
                                            {{ $setting->label }}
                                        </label>
                                        
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    @if(strpos($setting->key, 'facebook') !== false)
                                                        <i class="fab fa-facebook"></i>
                                                    @elseif(strpos($setting->key, 'instagram') !== false)
                                                        <i class="fab fa-instagram"></i>
                                                    @elseif(strpos($setting->key, 'whatsapp') !== false)
                                                        <i class="fab fa-whatsapp"></i>
                                                    @else
                                                        <i class="fas fa-link"></i>
                                                    @endif
                                                </span>
                                            </div>
                                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                                        </div>
                                        
                                        <small class="setting-description">{{ $setting->description }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary btn-save">
                <i class="fas fa-save mr-1"></i> Save Changes
            </button>
        </div>
    </form>
@stop

@section('js')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize color pickers if needed
        $('.color-input').on('input', function() {
            $(this).siblings('.color-preview').css('background-color', $(this).val());
        });
        
        // Initialize color previews
        $('.color-input').each(function() {
            $(this).siblings('.color-preview').css('background-color', $(this).val());
        });
    });
</script>
@endsection
