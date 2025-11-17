@if (auth()->check() && auth()->user()->role === 'Admin Unit')
    <div style="display: flex; align-items: center; margin-right: 0.75rem;">
        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Utama,%20saya%20butuh%20bantuan." target="_blank"
            style="
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background-color: #25D366;
                color: white;
                padding: 7px 13px;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
                transition: background 0.2s ease;
                margin-left: 0.75rem; 
            "
            onmouseover="this.style.backgroundColor='#20c85a'" onmouseout="this.style.backgroundColor='#25D366'">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="18"
                height="18">
            Hubungi Admin Utama
        </a>
    </div>
@endif
