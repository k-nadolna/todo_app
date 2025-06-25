<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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

     public function complete(Task $task){
        if($task['completed'] === 0){
            $task['completed'] = 1;
        }else{
             $task['completed'] = 0;
        } 

        $task->update();

        return redirect('/');
    }

    public function destroyCompleted(){
       $user = auth()->id();
       Task::where('completed', 1)->where('user_id', $user)->delete();

       return redirect('/');
    }

}
