<nav class="navbar navbar-custom navbar-fixed-top">
    <div class="container-fluid d-flex align-items-center" style="gap: 10px;">
        <button class="btn btn-primary toggle-btn-inside navbar-btn" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <a href="#" class="btn btn-default navbar-btn pull-right" id="profileToggle" style="border: none; background: none;">
            <i class="fas fa-user"></i>
            <span class="user-fullname">Hi, {{ Auth::user()->fullname }}, {{ Auth::user()->role }}</span>
        </a>
    </div>
</nav>

<div class="card d-block d-sm-none" id="profileCard" style="position: fixed; top: 80px; right: 10px; z-index: 1050; width: 300px; display: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-body text-center">
        <div class="profile-header">
            <i class="fas fa-user-circle" style="font-size: 50px; color: #4CAF50;"></i>
        </div>
        <h5 class="card-title mt-3" style="font-weight: bold;">{{ Auth::user()->fullname }}</h5>
        <p class="card-text" style="font-size: 14px; color: #666;">Role: {{ Auth::user()->role }}</p>

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}"> {{-- Ganti route('actionlogout') ke route('logout') --}}
            @csrf
            <button type="submit" class="btn btn-danger btn-sm w-100" style="border-radius: 25px;">
                <i class="fa fa-power-off"></i> Log Out
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileToggle = document.getElementById('profileToggle');
        const profileCard = document.getElementById('profileCard');

        // Fungsi untuk meng-toggle tampilan kartu profil
        function toggleProfileCard() {
            if (profileCard.style.display === 'none' || profileCard.style.display === '') {
                profileCard.style.display = 'block'; // Atau 'flex' jika Anda menggunakan flexbox untuk tata letak
            } else {
                profileCard.style.display = 'none';
            }
        }

        if (profileToggle) {
            profileToggle.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah browser melompat ke atas halaman
                toggleProfileCard();
            });
        }


        document.addEventListener('click', function(event) {
            const isClickInsideCard = profileCard.contains(event.target);
            const isClickOnToggle = profileToggle.contains(event.target);

            if (!isClickInsideCard && !isClickOnToggle && profileCard.style.display === 'block') {
                profileCard.style.display = 'none';
            }
        });
    });
</script>
