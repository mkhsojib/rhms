@extends('layouts.app')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User: {{ $user->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Leave blank to keep current password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Leave blank to keep current password</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role *</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="">Select Role</option>
                                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Raqi/Practitioner)</option>
                                <option value="patient" {{ old('role', $user->role) == 'patient' ? 'selected' : '' }}>Patient</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <select name="specialization" id="specialization" class="form-control @error('specialization') is-invalid @enderror">
                                <option value="">Select Specialization</option>
                                <option value="ruqyah_healing" {{ old('specialization', $user->specialization) == 'ruqyah_healing' ? 'selected' : '' }}>Ruqyah Healing</option>
                                <option value="hijama_cupping" {{ old('specialization', $user->specialization) == 'hijama_cupping' ? 'selected' : '' }}>Hijama (Cupping)</option>
                                <option value="both" {{ old('specialization', $user->specialization) == 'both' ? 'selected' : '' }}>Ruqyah & Hijama</option>
                            </select>
                            @error('specialization')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Only applicable for Admin/Raqi role</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}" placeholder="+1234567890">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" rows="3" 
                                      class="form-control @error('address') is-invalid @enderror" 
                                      placeholder="Enter full address">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="email_verified" id="email_verified" 
                               class="custom-control-input" value="1" 
                               {{ old('email_verified', $user->email_verified_at ? '1' : '') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="email_verified">
                            Mark email as verified
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">
                            Active (Allow this user to sign in)
                        </label>
                    </div>
                </div>

                <div id="session-fees-section" style="display:none;">
    <div class="row" id="ruqyah-fees-row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="diagnosis_fee">Diagnosis Session Fee</label>
                <input type="number" name="diagnosis_fee" id="diagnosis_fee" class="form-control" min="0" placeholder="e.g. 1500" value="{{ old('diagnosis_fee', $diagnosisFee ?? '') }}">
                <small class="form-text text-muted">30-60 min</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="short_fee">Short Session Fee</label>
                <input type="number" name="short_fee" id="short_fee" class="form-control" min="0" placeholder="e.g. 1000" value="{{ old('short_fee', $shortFee ?? '') }}">
                <small class="form-text text-muted">60-90 min</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="long_fee">Long Session Fee</label>
                <input type="number" name="long_fee" id="long_fee" class="form-control" min="0" placeholder="e.g. 3000" value="{{ old('long_fee', $longFee ?? '') }}">
                <small class="form-text text-muted">180-300 min</small>
            </div>
        </div>
    </div>
    <div class="row" id="cupping-fees-row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="head_cupping_fee">Head Cupping per point price <span class="text-muted">(saved to session types)</span></label>
                <input type="number" name="head_cupping_fee" id="head_cupping_fee" class="form-control" min="0" placeholder="e.g. 500" value="{{ old('head_cupping_fee', $headCuppingFee ?? '') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="body_cupping_fee">Body Cupping per point price <span class="text-muted">(saved to session types)</span></label>
                <input type="number" name="body_cupping_fee" id="body_cupping_fee" class="form-control" min="0" placeholder="e.g. 300" value="{{ old('body_cupping_fee', $bodyCuppingFee ?? '') }}">
            </div>
        </div>
    </div>
</div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update User
                    </button>
                    <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    // Auto-hide specialization field for non-admin roles
    document.getElementById('role').addEventListener('change', function() {
        const specializationField = document.getElementById('specialization').closest('.form-group');
        if (this.value === 'admin') {
            specializationField.style.display = 'block';
        } else {
            specializationField.style.display = 'none';
            document.getElementById('specialization').value = '';
        }
    });

    // Trigger on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('role').dispatchEvent(new Event('change'));
    });

    function toggleSessionFees() {
        const role = document.getElementById('role').value;
        const specialization = document.getElementById('specialization').value;
        const section = document.getElementById('session-fees-section');
        const ruqyahRow = document.getElementById('ruqyah-fees-row');
        const cuppingRow = document.getElementById('cupping-fees-row');
        if (role === 'admin' && specialization) {
            section.style.display = 'block';
            if (specialization === 'ruqyah_healing') {
                ruqyahRow.style.display = 'flex';
                cuppingRow.style.display = 'none';
            } else if (specialization === 'hijama_cupping') {
                ruqyahRow.style.display = 'none';
                cuppingRow.style.display = 'flex';
            } else if (specialization === 'both') {
                ruqyahRow.style.display = 'flex';
                cuppingRow.style.display = 'flex';
            }
        } else {
            section.style.display = 'none';
        }
    }
    document.getElementById('role').addEventListener('change', toggleSessionFees);
    document.getElementById('specialization').addEventListener('change', toggleSessionFees);
    document.addEventListener('DOMContentLoaded', toggleSessionFees);
</script>
@stop 