@extends('layouts.app')

@section('title', 'Contact Information Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Information Management</h3>
                    <div class="card-tools">
                        @if($contactInfo)
                            <span class="badge badge-{{ $contactInfo->is_active ? 'success' : 'secondary' }} mr-2">
                                <i class="fas fa-{{ $contactInfo->is_active ? 'check' : 'times' }}"></i>
                                {{ $contactInfo->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @endif
                        @if(!$contactInfo)
                            <a href="{{ route('superadmin.contact-information.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Contact Information
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($contactInfo)
                        <form action="{{ route('superadmin.contact-information.update', $contactInfo->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Contact Details</h4>
                                    
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                               id="address" name="address" value="{{ old('address', $contactInfo->address) }}" 
                                               placeholder="Enter business address">
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $contactInfo->phone) }}" 
                                               placeholder="Enter phone number">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $contactInfo->email) }}" 
                                               placeholder="Enter email address">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="business_hours">Business Hours</label>
                                        <textarea class="form-control @error('business_hours') is-invalid @enderror" 
                                                  id="business_hours" name="business_hours" rows="4" 
                                                  placeholder="Enter business hours (one per line)">{{ old('business_hours', $contactInfo->business_hours) }}</textarea>
                                        <small class="form-text text-muted">Enter each time period on a new line (e.g., "Monday - Friday: 9:00 AM - 6:00 PM")</small>
                                        @error('business_hours')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4>Social Media Links</h4>
                                    
                                    <div class="form-group">
                                        <label for="facebook_url">Facebook URL</label>
                                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                               id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $contactInfo->facebook_url) }}" 
                                               placeholder="https://facebook.com/yourpage">
                                        @error('facebook_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="twitter_url">Twitter URL</label>
                                        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                               id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $contactInfo->twitter_url) }}" 
                                               placeholder="https://twitter.com/yourhandle">
                                        @error('twitter_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="instagram_url">Instagram URL</label>
                                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                               id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $contactInfo->instagram_url) }}" 
                                               placeholder="https://instagram.com/yourhandle">
                                        @error('instagram_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="whatsapp_url">WhatsApp URL</label>
                                        <input type="url" class="form-control @error('whatsapp_url') is-invalid @enderror" 
                                               id="whatsapp_url" name="whatsapp_url" value="{{ old('whatsapp_url', $contactInfo->whatsapp_url) }}" 
                                               placeholder="https://wa.me/yournumber">
                                        @error('whatsapp_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="youtube_url">YouTube URL</label>
                                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                               id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $contactInfo->youtube_url) }}" 
                                               placeholder="https://youtube.com/yourchannel">
                                        @error('youtube_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="linkedin_url">LinkedIn URL</label>
                                        <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                               id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $contactInfo->linkedin_url) }}" 
                                               placeholder="https://linkedin.com/in/yourprofile">
                                        @error('linkedin_url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4>Contact Form Settings</h4>
                                    
                                    <div class="form-group">
                                        <label for="contact_form_title">Contact Form Title</label>
                                        <input type="text" class="form-control @error('contact_form_title') is-invalid @enderror" 
                                               id="contact_form_title" name="contact_form_title" 
                                               value="{{ old('contact_form_title', $contactInfo->contact_form_title) }}" 
                                               placeholder="Enter contact form title">
                                        @error('contact_form_title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_form_description">Contact Form Description</label>
                                        <textarea class="form-control @error('contact_form_description') is-invalid @enderror" 
                                                  id="contact_form_description" name="contact_form_description" rows="3" 
                                                  placeholder="Enter contact form description">{{ old('contact_form_description', $contactInfo->contact_form_description) }}</textarea>
                                        @error('contact_form_description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                                                   {{ (old('is_active', $contactInfo->is_active) == true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">Active (This will be displayed on the website)</label>
                                        </div>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> 
                                            Only one contact information set can be active at a time. When you activate this one, all others will be deactivated automatically.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Contact Information
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                                    </a>
                                </div>
                            </div>
                        </form>

                        <script>
                            // Add visual feedback for the active toggle
                            document.getElementById('is_active').addEventListener('change', function() {
                                const label = this.nextElementSibling;
                                if (this.checked) {
                                    label.style.color = '#28a745';
                                    label.textContent = 'Active (This will be displayed on the website) ✓';
                                } else {
                                    label.style.color = '#6c757d';
                                    label.textContent = 'Inactive (This will NOT be displayed on the website) ✗';
                                }
                            });

                            // Initialize the label state on page load
                            document.addEventListener('DOMContentLoaded', function() {
                                const checkbox = document.getElementById('is_active');
                                const label = checkbox.nextElementSibling;
                                if (checkbox.checked) {
                                    label.style.color = '#28a745';
                                    label.textContent = 'Active (This will be displayed on the website) ✓';
                                } else {
                                    label.style.color = '#6c757d';
                                    label.textContent = 'Inactive (This will NOT be displayed on the website) ✗';
                                }
                            });
                        </script>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-info-circle text-info fa-3x mb-3"></i>
                            <h4>No Contact Information Found</h4>
                            <p class="text-muted">Please create contact information to manage your business details.</p>
                            <a href="{{ route('superadmin.contact-information.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Contact Information
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 