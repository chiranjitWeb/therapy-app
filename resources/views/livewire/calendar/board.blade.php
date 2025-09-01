<div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <input type="date" class="form-control" style="max-width: 240px;" wire:model.change="day" wire:change="loadDay">
    <div class="d-flex gap-2">
      <button class="btn btn-primary" onclick="addSlot()">Add availability (+1h)</button>
    </div>
  </div>

  <div class="list-group">
    @foreach($slots as $slot)
      <div class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong>#{{ $slot['id'] }}</strong> — {{ $slot['starts_at'] }} → {{ $slot['ends_at'] }}
          <span class="badge text-bg-info">{{ $slot['status'] }}</span>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-sm btn-outline-secondary" onclick="moveSlot({{ $slot['id'] }})">Move +30m</button>
        </div>
      </div>
    @endforeach
  </div>

  <script type="module">
    window.addSlot = () => {
      const day = @this.get('day');
      const start = new Date(day + 'T09:00:00');
      const end = new Date(start.getTime() + 60*60*1000);
      @this.addAvailability(start.toISOString(), end.toISOString());
    };

    window.moveSlot = (id) => {
      const s = prompt('New start (YYYY-MM-DD HH:MM):');
      if (!s) return;
      const start = new Date(s.replace(' ', 'T') + ':00');
      const end = new Date(start.getTime() + 30*60*1000);
      @this.moveAvailability(id, start.toISOString(), end.toISOString());
    };
  </script>
</div>
