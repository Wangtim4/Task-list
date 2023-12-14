<?php

use App\Http\Requests\TaskRequest;
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
Route::view('/tasks/create' , 'create')->name('tasks.create');

Route::get('/tasks/{task}/edit' , function(Task $task) {
  
   return view('edit' , 
   ['task' => $task ]);
})->name('tasks.edit');

Route::get('/tasks/{task}' , function(Task $task) {
  
   return view('show' , ['task' => $task]);
})->name('tasks.show');


// 新增頁面的post
Route::post('/tasks' , function(TaskRequest $request) {
    
    // $data = $request->validated();
    // $task = new Task;
    // $task ->title = $data['title'];
    // $task ->description = $data['description'];
    // $task ->long_description = $data['long_description'];

    // $task->save();
    // 同上
    $task = Task::create($request->validated());

    return redirect()->route('tasks.show' , ['task' => $task->id])
    ->with('success' , 'Task created successfully!!');

})->name('tasks.store');

// 修改頁面
Route::put('/tasks/{task}' , function(Task $task , TaskRequest $request) {
    
    // $data = $request->validated();
    // $task ->title = $data['title'];
    // $task ->description = $data['description'];
    // $task ->long_description = $data['long_description'];

    // $task->save();
    // 同上
    $task->update($request->validated());

    return redirect()->route('tasks.show' , ['task' => $task->id])
    ->with('success' , 'Task updated successfully!!');

})->name('tasks.update');

// 刪除頁面
Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success' , 'Task deleted successfully!');
})->name('tasks.destroy');