@extends('admin.app')

@section('content')
<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --success-color: #10b981;
    --success-light: #d1fae5;
    --danger-color: #ef4444;
    --danger-light: #fee2e2;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --border-color: #e2e8f0;
    --radius-md: 12px;
    --shadow-md: 0 8px 20px rgba(0,0,0,0.05);
    --transition: 0.3s ease;
}

.container {
    max-width: 1100px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.go-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
    font-weight: 500;
    text-decoration: none;
    transition: var(--transition);
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.go-back-btn i {
    transition: transform var(--transition);
}

.go-back-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.go-back-btn:hover i {
    transform: translateX(-2px);
}

.user-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.75rem;
    box-shadow: var(--shadow-md);
}

.user-name {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-primary);
}

.user-subtitle {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-top: 0.25rem;
}

.user-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.75rem;
}

.detail-card {
    background: var(--bg-primary);
    border-radius: var(--radius-md);
    padding: 1.5rem 1.75rem;
    box-shadow: var(--shadow-md);
    transition: transform var(--transition), box-shadow var(--transition);
}

.detail-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}

.detail-card h6 {
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: 1.05rem;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 0.5rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.7rem;
    font-size: 0.95rem;
}

.detail-label {
    color: var(--text-secondary);
    font-weight: 500;
}

.detail-value {
    font-weight: 600;
    color: var(--text-primary);
}

.status-badge {
    padding: 0.3rem 0.85rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    border: 1px solid transparent;
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
    }
}
</style>

<div class="container-fluid">
    <!-- Go Back Button -->
    <a href="{{ url()->previous() }}" class="go-back-btn">
        <i class="fas fa-arrow-left"></i> Go Back
    </a>

    <!-- User Header -->
    <div class="user-header">
        <div class="avatar-circle">
            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
        </div>
        <div>
            <h1 class="user-name">{{ $user->first_name }} {{ $user->last_name }}</h1>
            <p class="user-subtitle">User ID: #{{ $user->id }}</p>
        </div>
    </div>

    <!-- User Details Grid -->
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
                        <i class="fas fa-exclamation-circle"></i> Not verified
                    </span>
                @endif
            </div>
            <div class="detail-item">
                <span class="detail-label">Member Since</span>
                <span class="detail-value">{{ $user->created_at->format('M j, Y g:i A') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Wallet Balance</span>
                <span class="detail-value">₦{{ number_format($user->wallet_balance, 2) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Loan Balance</span>
                <span class="detail-value">₦{{ number_format($user->loan_balance, 2) }}</span>
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

        <!-- KYC -->
        @if($user->kyc_reference)
        <div class="detail-card">
            <h6>KYC Information</h6>
            <div class="detail-item">
                <span class="detail-label">KYC Reference</span>
                <span class="detail-value">{{ $user->kyc_reference }}</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
