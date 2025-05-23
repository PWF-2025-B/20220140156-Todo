<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
   public function index()
{
    $todos = Todo::with('category')
        ->where('user_id', Auth::id())
        ->orderBy('is_done', 'asc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $todosCompleted = Todo::where('user_id', Auth::id())
        ->where('is_done', true)
        ->count();

    return view('todo.index', compact('todos', 'todosCompleted'));
}

   public function create()
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to create tasks.');
    }

 
    $categories = Category::all();
    return view('todo.create', compact('categories'));
}

    public function edit(Todo $todo)
    {
        // Memastikan todo ini milik pengguna yang sedang login
        if (Auth::user()->id != $todo->user_id) {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }

        $categories = Category::all(); // Semua kategori
        return view('todo.edit', compact('todo', 'categories'));
    }

    public function update(Request $request, Todo $todo)
    {
        // Validasi data yang diterima
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Memastikan todo ini milik pengguna yang sedang login
        if (Auth::user()->id != $todo->user_id) {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to update this todo!');
        }

        // Update todo
        $todo->update([
            'title' => $request->title,
            'category_id' => $request->category_id ?? null, // Pastikan category_id nullable
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Memastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to create tasks.');
        }

        // Membuat todo baru
        Todo::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'category_id' => $request->category_id ?? null, // Menyimpan null jika category_id kosong
            'is_done' => false, // Pastikan ini sesuai dengan field yang ada pada tabel
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created.');
    }

    public function complete(Todo $todo)
    {
        // Memastikan todo ini milik pengguna yang sedang login
        if (Auth::user()->id == $todo->user_id) {
            $todo->update(['is_done' => true]);
            return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
        }
    }

    public function uncomplete(Todo $todo)
    {
        // Memastikan todo ini milik pengguna yang sedang login
        if (Auth::user()->id == $todo->user_id) {
            $todo->update(['is_done' => false]);
            return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
        }
    }

    public function destroy(Todo $todo)
    {
        // Memastikan todo ini milik pengguna yang sedang login
        if (Auth::user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }

    public function destroyCompleted()
    {
        // Memastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to delete tasks.');
        }

        // Mengambil semua todo yang selesai dari pengguna yang sedang login
        $todosCompleted = Todo::where('user_id', Auth::user()->id)
            ->where('is_done', true)
            ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}