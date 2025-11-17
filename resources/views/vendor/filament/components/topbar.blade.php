<div style="position: absolute; top: 12px; right: 90px;">
    <div style="position: relative; display: inline-block;">
        <button id="contactDropdown"
            style="background-color: #25D366; color: white; border: none; padding: 8px 14px; border-radius: 8px; font-weight: 600; cursor: pointer;">
            💬 Hubungi Admin
        </button>

        <div id="dropdownContent"
            style="display: none; position: absolute; right: 0; margin-top: 8px; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; z-index: 1000; width: 190px;">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Utama,%20saya%20butuh%20bantuan." target="_blank"
                style="display: flex; align-items: center; gap: 8px; padding: 10px; text-decoration: none; color: #333; font-weight: 600; background-color: #E9F9EF;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                    width="20">
                Hubungi Admin Utama
            </a>
            <a href="/admin/logout"
                style="display: flex; align-items: center; gap: 8px; padding: 10px; text-decoration: none; color: #333; font-weight: 600;">
                🚪 Keluar
            </a>
        </div>
    </div>

    @if (auth()->check() && auth()->user()->role === 'admin_unit')
        <div style="margin-right: 12px;">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Utama,%20saya%20butuh%20bantuan." target="_blank"
                style="background-color:#25D366;
                    color:white;
                    padding:8px 14px;
                    border-radius:8px;
                    font-weight:600;
                    text-decoration:none;
                    display:inline-flex;
                    align-items:center;
                    gap:6px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                    width="18">
                Hubungi Admin
            </a>
        </div>
    @endif

</div>

<script>
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('dropdownContent');
        const button = document.getElementById('contactDropdown');
        if (button.contains(e.target)) {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        } else {
            dropdown.style.display = 'none';
        }
    });
</script>
