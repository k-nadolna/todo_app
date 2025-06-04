<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
{       
    $sortBy = $request->get('sort_by', 'date');
    $direction = $request->get('direction', 'asc');
    $statusFilter = $request->get('status');
    $importantFilter = $request->get('important');

    $query = Task::where('user_id', auth()->id());

    if($statusFilter !== null){
        $query->where('completed', $statusFilter);
    }

    if($importantFilter !== null){
        $query->where('important', $importantFilter);
    }

    $tasks = $query->orderBy($sortBy, $direction)->get();

    return view('home', compact('tasks', 'sortBy', 'direction', 'statusFilter', 'importantFilter'));
}

    

    public function store(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'date' => 'required',
           
        ]);

        $incomingFields['important'] = $request->has('important') ? 1 : 0;

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['date'] = strip_tags($incomingFields['date']);
        $incomingFields['user_id'] = auth()->id();
        Task::create($incomingFields);

        return redirect('/');
    }
    
    public function edit(Task $task){
        if(auth()->user()->id != $task['user_id']){
            return redirect('/');
        }

        return view('edit-task', ['task' => $task]);
    }

    public function update(Task $task, Request $request){
        if (auth()->user()->id !== $task['user_id']) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'date' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['date'] = strip_tags($incomingFields['date']);

        $incomingFields['important'] = $request->has('important') ? 1 : 0;

        $task->update($incomingFields);

        return redirect('/');
    }

     public function destroy(Task $task){
        if(auth()->user()->id === $task['user_id']){
            $task->delete();
        }
     
        return redirect('/');
    }

     public function complete(Request $request, Task $task){
        if($task['completed'] === 0){
            $task['completed'] = 1;
        }else{
             $task['completed'] = 0;
        } 

        $task->update();

        return redirect()->route('tasks.index', [
        'sort_by' => $request->get('sort_by', 'date'),
        'direction' => $request->get('direction', 'asc'),
]);
    }

    public function destroyCompleted(){
       $user = auth()->id();
       Task::where('completed', 1)->where('user_id', $user)->delete();

       return redirect('/');
    }

}
