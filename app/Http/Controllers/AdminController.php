<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;


use App\Models\KycLevel;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function admin_dashboard()
    {
        $recent_orders = Order::latest()->paginate(10);
    
        $total_orders   = Order::count();
        $total_users    = User::count();
        $total_revenues = Payment::sum('amount');
        $total_products = Food::count();
    
        return view('admin.dashboard', [
            'recent_orders'  => $recent_orders,
            'total_orders'   => $total_orders,
            'total_users'    => $total_users,
            'total_revenues' => $total_revenues,
            'total_products' => $total_products,
        ]);
    }
    

    public function product_view()
    {
        $categories = Category::all();

        return view('admin.product_add', compact('categories'));
    }
    public function product_edit($id)
    {
        $food = Food::where('id', $id)->first();
        $categories = Category::all();

        return view('admin.product_edit', compact('categories',  'food'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|string',
            'amount'          => 'required|string',
            'short_description' => 'nullable|string',
            'full_description'  => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $dir = public_path('uploads/foods');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($dir, $imageName);
            $imagePath = 'uploads/foods/' . $imageName;
        }

        // Generate Unique Slug
        $slug = Str::slug($request->name);

        // Save Food
        Food::create([
            'name'              => $request->name,
            'category'          => $request->category,
            'amount'          => $request->amount,
            'slug'              => $slug,
            'image'             => $imagePath,
            'short_description' => $request->short_description,
            'full_description'  => $request->full_description,
        ]);

        $notification = array(
            'message' => 'Food added successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function product_all()
    {
        $foods = Food::latest()->get();
        return view('admin.product_all', compact('foods'));
    }


    public function product_delete($id)
    {
        $food = Food::findOrFail($id);

        // Delete image if it exists
        $imagePath = public_path('uploads/foods/' . $food->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $food->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }


    public function product_update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|string',
            'short_description' => 'nullable|string',
            'amount'            => 'required|numeric',
            'full_description'  => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $food = Food::findOrFail($id);

        // Generate unique slug based on name
        // Generate slug based on name
        $slug = Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;

        while (
            Food::where('slug', $slug)
            ->where('id', '!=', $id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }
        // Ensure unique slug (ignoring current record)
        $count = Food::where('slug', 'like', "{$slug}%")
            ->where('id', '!=', $id)
            ->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($food->image && file_exists(public_path($food->image))) {
                unlink(public_path($food->image));
            }

            $image      = $request->file('image');
            $extension  = $image->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $directory  = public_path('uploads/foods');

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $image->move($directory, $fileName);
            $food->image = 'uploads/foods/' . $fileName;
        }

        // Update fields
        $food->name              = $request->name;
        $food->slug              = $slug;
        $food->category          = $request->category;
        $food->short_description = $request->short_description;
        $food->amount            = $request->amount;
        $food->full_description  = $request->full_description;

        $food->save();

        $notification = array(
            'message' => 'Food Updated successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('foods.all')->with($notification);
    }


    public function category_view()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function category_add(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $url_slug = strtolower($request->name);
        $label_slug = preg_replace('/\s+/', '-', $url_slug);

        $category = new Category;
        $category->name = $request->name;
        $category->category_url = $label_slug;
        $category->save();
        $notification = array(
            'message' => 'Category Sucessfully saved',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function category_delete($id)
    {
        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Category Successfully Deleted',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function category_update(Request $request, $id)
    {
        $category_update = Category::findOrFail($id);
        $url_slug = strtolower($request->name);
        $label_slug = preg_replace('/\s+/', '-', $url_slug);

        $category_update->name = $request->name;
        $category_update->category_url = $label_slug;
        $category_update->save();

        $notification = array(
            'message' => 'Category Successfully Updated',
            'alert-type' => 'success'
        );
        return redirect()->route('category.view')->with($notification);
    }


    public function admin_orders()
    {
        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.orders', compact('orders'));
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status'   => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);
            $order->status = $request->status;
            $order->save();

            $notification = [
                'message'    => 'Order status updated successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message'    => 'Failed to update status. ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }


    public function admin_order_show($order)
    {

        $order = Order::where('order_number', '=', $order)->first();
        return view('admin.orders_detail', compact('order'));
    }

    public function payment_admin(Request $request)
    {
        // Start with query builder
        $query = Payment::query();
    
        // Apply filters dynamically
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }
    
        if ($request->filled('package')) {
            $query->where('package', $request->package);
        }
    
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
    
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
    
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
    
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }
    
        // Get payments with pagination
        $payments = $query->orderBy('created_at', 'desc')->paginate(15);
    
        // Calculate statistics
        $totalAmount = Payment::where('status', 'success')->sum('amount');
        $totalPayments = Payment::count();
        $successfulPayments = Payment::where('status', 'success')->count();
    
        return view('admin.payment', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }


    public function kyc_level()
    {
        $levels = KycLevel::all();
        return view('admin.kyc_level', compact('levels'));
    }
    public function manage_user()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function update_kyc_level(Request $request, $key)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'repayment_period' => 'nullable|string',
            'credit_limit' => 'nullable|string',
            'credit_amount_limit' => 'required|integer|min:0',
        ]);

        $level = KycLevel::where('key', $key)->firstOrFail();

        $level->update($request->only([
            'title',
            'description',
            'repayment_period',
            'credit_limit',
            'credit_amount_limit',
        ]));

        return GeneralController::sendNotification('', 'success', '', 'KYC Level updated successfully!');
    }
    
}
