@extends('admin.app')

@section('content')
<style>
    .loan-container {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-top: 2rem;
    }

    .loan-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
    }

    .loan-table thead {
        background-color: darkorange;
        color: #fff;
        text-align: left;
    }

    .loan-table th, .loan-table td {
        padding: 14px 18px;
        vertical-align: middle;
    }

    .loan-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .loan-table tbody tr:hover {
        background-color: #eef6ff;
        transition: 0.3s ease;
    }

    .btn-view {
        background: black;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 14px;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .btn-view:hover {
        background: #004fc5;
        color: #fff;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination .page-link {
        border: none;
        color: #0d6efd;
    }

    .pagination .active .page-link {
        background: #0d6efd;
        color: #fff;
        border-radius: 6px;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        color: #777;
    }
</style>

<div class="container">
    <div class="loan-container">
        <h2 class="mb-4 text-warning fw-bold">Manage User Loans</h2>

        @if($users->count())
            <div class="table-responsive">
                <table class="loan-table">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Loan Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>₦{{ number_format($user->loan_balance, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.loan_history', $user->id) }}" class="btn-view">
                                        <i class="fas fa-history me-1"></i> View History
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
        {{ $users->links('admin.paginate') }}
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-info-circle fa-2x mb-2 text-secondary"></i>
                <p>No users currently owe loans.</p>
            </div>
        @endif
    </div>
</div>
@endsection
