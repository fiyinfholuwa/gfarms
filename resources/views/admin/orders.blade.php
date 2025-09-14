@extends('admin.app')

@section('content')
<style>
    .orders-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .orders-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .back-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .back-btn:hover { background: var(--primary-dark); }

    .table th, .table td {
        vertical-align: middle;
    }

    .order-status {
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: capitalize;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-preparing { background: #e0e7ff; color: #3730a3; }
    .status-ready { background: #dcfce7; color: #166534; }
    .status-delivered { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* Modal */
    .modal { display: none; }
    .modal.show { display: block; background: rgba(0,0,0,0.7); }
</style>

<div style="margin-top:50px;" class="container">
    <div class="orders-header">
        <h1 class="orders-title">My Orders</h1>
        <a href="{{ route('user.packages') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Market
        </a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('M j, Y g:i A') }}</td>
                            <td>{{ count($order->items) }} item(s)</td>
                            <td>₦{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="order-status status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.show', $order->order_number) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button 
                                    class="btn btn-sm btn-warning change-status-btn"
                                    data-order="{{ $order->id }}"
                                    data-status="{{ $order->status }}">
                                    <i class="fas fa-edit"></i> Change Status
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state text-center p-5">
            <h3 class="fw-bold text-secondary mb-2">No Orders Yet</h3>
        </div>
    @endif
</div>


<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.update.order') }}">
        @csrf
        <input type="hidden" name="order_id" id="modal_order_id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="status" class="form-label">Select Status</label>
                <select class="form-select" name="status" id="modal_status">
                    <option value="pending">Under Review</option>
                    <option value="confirmed">Approved</option>
                    <option value="preparing">Preparing</option>
                    <option value="ready">Dispatched</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Denied</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = new bootstrap.Modal(document.getElementById('statusModal'));
        document.querySelectorAll('.change-status-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let orderId = this.dataset.order;
                let currentStatus = this.dataset.status;

                document.getElementById('modal_order_id').value = orderId;
                document.getElementById('modal_status').value = currentStatus;

                modal.show();
            });
        });
    });
</script>
@endsection
