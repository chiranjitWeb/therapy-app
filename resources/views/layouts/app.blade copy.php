<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'App' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  @livewireStyles
</head>
<body class="bg-light">
<div class="d-flex">
  <aside class="bg-white border-end" style="width:260px; min-height:100vh;">
    <div class="p-3 border-bottom">
      <h5 class="m-0">Therapy Admin</h5>
    </div>
    <nav class="p-3">
      <a class="d-block mb-2" href="{{ route('dashboard') }}">Dashboard</a>
      <a class="d-block mb-2" href="{{ route('calendar') }}">Calendar</a>
      <form class="mt-3" method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-secondary w-100">Logout</button>
      </form>
    </nav>
  </aside>
  <main class="flex-fill">
    <header class="bg-white border-bottom p-3">
      <h4 class="m-0">{{ $title ?? '' }}</h4>
    </header>
    <section class="p-4">
      {{ $slot }}
    </section>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
<script>
  // Lightweight toast bridge for Flasher/Livewire (UI only example)
  document.addEventListener('livewire:init', () => {
    Livewire.on('toast', ({type, message}) => {
      alert(type.toUpperCase()+': '+message); // Replace with Toastr init; Flasher Toastr handles real toasts server-side.
    });
  });
</script>
</body>
</html>
