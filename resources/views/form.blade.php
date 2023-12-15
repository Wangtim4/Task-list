@extends('layouts.app')

{{-- 盼東新增還是修改 --}}
@section('title', isset($task) ? 'Edit Task' : 'Add Task')

{{-- 加入樣式 --}}
@section('styles')
    <style>
        .error-message{
            color: red;
            font-size: 1rem;        }
    </style>
@endsection

@section('content')

    {{-- 顯示錯誤 --}}
    {{-- {{ $errors }} --}}

    <form action="{{ isset($task) ? route('tasks.update' , ['task' => $task->id]) : route('tasks.store') }}" method="post">
        {{-- 防止惡意攻擊 --}}
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">Title</label>
            <input type="text" name="title" id="title"
            @class(['border-red-500' => $errors->has('title')])
            value="{{$task->title ?? old('title') }}">
            @error('title')
                <p class ="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description">Description</label>
            <textarea name="description" id="description" 
            @class(['border-red-500' => $errors->has('description')])
            rows="5">{{ $task->description ?? old('description') }}</textarea>
            @error('description')
                <p class ="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea name="long_description" id="long_description" 
            @class(['border-red-500' => $errors->has('long_description')])
            rows="10">{{ $task->long_description ?? old('long_description') }}</textarea>

        </div>
        @error('long_description')
            <p class ="error">{{ $message }}</p>
        @enderror

        <div class="flex gap-2 items-center">
            <button class="btn" type="submit">
                @isset($task)
                    Updated Task
                @else
                    Add Task
                @endisset
            </button>
            <a href="{{route('tasks.index')}}">Cancel</a>
        </div>
    </form>

@endsection
