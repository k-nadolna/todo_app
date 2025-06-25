<div class="d-flex  border-bottom justify-content-between align-items-center mb-4 pb-3">
  {{ $slot}}
    <h2 class="">Hello {{auth()->user()->name}} </h2>
    <form action="{{ route('logout')}}" method="POST">
      @csrf
      <button class="btn btn-outline-secondary">Log out</button>
    </form>
</div>