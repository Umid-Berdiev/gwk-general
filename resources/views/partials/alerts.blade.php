@if (session('success'))
<div class="alert alert-success text-center">
  {{ session('success') }}
  <button class="close" data-dismiss="alert" aria-label="close"><i class="bi bi-x"></i></button>
</div>
@endif

@if (session('warning'))
<div class="alert bg-warning text-center">
  {{ session('warning') }}
  <button class="close" data-dismiss="alert" aria-label="close"><i class="bi bi-x"></i></button>
</div>
@endif

@if ($errors->any())
<div class="small my-3">
  <ul class="list-group list-group-flush">
    @foreach ($errors as $error)
    <li class="list-group-item list-group-item-danger py-2">{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
