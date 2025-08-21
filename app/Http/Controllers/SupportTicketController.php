<?php
namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    // List all tickets (admin)
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->get();
        return view('user.support', compact('tickets'));
    }

    // Store new ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'pending',
        ]);
        return GeneralController::sendNotification('', 'success', '', 'Support ticket created successfully.');
    }

    // Update (only if status is pending)
    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->status !== 'pending') {
            return GeneralController::sendNotification('', 'error', '', 'Only pending tickets can be updated.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket->update([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return GeneralController::sendNotification('', 'success', '', 'Ticket updated successfully.');
    }

    // Delete (only if status is pending)
    public function destroy($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->status !== 'pending') {
            return GeneralController::sendNotification('', 'error', '', 'Only pending tickets can be deleted.');
        }

        $ticket->delete();
        return GeneralController::sendNotification('', 'success', '', 'Ticket deleted successfully.');
    }
}

?>