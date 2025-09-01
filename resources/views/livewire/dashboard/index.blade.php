<section class="dashboard-section">

  <div class="graph-wrapper">
     <div class="column user-accounts">
        <div class="heading">
          {{ $totalUsers }}<span>Użytkowników</span>
        </div>
        <div class="graph"><img src="{{ asset('assets/img/graph-01.svg') }}" alt=""></div>
     </div>
     <div class="column specialists">
        <div class="heading">
          {{ $totalTherapists }} <span>Specjalistów</span>
        </div>
        <div class="graph"><img src="{{ asset('assets/img/graph-02.svg') }}" alt=""></div>
     </div>
     <div class="column total-earnings">
        <div class="heading">
           1458,45 zł <span>Łączny zarobek na nadwyżkach</span>
        </div>
        <div class="graph"><img src="{{ asset('assets/img/graph-03.svg') }}" alt=""></div>
     </div>
  </div>

  <div class="new-users-wrapper">
   <div class="filter-box">
       <div class="field search-container">
           <input type="search" wire:model.live="search" placeholder="Wyszukaj">
           <div class="search-icon icon-default">
               <i class="las la-search"></i>
           </div>
           <div class="search-icon icon-focus">
               <i class="las la-angle-left"></i>
           </div>
       </div>
       <div class="field">
           <input type="text" name="checkIn" id="datepicker01" class="calendar" placeholder="Data od" min="">
       </div>
   </div>
   <div class="table-box">
       <table>
           <thead>
               <tr>
                   <th>Imię</th>
                   <th>Nazwisko</th>
                   <th>Uzależnienie</th>
                   <th>Spotkania</th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
               @forelse($users as $u)
               <tr>
                
                   <td data-column="Imię">{{ $u->first_name }}</td>
                   <td data-column="Nazwisko">{{ $u->last_name }}</td>
                   <td data-column="Uzależnienie">{{ $u->addiction?->name ?? 'None' }}</td>
                   <td data-column="Spotkania">{{ $u->meetings_count }}</td>
                   <td data-column="">
                       <a href="#" class="view-button" role="button">
                           <i class="las la-arrow-right"></i>
                       </a>
                   </td>
               </tr>
               @empty
               <tr>
                   <td colspan="5" class="text-center py-4">No users found</td>
               </tr>
               @endforelse
           </tbody>
       </table>
       <div class="card-footer bg-white">
           {{ $users->links() }}
       </div>
   </div>
</div>

</section>
