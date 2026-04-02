<style>
/* ── TOKENS ─────────────────────────────────────────────── */
:root {
    --ac:  #b85c2a;
    --ac2: #d4784a;
    --dk:  #1e1510;
    --md:  #6b5e54;
    --lt:  #a0958d;
    --sf:  #f7f3ee;
    --wh:  #ffffff;
    --bd:  #ece5dc;
    --fb:  'Outfit', sans-serif;
}

/* ── RESET CLASSY NAV YANG BIKIN KACAU ──────────────────── */
.delicious-main-menu,
.classy-nav-container,
.classy-navbar,
.classy-menu,
.classynav,
#nav, #nav li, #nav li a,
#nav li ul, #nav li ul li, #nav li ul li a {
    all: unset !important;
    box-sizing: border-box !important;
}

/* ── HEADER WRAPPER ─────────────────────────────────────── */
.fn-header {
    font-family: var(--fb);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transform: translateY(0);
    transition: transform .35s ease, box-shadow .35s ease;
}

/* Saat scroll ke bawah → sembunyikan */
.fn-header.fn-hidden {
    transform: translateY(-100%);
}

/* Spacer agar konten tidak ketutup header */
.fn-header-spacer {
    height: 106px; /* tinggi topbar (34) + navbar (72) */
}

/* ── TOP BAR ─────────────────────────────────────────────── */
.fn-topbar {
    background: var(--dk);
    padding: 0 5%;
    height: 34px;
    display: flex;
    align-items: center;
    gap: 12px;
    overflow: hidden;
}

.fn-topbar-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--ac2);
    white-space: nowrap;
    flex-shrink: 0;
    padding-right: 12px;
    border-right: 1px solid rgba(255,255,255,.1);
}

.fn-ticker-wrap {
    overflow: hidden;
    flex: 1;
    height: 34px;
    display: flex;
    align-items: center;
}

.fn-ticker {
    display: flex;
    align-items: center;
    animation: fn-scroll 22s linear infinite;
    white-space: nowrap;
}

.fn-ticker span {
    font-size: .71rem;
    color: rgba(255,255,255,.55);
    padding-right: 56px;
}

.fn-ticker span strong {
    color: rgba(255,255,255,.88);
    font-weight: 500;
}

@keyframes fn-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* ── MAIN NAVBAR ─────────────────────────────────────────── */
.fn-navbar {
    background: var(--wh);
    border-bottom: 1px solid var(--bd);
    padding: 0 5%;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

/* Logo */
.fn-logo img {
    height: 56px;
    width: auto;
    display: block;
    transition: opacity .2s;
}
.fn-logo:hover img { opacity: .82; }

/* Nav List (tengah) */
.fn-nav-list {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 2px;
    flex: 1;
    justify-content: center;
}

.fn-nav-list > li {
    position: relative;
    list-style: none;
}

.fn-nav-list > li > a {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 9px 16px;
    font-size: .86rem;
    font-weight: 500;
    color: var(--md);
    border-radius: 9px;
    white-space: nowrap;
    cursor: pointer;
    text-decoration: none;
    transition: background .18s, color .18s;
}

.fn-nav-list > li > a:hover,
.fn-nav-list > li.fn-active > a {
    background: rgba(184,92,42,.07);
    color: var(--ac);
}

/* Caret */
.fn-caret {
    opacity: .45;
    flex-shrink: 0;
    transition: transform .22s ease, opacity .22s;
}

.fn-has-drop:hover > a .fn-caret,
.fn-has-drop.fn-open > a .fn-caret { transform: rotate(180deg); opacity: .8; }

/* ── DROPDOWN ─────────────────────────────────────────────── */
.fn-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    left: 0;
    min-width: 185px;
    background: var(--wh);
    border: 1px solid var(--bd);
    border-radius: 14px;
    box-shadow: 0 12px 36px rgba(26,18,8,.12);
    list-style: none;
    margin: 0;
    padding: 6px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(8px);
    transition: opacity .22s ease 200ms, transform .22s ease 200ms, visibility .22s ease 200ms;
    z-index: 9999;
    pointer-events: none;
}

.fn-dropdown-right { left: auto; right: 0; }

.fn-has-drop:hover > .fn-dropdown,
.fn-user-drop:hover > .fn-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
    transition-delay: 0s;
}

/* jembatan transparan */
.fn-dropdown::before {
    content: '';
    position: absolute;
    top: -12px;
    left: 0;
    right: 0;
    height: 12px;
}

.fn-dropdown li { list-style: none; }

.fn-dropdown li a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 13px;
    font-size: .81rem;
    color: var(--dk);
    border-radius: 9px;
    white-space: nowrap;
    text-decoration: none;
    transition: background .15s, color .15s;
}

.fn-dropdown li a:hover { background: var(--sf); color: var(--ac); }

.fn-drop-divider {
    height: 1px;
    background: var(--bd);
    margin: 4px 8px;
}

.fn-logout-link { color: #c0392b !important; }
.fn-logout-link:hover { background: #fdf0ef !important; color: #c0392b !important; }

/* ── KANAN: search + auth ─────────────────────────────────── */
.fn-nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

/* Search */
.fn-search form {
    display: flex;
    align-items: center;
    gap: 7px;
    background: var(--sf);
    border: 1px solid var(--bd);
    border-radius: 999px;
    padding: 7px 16px;
    transition: border-color .2s, box-shadow .2s, background .2s;
}

.fn-search form:focus-within {
    border-color: var(--ac);
    background: var(--wh);
    box-shadow: 0 0 0 3px rgba(184,92,42,.08);
}

.fn-search svg { color: var(--lt); flex-shrink: 0; }

.fn-search input {
    border: none;
    background: transparent;
    outline: none;
    box-shadow: none;
    font-family: var(--fb);
    font-size: .82rem;
    color: var(--dk);
    width: 140px;
    padding: 0;
}

.fn-search input::placeholder { color: var(--lt); }

.fn-clear {
    color: var(--lt);
    font-size: .72rem;
    text-decoration: none;
    line-height: 1;
    transition: color .2s;
}
.fn-clear:hover { color: #c0392b; }

/* Tombol Login */
.fn-login-btn {
    display: inline-flex;
    align-items: center;
    padding: 9px 22px;
    border: 1.5px solid var(--ac);
    border-radius: 999px;
    font-family: var(--fb);
    font-size: .83rem;
    font-weight: 600;
    color: var(--ac) !important;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s, color .2s;
}
.fn-login-btn:hover { background: var(--ac); color: #fff !important; }

/* Dropdown user */
.fn-user-drop {
    position: relative;
}

.fn-user-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: var(--sf);
    border: 1px solid var(--bd);
    border-radius: 999px;
    font-family: var(--fb);
    font-size: .82rem;
    font-weight: 500;
    color: var(--dk);
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: background .18s, border-color .18s, color .18s;
}

.fn-user-drop:hover .fn-user-btn {
    background: rgba(184,92,42,.07);
    border-color: var(--ac);
    color: var(--ac);
}

/* Avatar kecil di navbar */
.fn-user-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ac) 0%, var(--ac2) 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .65rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    letter-spacing: 0;
}

/* Info user di atas dropdown */
.fn-drop-user-info {
    padding: 10px 13px 8px;
    border-bottom: 1px solid var(--bd);
    margin-bottom: 4px;
}

.fn-drop-user-info .fn-drop-name {
    font-size: .82rem;
    font-weight: 600;
    color: var(--dk);
    display: block;
    margin-bottom: 1px;
}

.fn-drop-user-info .fn-drop-email {
    font-size: .72rem;
    color: var(--lt);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 180px;
}

/* ── HAMBURGER ─────────────────────────────────────────────── */
.fn-hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    background: none;
    border: none;
    padding: 6px;
    flex-shrink: 0;
}

.fn-hamburger span {
    display: block;
    width: 24px;
    height: 2px;
    background: var(--dk);
    border-radius: 2px;
    transition: transform .28s ease, opacity .28s ease;
}

/* ── MOBILE ─────────────────────────────────────────────────── */
@media (max-width: 991px) {
    .fn-hamburger { display: flex; }

    .fn-logo img { height: 48px; }

    .fn-nav-list {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        gap: 2px;
        width: 100%;
        padding: 8px 5% 6px;
        border-top: 1px solid var(--bd);
    }

    .fn-nav-list.fn-open { display: flex; }
    .fn-nav-list > li { width: 100%; }
    .fn-nav-list > li > a { width: 100%; padding: 10px 14px; }

    /* Dropdown mobile: statis */
    .fn-dropdown {
        position: static !important;
        opacity: 1 !important;
        visibility: visible !important;
        transform: none !important;
        pointer-events: auto !important;
        box-shadow: none;
        border: none;
        border-left: 2px solid var(--bd);
        border-radius: 0;
        background: transparent;
        padding: 2px 0 4px 10px;
        margin: 2px 0 4px 14px;
        min-width: unset;
        display: none;
        transition: none;
    }

    .fn-has-drop.fn-open > .fn-dropdown,
    .fn-user-drop.fn-open > .fn-dropdown { display: block; }

    .fn-nav-right {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        width: 100%;
        padding: 10px 5% 16px;
        border-top: 1px solid var(--bd);
    }

    .fn-nav-right.fn-open { display: flex; }

    .fn-search form { border-radius: 10px; width: 100%; }
    .fn-search input { width: 100%; }

    .fn-user-drop { width: 100%; }
    .fn-user-btn { width: 100%; justify-content: space-between; border-radius: 10px; }
}
</style>

<header class="fn-header">

    {{-- TOP BAR --}}
    <div class="fn-topbar">
        <span class="fn-topbar-label">FoodNote</span>
        <div class="fn-ticker-wrap">
            <div class="fn-ticker">
                <span>Halo, <strong>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</strong>! 👋</span>
                <span>Selamat datang di <strong>FOODNOTE</strong> — temukan resep terbaik hari ini.</span>
                <span>Cari resep masakan favoritmu di sini! 🍳</span>
                {{-- duplikat untuk seamless loop --}}
                <span>Halo, <strong>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</strong>! 👋</span>
                <span>Selamat datang di <strong>FOODNOTE</strong> — temukan resep terbaik hari ini.</span>
                <span>Cari resep masakan favoritmu di sini! 🍳</span>
            </div>
        </div>
    </div>

    {{-- MAIN NAVBAR --}}
    <nav class="fn-navbar">

        {{-- Logo --}}
        <a class="fn-logo" href="{{ route('user.index') }}">
            <img src="{{ asset('assets/frontend/img/core-img/logo.png') }}" alt="FoodNote">
        </a>

        {{-- Nav links (tengah) --}}
        <ul class="fn-nav-list" id="fn-nav-list">
            <li class="{{ request()->routeIs('user.index') ? 'fn-active' : '' }}">
                <a href="{{ route('user.index') }}">Home</a>
            </li>
            <li class="{{ request()->routeIs('tentang') ? 'fn-active' : '' }}">
                <a href="{{ route('tentang') }}">Tentang</a>
            </li>

            {{-- Dropdown: Resep --}}
            <li class="fn-has-drop">
                <a href="#" class="fn-drop-toggle">
                    Resep
                    <svg class="fn-caret" width="11" height="11" viewBox="0 0 10 6" fill="none">
                        <path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <ul class="fn-dropdown">
                    <li>
                        <a href="{{ route('user.resep.index') }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            Semua Resep
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('user.resepsaya.index') }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Resep Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.resep.disimpan') }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                            Resep Disimpan
                        </a>
                    </li>
                    @endauth
                </ul>
            </li>
        </ul>

        {{-- Kanan: search + auth --}}
        <div class="fn-nav-right" id="fn-nav-right">

            {{-- Search --}}
            <div class="fn-search">
                <form action="{{ route('user.resep.index') }}" method="GET">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" name="search" placeholder="Cari resep..." value="{{ request('search') }}" autocomplete="off">
                    @if(request('search'))
                        <a href="{{ route('user.resep.index') }}" class="fn-clear">✕</a>
                    @endif
                </form>
            </div>

            {{-- Auth --}}
            @guest
                <a href="{{ route('login') }}" class="fn-login-btn">Login</a>
            @else
                <div class="fn-user-drop fn-has-drop">
                    <a href="#" class="fn-user-btn fn-drop-toggle">
                        {{-- Avatar inisial --}}
                        <span class="fn-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        {{ Str::limit(Auth::user()->name, 12) }}
                        <svg class="fn-caret" width="11" height="11" viewBox="0 0 10 6" fill="none">
                            <path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <ul class="fn-dropdown fn-dropdown-right">

                        {{-- Info user --}}
                        <li class="fn-drop-user-info">
                            <span class="fn-drop-name">{{ Auth::user()->name }}</span>
                            <span class="fn-drop-email">{{ Auth::user()->email }}</span>
                        </li>

                        {{-- Profil --}}
                        <li>
                            <a href="{{ route('user.profile') }}">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                Profil Saya
                            </a>
                        </li>

                        <li class="fn-drop-divider"></li>

                        {{-- Logout --}}
                        <li>
                            <a href="{{ route('logout') }}" class="fn-logout-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>

        {{-- Hamburger (mobile only) --}}
        <button class="fn-hamburger" id="fn-hamburger" aria-label="Buka menu">
            <span></span><span></span><span></span>
        </button>

    </nav>
</header>
<div class="fn-header-spacer"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var hamburger = document.getElementById('fn-hamburger');
    var navList   = document.getElementById('fn-nav-list');
    var navRight  = document.getElementById('fn-nav-right');
    var header    = document.querySelector('.fn-header');
    var spacer    = document.querySelector('.fn-header-spacer');
    var spans     = hamburger.querySelectorAll('span');
    var open      = false;

    // ── Hide on scroll ────────────────────────────────────
    var lastY = 0;
    window.addEventListener('scroll', function () {
        var currentY = window.scrollY;
        if (currentY > lastY && currentY > 80) {
            header.classList.add('fn-hidden');
        } else {
            header.classList.remove('fn-hidden');
        }
        lastY = currentY;
    }, { passive: true });

    // Update tinggi spacer dinamis
    function updateSpacer() {
        spacer.style.height = header.offsetHeight + 'px';
    }
    updateSpacer();
    window.addEventListener('resize', updateSpacer);

    // Hamburger toggle
    hamburger.addEventListener('click', function () {
        open = !open;
        navList.classList.toggle('fn-open', open);
        navRight.classList.toggle('fn-open', open);

        if (open) {
            spans[0].style.transform = 'translateY(7px) rotate(45deg)';
            spans[1].style.opacity   = '0';
            spans[2].style.transform = 'translateY(-7px) rotate(-45deg)';
        } else {
            spans[0].style.transform = '';
            spans[1].style.opacity   = '';
            spans[2].style.transform = '';
        }
    });

    // Dropdown click (mobile saja)
    document.querySelectorAll('.fn-drop-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            if (window.innerWidth > 991) return;
            e.preventDefault();
            this.closest('.fn-has-drop').classList.toggle('fn-open');
        });
    });
});
</script>