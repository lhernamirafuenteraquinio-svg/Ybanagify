<nav>
	<!-- <i class='bx bx-menu'></i>
	<a href="#" class="nav-link">Categories</a> -->
    <i class='bx bx-menu'></i>
    <a class="nav-link">
        Welcome back, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>!
    </a>


	<!-- <form action="#">
		<div class="form-input">
			<input type="search" placeholder="Search...">
			<button type="submit" class="search-btn">
				<i class='bx bx-search'></i>
			</button>
		</div>
	</form> -->

    <form action="{{ route('admin.global-search') }}" method="GET" class="d-flex">
        <div class="form-input">
            <input 
                type="search" 
                name="query" 
                placeholder="Search ..." 
                value="{{ request()->query('query') }}">
            <button type="submit" class="search-btn">
                <i class='bx bx-search'></i>
            </button>
        </div>
    </form>

	<input type="checkbox" id="switch-mode" hidden>
	<label for="switch-mode" class="switch-mode"></label>

	<!-- Notifications -->
    <!-- <a href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">{{ $notificationsCount ?? 0 }}</span>
    </a> -->

<!-- Profile Menu -->
<div class="profile-dropdown">
    <a href="#" class="profile" id="profileToggle">
        <img 
            src="{{ Auth::user()->profile_picture_url }}" 
            alt="Profile" 
            class="profile-img"
        >
    </a>

    <ul class="dropdown-menu" id="dropdownMenu">
        <!-- Profile Info Section -->
        <li class="profile-info">
            <img 
                src="{{ Auth::user()->profile_picture_url }}" 
                alt="Profile" 
                class="profile-img-large"
            >
            <div class="profile-details">
                <strong>{{ Auth::user()->name }}</strong>
                <small>{{ Auth::user()->email }}</small>
            </div>
        </li>
        <hr>
        <!-- Menu Links -->
        <li>
            <a href="{{ route('admin.backup.index') }}">
                <i class='bx bxs-shield'></i> Backup & Maintenance
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}">
                <i class='bx bxs-cog'></i> Settings
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class='bx bxs-log-out-circle'></i> Logout
                </a>
            </form>
        </li>
    </ul>
</div>

<style>
.profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-dropdown .profile-img {
    max-width: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid var(--grey);
    object-fit: cover;
    transition: transform 0.2s;
}

.profile-dropdown .profile-img:hover {
    transform: scale(1.05);
}

.profile-dropdown .dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 110%;
    background: var(--light);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    min-width: 220px;
    z-index: 100;
    overflow: hidden;
    animation: dropdownFade 0.2s ease;
}

@keyframes dropdownFade {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}

.profile-dropdown .dropdown-menu li {
    list-style: none;
}

.profile-dropdown .dropdown-menu li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    color: var(--dark);
    font-size: 14px;
    text-decoration: none;
    transition: background 0.3s;
}

.profile-dropdown .dropdown-menu li a:hover {
    background-color: var(--grey);
}

/* Profile Info Section */
.profile-dropdown .profile-info {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    background: var(--grey);
    border-bottom: 1px solid #ccc;
}

.profile-dropdown .profile-img-large {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}

.profile-dropdown .profile-details strong {
    display: block;
    color: var(--dark);
    font-size: 14px;
}

.profile-dropdown .profile-details small {
    color: #666;
    font-size: 12px;
}

.profile-dropdown hr {
    margin: 0;
    border: none;
    border-top: 1px solid #ddd;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('profileToggle');
    const menu = document.getElementById('dropdownMenu');

    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
});
</script>

</nav>
