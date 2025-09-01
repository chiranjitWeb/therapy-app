     <!-- Toast container -->
     <div class="toast-container" id="toast-container"></div>
    
     <!-- Hidden element with server-side data -->
     <div id="toast-data" style="display: none;"
          data-toast="@if(session()->has('toast')){{ json_encode(session('toast')) }}@endif"
          data-errors="@if($errors->any()){{ json_encode($errors->all()) }}@endif">
     </div>
     <script src="{{ asset('assets/js/custom-new.js') }}"></script>
     @livewireScripts
</body>

</html>