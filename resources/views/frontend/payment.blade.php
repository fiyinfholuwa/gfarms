@extends('frontend.app')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:1.5rem;">

    <!-- Header Section -->
    <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h2 style="font-weight:700;color:#111827;font-size:1.5rem;">Payment History</h2>
        <button id="openFilterModal" 
            style="display:flex;align-items:center;gap:.5rem;padding:.7rem 1.2rem;
                background:linear-gradient(135deg,black,orange);
                color:#fff;border:none;border-radius:10px;
                font-weight:600;cursor:pointer;box-shadow:0 2px 5px rgba(99,102,241,.3);
                transition:all .2s;">
            <i class="fas fa-sliders-h"></i> Filters
        </button>
    </div>

    <!-- Search Bar -->
    <div style="margin-bottom:1.5rem;position:relative;">
        <i class="fas fa-search" style="position:absolute;top:50%;left:1rem;transform:translateY(-50%);color:#9ca3af;"></i>
        <input id="searchInput" type="text" placeholder="Search by reference, order, or gateway..."
            style="width:100%;padding:.8rem 1rem .8rem 2.8rem;
                border:2px solid #e2e8f0;border-radius:10px;
                background:#f9fafb;font-size:.9rem;
                transition:border-color .2s;">
    </div>

    <!-- Table Section -->
    @if($payments && $payments->count() > 0)
    <div style="overflow-x:auto;background:#fff;border-radius:14px;border:1px solid #e5e7eb;
                box-shadow:0 2px 6px rgba(0,0,0,.05);transition:all .3s;">
        <table style="width:100%;border-collapse:collapse;font-size:.9rem;">
            <thead>
                <tr style="background:#f3f4f6;color:#374151;text-transform:uppercase;font-size:.75rem;">
                    <th style="padding:1rem;text-align:left;">Reference</th>
                    <th style="padding:1rem;">Order</th>
                    <th style="padding:1rem;">Gateway</th>
                    <th style="padding:1rem;">Amount</th>
                    <th style="padding:1rem;">Status</th>
                    <th style="padding:1rem;">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="table-row" style="border-top:1px solid #f1f5f9;cursor:pointer;transition:background .2s;">
                    <td style="padding:1rem;font-weight:600;color:#1e293b;">{{ $payment->reference }}</td>
                    <td style="padding:1rem;">{{ ucfirst($payment->package) }}</td>
                    <td style="padding:1rem;">
                        <span style="padding:.3rem .6rem;border-radius:6px;background:#eef2ff;color:#4338ca;font-weight:600;">
                            {{ ucfirst($payment->gateway) }}
                        </span>
                    </td>
                    <td style="padding:1rem;font-weight:700;">₦{{ number_format($payment->amount,2) }}</td>
                    <td style="padding:1rem;">
                        <span style="
                            padding:.3rem .7rem;border-radius:9999px;font-size:.8rem;font-weight:600;
                            @if(strtolower($payment->status)=='success') background:#dcfce7;color:#166534;
                            @elseif(strtolower($payment->status)=='pending') background:#fef9c3;color:#854d0e;
                            @else background:#fee2e2;color:#991b1b; @endif
                        ">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td style="padding:1rem;color:#6b7280;">{{ $payment->created_at->format('M j, Y g:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:1.5rem;display:flex;justify-content:center;">
        {{ $payments->links('admin.paginate') }}
    </div>
    @else
    <div style="text-align:center;padding:3rem;background:#fff;border-radius:14px;box-shadow:0 2px 6px rgba(0,0,0,.05);">
        <i class="fas fa-credit-card" style="font-size:3rem;opacity:.4;margin-bottom:.8rem;"></i>
        <h3 style="font-size:1.3rem;color:#111827;">No Payment History</h3>
        <p style="color:#6b7280;">You haven’t made any payments yet.</p>
        <a href="{{ route('user.payment') }}" style="margin-top:1rem;display:inline-flex;align-items:center;gap:.5rem;
            padding:.7rem 1.2rem;background:linear-gradient(135deg,black,orange);
            color:#fff;border-radius:10px;font-weight:600;text-decoration:none;">
            <i class="fas fa-rotate-right"></i> Refresh
        </a>
    </div>
    @endif
</div>

<!-- Filter Modal -->
<div id="filterModal" style="
    position:fixed;top:0;left:0;width:100%;height:100%;
    background:rgba(17,24,39,.85);backdrop-filter:blur(3px);
    display:none;align-items:flex-end;justify-content:center;
    z-index:999;">
    <div style="background:#fff;padding:2rem;border-radius:20px 20px 0 0;
        width:100%;max-width:600px;max-height:90vh;overflow-y:auto;
        box-shadow:0 -4px 12px rgba(0,0,0,.2);animation:slideUp .3s ease;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h3 style="margin:0;font-size:1.2rem;font-weight:700;color:#111827;">Advanced Filters</h3>
            <span id="closeFilterModal" style="font-size:1.8rem;cursor:pointer;color:#6b7280;">&times;</span>
        </div>
        <form method="GET" action="{{ route('user.payment') }}" style="display:grid;gap:1rem;">
            <select name="status" style="padding:.8rem;border:1px solid #e5e7eb;border-radius:10px;">
                <option value="">All Statuses</option>
                <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
            </select>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <input type="date" name="date_from" value="{{ request('date_from') }}" style="flex:1;min-width:150px;padding:.8rem;border:1px solid #e5e7eb;border-radius:10px;">
                <input type="date" name="date_to" value="{{ request('date_to') }}" style="flex:1;min-width:150px;padding:.8rem;border:1px solid #e5e7eb;border-radius:10px;">
            </div>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <input type="number" name="amount_min" placeholder="Min amount" value="{{ request('amount_min') }}" style="flex:1;min-width:150px;padding:.8rem;border:1px solid #e5e7eb;border-radius:10px;">
                <input type="number" name="amount_max" placeholder="Max amount" value="{{ request('amount_max') }}" style="flex:1;min-width:150px;padding:.8rem;border:1px solid #e5e7eb;border-radius:10px;">
            </div>

            <div style="display:flex;justify-content:flex-end;gap:1rem;margin-top:1rem;">
                <a href="{{ route('user.payment') }}" style="padding:.7rem 1.2rem;border:1px solid #e5e7eb;border-radius:10px;color:#374151;text-decoration:none;">Clear</a>
                <button type="submit" style="padding:.7rem 1.2rem;background:linear-gradient(135deg,orange, black);
                    color:#fff;border:none;border-radius:10px;font-weight:600;">Apply</button>
            </div>
        </form>
    </div>
</div>

<style>
.table-row:hover { background:#f9fafb; }
@keyframes slideUp { from { transform:translateY(100%); } to { transform:translateY(0); } }
</style>

<script>
const modal=document.getElementById('filterModal');
document.getElementById('openFilterModal').onclick=()=>{modal.style.display='flex';document.body.style.overflow='hidden'};
document.getElementById('closeFilterModal').onclick=()=>{modal.style.display='none';document.body.style.overflow='auto'};
window.onclick=(e)=>{if(e.target===modal){modal.style.display='none';document.body.style.overflow='auto'}};

document.getElementById('searchInput').addEventListener('input',function(){
  const term=this.value.toLowerCase();
  document.querySelectorAll('.table-row').forEach(r=>{
    r.style.display=r.textContent.toLowerCase().includes(term)?'':'none';
  });
});
</script>
@endsection
