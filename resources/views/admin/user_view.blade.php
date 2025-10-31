@extends('admin.app')

@section('content')
<style>
:root {
    --primary-color: #ff8c00; /* orange */
    --primary-dark: #e67e00;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --text-primary: #1f1f1f;
    --text-secondary: #6b7280;
    --bg-light: #f5f5f5;
    --bg-white: #ffffff;
    --border-color: #e0e0e0;
    --radius: 14px;
    --shadow: 0 8px 25px rgba(0,0,0,0.08);
    --transition: all 0.3s ease;
}

body {
    background: var(--bg-light);
    color: var(--text-primary);
    font-family: 'Poppins', sans-serif;
}

.container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 1.5rem;
}

/* Go Back Button */
.go-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.3rem;
    border-radius: var(--radius);
    background: var(--bg-white);
    border: 1px solid var(--border-color);
    font-weight: 600;
    color: var(--text-primary);
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: var(--transition);
    text-decoration: none;
}
.go-back-btn:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-2px);
}
.go-back-btn i {
    transition: transform var(--transition);
}
.go-back-btn:hover i {
    transform: translateX(-3px);
}

/* Header */
.user-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(120deg, #000000 0%, #ff8c00 100%);
    color: white;
    border-radius: var(--radius);
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
}

.user-header::after {
    content: "";
    position: absolute;
    top: -40%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    filter: blur(60px);
}

.avatar-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: white;
    color: var(--primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 2rem;
    box-shadow: var(--shadow);
    flex-shrink: 0;
}

.user-info {
    margin-left: 1.5rem;
}
.user-name {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}
.user-subtitle {
    color: rgba(255,255,255,0.85);
    font-size: 0.95rem;
}

/* Grid Layout */
.user-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
    gap: 1.75rem;
    margin-top: 2.5rem;
}

/* Detail Cards */
.detail-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    padding: 1.75rem;
    box-shadow: var(--shadow);
    transition: var(--transition);
}
.detail-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.1);
}

.detail-card h6 {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--primary-dark);
    margin-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 0.5rem;
}

/* Items */
.detail-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    font-size: 0.95rem;
}
.detail-label {
    color: var(--text-secondary);
    font-weight: 500;
}
.detail-value {
    color: var(--text-primary);
    font-weight: 600;
}

/* Status Badge */
.status-badge {
    padding: 0.35rem 0.8rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    border: none;
    text-transform: capitalize;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.verified {
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
}
.unverified {
    background: linear-gradient(135deg, #ef4444, #f87171);
    color: white;
}

@media (max-width: 768px) {
    .user-header {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }
    .user-info {
        margin-left: 0;
        margin-top: 1rem;
    }
}
</style>

<div class="container-fluid">
    <!-- Go Back -->
    <a href="{{ url()->previous() }}" class="go-back-btn mb-4">
        <i class="fas fa-arrow-left"></i> Go Back
    </a>

    <!-- Header -->
    <div class="user-header">
        <div class="flex items-center gap-4">
            <div class="avatar-circle">
                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
            </div>
            <div class="user-info">
                <h1 class="user-name">{{ $user->first_name }} {{ $user->last_name }}</h1>
                <p class="user-subtitle">User ID: #{{ $user->id }}</p>
            </div>
        </div>
    </div>

    <!-- Grid -->
    <div class="user-details-grid">
        <!-- Personal Info -->
        <div class="detail-card">
            <h6>Personal Information</h6>
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">{{ $user->first_name }} {{ $user->last_name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $user->phone ?? 'Not provided' }}</span>
            </div>
        </div>

        <!-- Account Info -->
        <div class="detail-card">
            <h6>Account Information</h6>
            <div class="detail-item">
                <span class="detail-label">Role</span>
                <span class="detail-value">{{ ucfirst($user->user_role ?? 'user') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email Status</span>
                @if($user->has_verified_email ==='yes')
                    <span class="status-badge verified">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                @else
                    <span class="status-badge unverified">
                        <i class="fas fa-exclamation-circle"></i> Not Verified
                    </span>
                @endif
            </div>
            <div class="detail-item">
                <span class="detail-label">Member Since</span>
                <span class="detail-value">{{ $user->created_at->format('M j, Y g:i A') }}</span>
            </div>
            
        </div>

        <!-- Location -->
        <div class="detail-card">
            <h6>Location</h6>
            <div class="detail-item">
                <span class="detail-label">Country</span>
                <span class="detail-value">{{ $user->country ?? 'Not provided' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">State</span>
                <span class="detail-value">{{ $user->state ?? 'Not provided' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">LGA</span>
                <span class="detail-value">{{ $user->lga ?? 'Not provided' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
