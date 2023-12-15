@extends('layouts.app')
@section('title', $task->title)

@section('content')

<div class="mb-4">
    <a class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" href="{{route('tasks.index')}}">Go back to the task list!!</a>
</div >

    <p class="border border-gray-500 p-4 font-bold">{{ $task->description }}</p>


    @if ($task->long_description)
        <p class="bg-gray-500 text-white p-4">{{ $task->long_description }}</p>
    @endif

    <div class="m-4">
        <p class="text-sm text-slate-500">新增時間{{ $task->created_at }}  | 更新時間{{ $task->updated_at }}
         | @if ($task->completed)
            完成
        @else
            未完成
        @endif
        </p>
    </div>

    
    </p>

    

    <div class="flex gap-5" >
        
        <form method="POST" action="{{route('tasks.toggle-complete' , ['task'=>$task])}}">
            @csrf
            @method('PUT')
            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                Mark as {{ $task->completed ? 'not completed' : 'completed'}}
            </button>
        </form>        
    
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('tasks.edit', ['task' => $task]) }}">Edit</a>
    
        <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
@endsection
