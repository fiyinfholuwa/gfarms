@extends('user_new.app')

@section('content')
<style>
    .loan-history-container {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
    }

    .loan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        border-bottom: 2px solid #f3f3f3;
        padding-bottom: 1rem;
    }

    .loan-header h2 {
        font-weight: 700;
        color: #ff7b00; /* Orange heading */
        margin: 0;
    }

    .loan-header p {
        margin: 0;
        font-size: 15px;
        color: #444;
    }

    .btn-back {
        background: #000;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s ease;
    }

    .btn-back:hover {
        background: #ff7b00;
        color: #fff;
    }

    .loan-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
        border-radius: 12px;
        overflow: hidden;
    }

    .loan-table thead {
        background: #000;
        color: #fff;
    }

    .loan-table th,
    .loan-table td {
        padding: 14px 18px;
        text-align: left;
        vertical-align: middle;
    }

    .loan-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .loan-table tbody tr:hover {
        background-color: #fff5ec; /* light orange hover */
        transition: 0.3s ease;
    }

    .badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 13px;
        text-transform: capitalize;
    }

    .badge-success {
        background: #ff7b00 !important;
        color: #fff;
    }

    .badge-warning {
        background: #000 !important;
        color: #fff;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        color: #777;
        font-size: 15px;
    }
</style>

<style>
  #dashboard_food_display{
      background: #fff7f4; /* light orange */
      padding:20px;

}
</style>
  

<div class="container">
    <div id="dashboard_food_display" class="loan-history-container">
        <div class="loan-header">
            <div>
                <p><strong>Current Loan Balance:</strong> ₦{{ number_format(Auth::user()->loan_balance, 2) }}</p>
            </div>
        </div>

        @if($repayments->count())
            <div class="table-responsive">
                <table class="loan-table">
                    <thead>
                        <tr>
                            <th>Due Date</th>
                            <th>Repayment Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repayments as $repayment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($repayment->due_date)->format('M d, Y') }}</td>
                                <td>₦{{ number_format($repayment->repayment_amount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $repayment->status == 'paid' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($repayment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-info-circle fa-2x mb-2 text-secondary"></i>
                <p>No repayment history found for this user.</p>
            </div>
        @endif
    </div>
</div>
@endsection
