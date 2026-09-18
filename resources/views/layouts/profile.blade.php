<li class="nav-item user-profile">
	<div class="profile-toggle" tabindex="0" role="button" aria-haspopup="true" aria-expanded="false">
		<div class="user-profile-inline">
			<div class="avatar-wrap">
				<img src="{{ auth()->user()?->profile_photo_url ?? asset('assets/images/user/avatar-2.jpg') }}" alt="avatar" />
				<span class="online-dot"></span>
			</div>
			<div class="user-info">
				<strong>{{ auth()->user()?->name ?? 'User' }}</strong>
				<small>{{ auth()->user()?->role ?? '' }}</small>
			</div>
			<span class="profile-arrow">▾</span>
		</div>
	</div>

	<div class="profile-dropdown" aria-hidden="true">
		<div class="profile-dropdown-inner">
			<div class="profile-header d-flex align-items-center">
				<div class="me-3"><div class="dropdown-avatar"><img src="{{ auth()->user()?->profile_photo_url ?? asset('assets/images/user/avatar-2.jpg') }}" alt="user-image"></div></div>
				<div>
					<div class="profile-name">{{ auth()->user()?->name ?? 'User' }}</div>
					<div class="profile-role">{{ auth()->user()?->role ?? '' }}</div>
				</div>
			</div>
			<div class="divider"></div>
				<ul class="profile-menu list-unstyled mb-0">
					<li><a href="{{ url('view-profile') }}" class="profile-item"><i class="ti ti-user me-2"></i> <span>Profile Saya</span></a></li>
					<li><a href="/change-password" class="profile-item"><i class="ti ti-lock me-2"></i> <span>Ubah Password</span></a></li>
				</ul>
				<div class="divider"></div>
				<a href="{{ url('settings') }}" class="profile-item profile-settings"><i class="ti ti-settings me-2"></i> Pengaturan</a>
				<div class="divider"></div>
				<form action="{{ route('logout') }}" method="POST" class="mb-0" id="logoutForm">
					@csrf
					<button type="submit" class="profile-logout"><span class="profile-item"><i class="ti ti-power me-2"></i> Logout</span></button>
				</form>
		</div>
	</div>
</li>

<div class="logout-modal" id="logoutModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
	<div class="logout-modal-backdrop" data-logout-cancel></div>
	<div class="logout-modal-card" role="document">
		<div class="logout-modal-icon" aria-hidden="true"><i class="ti ti-power"></i></div>
		<div class="logout-modal-content">
			<h2 id="logoutModalTitle">Keluar dari SIM-KOP?</h2>
			<p>Sesi Anda akan diakhiri dan Anda perlu login kembali untuk masuk.</p>
		</div>
		<div class="logout-modal-actions">
			<button type="button" class="logout-modal-cancel" data-logout-cancel>Batal</button>
			<button type="button" class="logout-modal-confirm" id="logoutModalConfirm">Ya, Logout</button>
		</div>
	</div>
</div>

<script>
	(function () {
		var form = document.getElementById('logoutForm');
		var modal = document.getElementById('logoutModal');
		var confirmButton = document.getElementById('logoutModalConfirm');
		if (!form || !modal || !confirmButton) return;

		var closeModal = function () {
			modal.classList.remove('is-visible');
			modal.setAttribute('aria-hidden', 'true');
		};
		var openModal = function () {
			modal.classList.add('is-visible');
			modal.setAttribute('aria-hidden', 'false');
			confirmButton.focus();
		};

		form.addEventListener('submit', function (event) {
			event.preventDefault();
			openModal();
		});
		modal.querySelectorAll('[data-logout-cancel]').forEach(function (button) {
			button.addEventListener('click', closeModal);
		});
		confirmButton.addEventListener('click', function () {
			confirmButton.disabled = true;
			confirmButton.textContent = 'Memproses...';
			form.submit();
		});
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && modal.classList.contains('is-visible')) closeModal();
		});
	})();
</script>




