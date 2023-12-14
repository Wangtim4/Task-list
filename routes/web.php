<?php

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/' , function() {
  return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index' , [
        'tasks'=>Task::latest()->get()
    ]);
})->name('tasks.index');

// 建新增頁面的route
Route::view('/tasks/create' , 'create');

Route::get('/tasks/{id}/edit' , function($id) {
  
   return view('edit' , 
   ['task' => Task::findOrFail($id)]);
})->name('tasks.edit');

Route::get('/tasks/{id}' , function($id) {
  
   // 顯示
   // 直接使用model的資料
   return view('show' , ['task' => Task::findOrFail($id)]);
})->name('tasks.show');

// 修改頁面
Route::put('/tasks/{id}' , function($id , Request $request) {
    $data = $request->validate([
        'title' => 'required | max:255',
        'description' => 'required',
        'long_description' => 'required',
    ]);

    $task = Task::findOrFail($id);
    $task ->title = $data['title'];
    $task ->description = $data['description'];
    $task ->long_description = $data['long_description'];

    $task->save();
    return redirect()->route('tasks.show' , ['id' => $task->id])
    ->with('success' , 'Task updated successfully!!');

})->name('tasks.update');

// 新增頁面的post
Route::post('/tasks' , function(Request $request) {
    $data = $request->validate([
        'title' => 'required | max:255',
        'description' => 'required',
        'long_description' => 'required',
    ]);

    $task = new Task;
    $task ->title = $data['title'];
    $task ->description = $data['description'];
    $task ->long_description = $data['long_description'];

    $task->save();
    return redirect()->route('tasks.show' , ['id' => $task->id])
    ->with('success' , 'Task created successfully!!');

})->name('tasks.store');