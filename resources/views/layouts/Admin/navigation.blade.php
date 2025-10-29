<section id="sidebar">
	<a href="{{ route('dashboard') }}" class="brand">
		<img src="{{ asset('images/logo.png') }}" alt="YBANAGIFY Logo" style="height: 60px; margin-right: 10px;">
		<span class="text">YBANAGIFY</span>
	</a>

	<ul class="side-menu top">
		<li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
			<a href="{{ route('dashboard') }}">
				<i class='bx bxs-dashboard'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.entries.*') || request()->routeIs('admin.translations.*') || request()->routeIs('admin.dictionary.*') ? 'active' : '' }}">
			<a href="{{ route('admin.entries.index') }}">
				<i class='bx bx-book-content'></i>
				<span class="text">Manage Entries</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
			<a href="{{ route('admin.gallery.index') }}">
				<i class='bx bx-image'></i>
				<span class="text">Manage Content</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.visitor_logs.index') ? 'active' : '' }}">
			<a href="{{ route('admin.visitor_logs.index') }}">
				<i class='bx bx-table'></i>
				<span class="text">Visitor Logs</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
			<a href="{{ route('admin.analytics') }}">
				<i class='bx bxs-doughnut-chart'></i>
				<span class="text">Analytics</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.feedbacks.*') || request()->routeIs('admin.feedbacks.*') ? 'active' : '' }}">
			<a href="{{ route('admin.feedbacks.index') }}">
				<i class='bx bx-comment-dots'></i>
				<span class="text">Feedbacks</span>
			</a>
		</li>
        <li class="{{ request()->routeIs('admin.submissions.index') ? 'active' : '' }}">
            <a href="{{ route('admin.submissions.index') }}">
                <i class='bx bxs-send'></i>
                <span class="text">Submissions</span>
            </a>
        </li>
		<li class="{{ request()->routeIs('admin.team.index') ? 'active' : '' }}">
			<a href="{{ route('admin.team.index') }}">
				<i class='bx bx-group'></i>
				<span class="text">Team</span>
			</a>
		</li>
		<!-- Add more menu items here -->
	</ul>

	<!-- <ul class="side-menu">
		<li>
			<a href="{{ route('profile.edit') }}">
				<i class='bx bxs-cog'></i>
				<span class="text">Settings</span>
			</a>
		</li>
		<li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" class="logout" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </form>
		</li>
	</ul> -->
</section>
