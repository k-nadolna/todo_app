<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To Do App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>

@auth
<div class="bg-light m-5 p-4 border rounded" >
  <x-nav>
  </x-nav>
  
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="d-flex justify-content-between my-2">
        <h3>Your to do list:</h3>
        <form action="{{ route('tasks.completed.destroy') }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn btn-outline-secondary">
            <i class="bi bi-trash3 pe-2"></i>
            Remove completed</button>
        </form>
      </div>
      
    <div class="bg-white border rounded-3 p-2">
      <table class="w-100  table-hover">
        {{-- default value for sorting --}}
         @php
                    $sortBy = $sortBy ?? '';
                    $direction = $direction ?? '';
                    @endphp
        <thead class="border-bottom">
          <tr>
            <th>
             <h4>Status</h4>
             <div>
              <form method="GET" action="{{route('tasks.index')}}" id='filterForm'>
                <select class="form-select border border-secondary" name="status" id="status" onchange="document.getElementById('filterForm').submit();">
                  <option value="">all tasks</option>
                  <option value="0" {{ request('status') === '0' ? 'selected' : ''}}>to be done</option>
                  <option value="1" {{ request('status') === '1' ? 'selected' : ''}}>done</option>
                </select>
              
             </div>
            </th>
            <th> 
              <div class="d-flex"> 
                <div>
                  <a href="{{ route('tasks.index', [
                    'sort_by' => 'title',
                    'direction' => ($sortBy === 'title' && $direction === 'asc') ? 'desc' : 'asc'
                  ])}}" class="btn btn-sm btn-outline-secondary" title="Sortuj">

                  @if ($sortBy === 'title' && $direction === 'asc')
                    <i class="bi bi-caret-down-fill"></i>
                  @elseif ($sortBy === 'title' && $direction === 'desc')
                    <i class="bi bi-caret-up-fill"></i>
                  @else
                    <i class="bi bi-arrow-down-up"></i> {{-- default icon --}}
                  @endif

                  </a>

                </div>
                <h4 class="ms-2">Task</h4>
              </div>
              <div>
                
                  <select class="form-select border border-secondary" name="important" id="important" onchange="document.getElementById('filterForm').submit();">
                    <option value="" >all tasks</option>
                    <option value="0" {{request('important') === '0' ? 'selected' : ''}}>no important</option>
                    <option value="1" {{request('important') === '1' ? 'selected' : ''}}>important</option>
                  </select>
                </form>
              </div>
            </th>
            <th class='d-flex'>
              <div class="d-flex">
                
                <div>   
                  <a href="{{ route('tasks.index', [
                    'sort_by' => 'date',
                    'direction' => ($sortBy === 'date' && $direction === 'asc') ? 'desc' : 'asc'
                    ]) }}" class="btn btn-sm btn-outline-secondary" title="Sortuj">
                  
                    @if ($sortBy === 'date' && $direction === 'asc')
                      <i class="bi bi-caret-down-fill"></i>
                    @elseif ($sortBy === 'date' && $direction === 'desc')
                      <i class="bi bi-caret-up-fill"></i>
                    @else
                      <i class="bi bi-arrow-down-up"></i> {{-- default icon --}}
                    @endif
                  </a>   
                </div>
                <h4 class="ms-2">Deadline</h4>
              </div>
              
            </th>
            <th></th>
            <th></th>
          </tr>

        </thead>
        <tbody>
          @foreach ($tasks as $task)
        <tr class=" border-bottom align-middle {{ $task->completed === 1 ? 'table-secondary' : 'table-white'}}">
          <td class="p-3">
            <form action="{{route('tasks.complete', ['task' => $task->id, 'sort_by' => $sortBy, 'direction' => $direction])}}" METHOD="POST">
              @csrf
              @method('PUT')
              @if($task['completed'] === 1)
                <button class="btn btn-secondary">
                  <i class="bi bi-check-lg"></i> 
                </button>  
              
              @else
              <button class="btn btn-outline-secondary">
                <i class="bi bi-check-lg"></i> 
              </button> 
              @endif

            </form>
           
          </td>
          <td class="mx-2 p-3">
            {{-- @if ($task->important)
  @endif --}}
            <h4 class="{{ $task->important ? 'text-warning' : 'text-black' }}">{{$task['title']}}</h4>
          </td>
          <td>{{$task['date']}}</td>
          <td>
            <form action="{{ route('tasks.edit', $task->id)}}" method="GET">
              @csrf
              <button class="btn btn-outline-secondary">
                <i class="bi bi-pencil"></i>
              </button>
            </form>
          </td>
          <td>
            <form action="{{ route('tasks.destroy', $task->id)}}" METHOD="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-secondary">
                <i class="bi bi-trash3"></i>
              </button>
            </form>
          
          </td>
        </tr>
        @endforeach

        </tbody>
        
      </table>
    </div>
      
   
    </div>
    <div class="col-12 col-lg-4">
      <h3>Add a new task:</h3>
      <form action="{{ route('tasks.store')}}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="task name"
        class="form-control my-1 @error('title') border-danger @enderror"
        value="{{ old('title') }}">
        <input type="date" name="date" class="form-control my-1 @error('date') border-danger @enderror" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
        <div class="form-check form-switch my-1">
          <input class="form-check-input" type="checkbox" id="important" name="important" value="1">
          <label class="form-check-label" for="important">important</label>
      </div>
        <div class="text-end my-2">
          <button class="btn btn-outline-secondary">Add task</button>
        </div>
      </form>
    </div>
  </div>
 
</div>

@else

<div class="bg-light m-5 p-4 border rounded row" >
  <h1 class="mb-4 pb-3 border-bottom">To Do App</h1>
  <div class="col-12 col-lg-6 pe-lg-5">
    <h3 class="mb-3">Login</h3>
    <form action="{{ route('login')}}" method="POST">
    @csrf
      <input class="form-control my-1" type="text" name="loginname" placeholder="name">
      <input class="form-control my-1" type="password" name="loginpassword" placeholder="password">
      <div class=" d-flex justify-content-end">
        <button class="btn btn-outline-secondary my-1">Login</button>
      </div>
    </form>
  </div>
  <div class="col-12 col-lg-6 ps-lg-5">
    <h3 class="mb-3">Register</h3>
    <form action="{{ route('register')}}" method="POST">
    @csrf
      <input class="form-control my-1" type="text" name="name" placeholder="name">
      <input class="form-control my-1" type="email" name="email" placeholder="email">
      <input class="form-control my-1" type="password" name="password" placeholder="password">
      <div class=" d-flex justify-content-end">
        <button class="btn btn-outline-secondary my-1">Register</button>
      </div>
    </form>
  </div>
</div>

@endauth

 



  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>