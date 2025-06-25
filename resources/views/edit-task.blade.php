<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit task</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
  <div class="bg-light m-5 p-4 border rounded">
    <x-nav>
    </x-nav>
  <div class="bg-light m-5 p-4 border rounded w-50 mx-auto" >
        <div class="border-bottom py-2 d-flex justify-content-between">
          <h3>Change the task</h3>
          <a href="{{route('dashboard')}}" class="btn btn-outline-secondary">Cancel</a>
        </div>
        
        <div>
          <form action="{{ route('tasks.update', $task->id)}}" method="POST">
          @csrf 
          @method('PUT')
          <input class="form-control my-2 @error ('title') is-invalid @enderror" type="text" name="title"  value="{{$task->title}}">
          <input class="form-control my-2 @error ('date') is-invalid @enderror" type="date" name="date">
          <div class="form-check form-switch my-1">
            <input class="form-check-input" type="checkbox" id="important" name="important" value="1">
            <label class="form-check-label" for="important">important</label>
          </div>
          <div class="text-end my-3">
            <button class="btn btn-secondary">Save</button>
          </div>
          </form>
        </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>