@extends('admin.app')

@section('content')
<div class="user-management-container">
    <!-- Table Container -->
    <div class="table-container">
        <div class="table-wrapper">
            <table id="my-table" class="modern-table display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="user-id">#{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info">
                                <div class="phone">{{ $user->phone ?? 'No phone' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge role-{{ strtolower($user->user_role ?? 'user') }}">
                                {{ ucfirst($user->user_role ?? 'user') }}
                            </span>
                        </td>
                        <td>
                            <div class="location-info">
                                <div class="country">{{ $user->country ?? 'N/A' }}</div>
                                @if($user->state)
                                <div class="state">{{ $user->state }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($user->has_verified_email ==='yes')
                                <span class="status-badge verified">
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>
                            @else
                                <span class="status-badge unverified">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Unverified
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- View -->
                                <a href="{{ route('admin.users.view', $user->id) }}" class="btn-action btn-view" 
                                       >
                                    <i class="fas fa-eye"></i>
                                </a>

                                
                                <!-- View Repayment -->
                                <a href="{{ route('admin.users.repayments', $user->id) }}" 
                                   class="btn-action btn-repayment" title="View Repayments">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>

<!-- Button to open modal -->
<a href="#" 
   class="btn-action btn-repayment"
   data-bs-toggle="modal"
   data-bs-target="#editAltModal_{{ $user->id }}"
   title="Edit Alternate Contact">
    <i class="fas fa-edit"></i>
</a>

<!-- Edit Modal -->
<div class="modal fade" id="editAltModal_{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.updateAltContact', $user->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Alternate Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="alt_email_{{ $user->id }}">Alternate Email</label>
                        <input type="email"
                               class="form-control"
                               id="alt_email_{{ $user->id }}"
                               name="alt_email"
                               value="{{ old('alt_email', $user->alt_email) }}"
                               placeholder="Enter alternate email">
                    </div>

                    <div class="form-group mb-3">
                        <label for="alt_phone_{{ $user->id }}">Alternate Phone</label>
                        <input type="text"
                               class="form-control"
                               id="alt_phone_{{ $user->id }}"
                               name="alt_phone"
                               value="{{ old('alt_phone', $user->alt_phone) }}"
                               placeholder="Enter alternate phone">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                                <!-- Delete -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action btn-delete" 
                                            onclick="return confirm('Are you sure you want to delete this user?')"
                                            title="Delete User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
/* Main Container */
.user-management-container {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

/* Table Container */
.table-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    padding:10px;
}

.table-wrapper {
    overflow-x: auto;
}

/* Modern Table Styles */
.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.modern-table thead {
    background: #f8fafc;
}

.modern-table th {
    padding: 1.5rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table td {
    padding: 1.25rem 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.modern-table tr:hover {
    background: #f9fafb;
    transition: background-color 0.2s ease;
}

/* User Info Styles */
.user-info {
    display: flex;
    align-items: center;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    margin-right: 0.75rem;
}

.user-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.user-email {
    font-size: 0.85rem;
    color: #6b7280;
}

.user-id {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #374151;
}

/* Badge Styles */
.role-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-admin {
    background: #fee2e2;
    color: #dc2626;
}

.role-user {
    background: #dbeafe;
    color: #2563eb;
}

.role-moderator {
    background: #fef3c7;
    color: #d97706;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge i {
    margin-right: 0.25rem;
    font-size: 0.7rem;
}

.verified {
    background: #d1fae5;
    color: #065f46;
}

.unverified {
    background: #fef2f2;
    color: #991b1b;
}

/* Location Info */
.location-info .country {
    font-weight: 500;
    color: #111827;
}

.location-info .state {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.1rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-view {
    background: #eff6ff;
    color: #2563eb;
}
.btn-view:hover {
    background: #dbeafe;
    transform: translateY(-1px);
}

.btn-edit {
    background: #f0fdf4;
    color: #16a34a;
}
.btn-edit:hover {
    background: #dcfce7;
    transform: translateY(-1px);
}

.btn-repayment {
    background: #fff7ed;
    color: #ea580c;
}
.btn-repayment:hover {
    background: #ffedd5;
    transform: translateY(-1px);
}

.btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.btn-delete:hover {
    background: #fee2e2;
    transform: translateY(-1px);
}
</style>



<script>
// ====== CONFIG ======
const rowsPerPage = 20; // number of rows per page

document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("my-table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    // --- Create search box ---
    const searchBox = document.createElement("input");
    searchBox.type = "text";
    searchBox.placeholder = "Search...";
    searchBox.classList.add("form-control");
    searchBox.style.margin = "1rem 0";
    table.parentNode.insertBefore(searchBox, table);

    // --- Create pagination container ---
    const pagination = document.createElement("div");
    pagination.classList.add("pagination-container");
    pagination.style.marginTop = "1rem";
    pagination.style.display = "flex";
    pagination.style.gap = "0.5rem";
    pagination.style.flexWrap = "wrap";
    table.parentNode.appendChild(pagination);

    let currentPage = 1;

    function renderTable() {
        const query = searchBox.value.toLowerCase();
        const filteredRows = rows.filter(row =>
            row.innerText.toLowerCase().includes(query)
        );

        // Pagination logic
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = filteredRows.slice(start, end);

        // Clear and re-append
        tbody.innerHTML = "";
        visibleRows.forEach(r => tbody.appendChild(r));

        // Render pagination buttons
        pagination.innerHTML = "";
        if (totalPages > 1) {
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.classList.add("page-btn");
                btn.style.padding = "0.4rem 0.8rem";
                btn.style.border = "1px solid #ddd";
                btn.style.borderRadius = "6px";
                btn.style.background = (i === currentPage) ? "#2563eb" : "#f3f4f6";
                btn.style.color = (i === currentPage) ? "white" : "#111827";
                btn.style.cursor = "pointer";

                btn.addEventListener("click", function () {
                    currentPage = i;
                    renderTable();
                });

                pagination.appendChild(btn);
            }
        }
    }

    // Initial render
    renderTable();

    // Re-render on search
    searchBox.addEventListener("input", function () {
        currentPage = 1; // reset to first page on search
        renderTable();
    });
});
</script>

@endsection
