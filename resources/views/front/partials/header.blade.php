<header class="sticky-top border-bottom" style="z-index: 1050; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border-color: #e5e7eb !important;">
    <div class="container-xl">
        <nav class="navbar navbar-expand-xl py-0" style="height: 64px;">

            {{-- Brand Logo --}}
            <a class="navbar-brand d-flex align-items-center gap-1 me-4" href="{{ route('home') }}">
                <span class="fw-bold fs-5" style="color: #16a34a; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.3px;">TRESCA</span>
                <span class="fw-light fs-5" style="color: #111; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.3px;">Hub</span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto gap-1">
                    <li class="nav-item">
                        <a href="{{ route('home') }}"
                           class="nav-link rounded px-3 py-2 fw-medium {{ request()->routeIs('home') ? 'active' : '' }}"
                           style="font-size: 13px; color: {{ request()->routeIs('home') ? '#16a34a' : '#6b7280' }}; background-color: {{ request()->routeIs('home') ? '#f3f4f6' : 'transparent' }};">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('services') }}"
                           class="nav-link rounded px-3 py-2 fw-medium {{ request()->routeIs('services') ? 'active' : '' }}"
                           style="font-size: 13px; color: {{ request()->routeIs('services') ? '#16a34a' : '#6b7280' }}; background-color: {{ request()->routeIs('services') ? '#f3f4f6' : 'transparent' }};">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('shop') }}"
                           class="nav-link rounded px-3 py-2 fw-medium {{ request()->routeIs('shop') ? 'active' : '' }}"
                           style="font-size: 13px; color: {{ request()->routeIs('shop') ? '#16a34a' : '#6b7280' }}; background-color: {{ request()->routeIs('shop') ? '#f3f4f6' : 'transparent' }};">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('for-partners') }}"
                           class="nav-link rounded px-3 py-2 fw-medium {{ request()->routeIs('for-partners') ? 'active' : '' }}"
                           style="font-size: 13px; color: {{ request()->routeIs('for-partners') ? '#16a34a' : '#6b7280' }}; background-color: {{ request()->routeIs('for-partners') ? '#f3f4f6' : 'transparent' }};">For Partners</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('request-service') }}"
                           class="nav-link rounded px-3 py-2 fw-medium {{ request()->routeIs('request-service') ? 'active' : '' }}"
                           style="font-size: 13px; color: {{ request()->routeIs('request-service') ? '#16a34a' : '#6b7280' }}; background-color: {{ request()->routeIs('request-service') ? '#f3f4f6' : 'transparent' }};">Request Service</a>
                    </li>
                </ul>
            </div>

            {{-- Right Side: Desktop Search + Mobile Search Icon --}}
            <div class="d-flex align-items-center gap-2 ms-auto">

                {{-- Live Search (Desktop) --}}
                <div class="d-none d-xl-block position-relative" id="searchWrapper">
                    <div class="d-flex align-items-center border rounded-pill px-3 bg-light"
                         style="width:220px;height:36px;transition:width 0.3s ease;" id="searchBox">
                        <i class="bi bi-search text-muted me-2" style="font-size:0.85rem;"></i>
                        <input type="text"
                               id="liveSearchInput"
                               class="border-0 bg-transparent w-100"
                               placeholder="Search..."
                               style="font-size:13px;outline:none;"
                               autocomplete="off">
                        <button type="button" id="clearSearch"
                                class="border-0 bg-transparent p-0 ms-1 d-none"
                                style="color:#999;font-size:0.9rem;cursor:pointer;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div id="searchDropdown"
                         class="position-absolute bg-white rounded-3 shadow-lg d-none"
                         style="top:calc(100% + 8px);left:0;right:0;min-width:420px;max-height:480px;overflow-y:auto;z-index:9999;border:1px solid #e5e7eb;">
                    </div>
                </div>

                {{-- Mobile Search Icon --}}
                <button class="border-0 bg-transparent p-2 d-xl-none"
                        type="button"
                        id="mobileSearchToggle"
                        aria-label="Search">
                    <i class="bi bi-search fs-5 text-dark"></i>
                </button>

            </div>
        </nav>
    </div>

    {{-- Mobile Search Bar --}}
    <div id="mobileSearchBar" class="d-none border-top bg-white px-3 py-2">
        <div class="position-relative">
            <div class="d-flex align-items-center border rounded-pill px-3 bg-light" style="height:40px;">
                <i class="bi bi-search text-muted me-2" style="font-size:0.85rem;"></i>
                <input type="text"
                       id="liveSearchMobile"
                       class="border-0 bg-transparent w-100"
                       placeholder="Search..."
                       style="font-size:13px;outline:none;"
                       autocomplete="off">
                <button type="button" id="closeMobileSearchBar"
                        class="border-0 bg-transparent p-0 ms-2"
                        style="color:#999;font-size:0.9rem;cursor:pointer;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div id="searchDropdownMobile"
                 class="position-absolute bg-white rounded-3 shadow-lg d-none w-100"
                 style="top:calc(100% + 6px);left:0;right:0;max-height:360px;overflow-y:auto;z-index:9999;border:1px solid #e5e7eb;">
            </div>
        </div>
    </div>

</header>

{{-- Mobile Bottom Navigation Bar --}}
<nav class="fixed-bottom border-top d-xl-none"
     style="z-index: 1050;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-color: #e5e7eb !important;
            padding-bottom: env(safe-area-inset-bottom);">
    <div class="d-flex justify-content-around align-items-center py-2">
        <a href="{{ route('home') }}"
           class="d-flex flex-column align-items-center text-decoration-none gap-1 px-2"
           style="font-size: 10px; font-weight: 500; color: {{ request()->routeIs('home') ? '#16a34a' : '#6b7280' }};">
            <i class="bi bi-house fs-5"></i>Home
        </a>
        <a href="{{ route('services') }}"
           class="d-flex flex-column align-items-center text-decoration-none gap-1 px-2"
           style="font-size: 10px; font-weight: 500; color: {{ request()->routeIs('services') ? '#16a34a' : '#6b7280' }};">
            <i class="bi bi-briefcase fs-5"></i>Services
        </a>
        <a href="{{ route('shop') }}"
           class="d-flex flex-column align-items-center text-decoration-none gap-1 px-2"
           style="font-size: 10px; font-weight: 500; color: {{ request()->routeIs('shop') ? '#16a34a' : '#6b7280' }};">
            <i class="bi bi-bag fs-5"></i>Shop
        </a>
        <a href="{{ route('request-service') }}"
           class="d-flex flex-column align-items-center text-decoration-none gap-1 px-2"
           style="font-size: 10px; font-weight: 500; color: {{ request()->routeIs('request-service') ? '#16a34a' : '#6b7280' }};">
            <i class="bi bi-file-text fs-5"></i>Request
        </a>
        <a href="{{ route('for-partners') }}"
           class="d-flex flex-column align-items-center text-decoration-none gap-1 px-2"
           style="font-size: 10px; font-weight: 500; color: {{ request()->routeIs('for-partners') ? '#16a34a' : '#6b7280' }};">
            <i class="bi bi-people fs-5"></i>Partners
        </a>
    </div>
</nav>

{{-- ── Live Search Styles & JS ── --}}
<style>
    .search-result-item { display:flex; align-items:center; gap:12px; padding:10px 16px; text-decoration:none; color:inherit; transition:background 0.15s; border-bottom:1px solid #f3f4f6; }
    .search-result-item:last-child { border-bottom:none; }
    .search-result-item:hover { background:#f9fafb; }
    .search-result-thumb { width:44px; height:44px; border-radius:8px; flex-shrink:0; background:#f3f4f6; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .search-result-thumb img { width:100%; height:100%; object-fit:cover; }
    .search-result-type { font-size:0.68rem; font-weight:600; padding:2px 8px; border-radius:20px; flex-shrink:0; }
    .search-type-service { background:rgba(22,163,74,0.1); color:#16a34a; }
    .search-type-product { background:rgba(246,119,35,0.1); color:#F67723; }
    .search-no-results { padding:24px 16px; text-align:center; color:#9ca3af; font-size:0.875rem; }
    .search-loading { padding:20px 16px; text-align:center; color:#9ca3af; font-size:0.875rem; }
    #searchBox:focus-within { width:300px !important; }

    .navbar .nav-link:hover {
        background-color: #f3f4f6 !important;
        color: #16a34a !important;
    }
    nav.fixed-bottom a:hover {
        color: #16a34a !important;
    }
</style>

<script>
(function () {
    const SEARCH_URL    = '{{ route("search.live") }}';
    const PUBLIC_ASSETS = '{{ url("assets") }}' + '/';

    function buildDropdown(results, dropdown) {
        dropdown.innerHTML = '';
        if (!results.length) {
            dropdown.innerHTML = '<div class="search-no-results"><i class="bi bi-emoji-frown me-2"></i>No results found</div>';
            dropdown.classList.remove('d-none');
            return;
        }
        results.forEach(item => {
            const a = document.createElement('a');
            a.href = item.url;
            a.className = 'search-result-item';

            const thumbEl = document.createElement('div');
            thumbEl.className = 'search-result-thumb';
            if (item.thumbnail) {
                const imgSrc = PUBLIC_ASSETS + item.thumbnail.replace(/^.*\/public\/assets\//, '').replace(/^.*\/assets\//, '');
                thumbEl.innerHTML = `<img src="${imgSrc}" alt="${item.title}">`;
            } else {
                thumbEl.innerHTML = item.type === 'service'
                    ? '<i class="bi bi-briefcase text-muted"></i>'
                    : '<i class="bi bi-box-seam text-muted"></i>';
            }

            const info = document.createElement('div');
            info.style.flex = '1';
            info.style.minWidth = '0';
            info.innerHTML = `
                <div class="fw-semibold text-truncate" style="font-size:0.875rem;color:#111827;">${item.title}</div>
                <div class="text-muted text-truncate" style="font-size:0.75rem;">${item.subtitle}</div>
            `;

            const badge = document.createElement('span');
            badge.className = `search-result-type ${item.type === 'service' ? 'search-type-service' : 'search-type-product'}`;
            badge.textContent = item.type === 'service' ? 'Service' : 'Product';

            a.appendChild(thumbEl);
            a.appendChild(info);
            a.appendChild(badge);
            dropdown.appendChild(a);
        });
        dropdown.classList.remove('d-none');
    }

    function initSearch(inputId, dropdownId) {
        const input    = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        const clearBtn = document.getElementById('clearSearch');

        if (!input || !dropdown) return;

        let debounce;

        input.addEventListener('input', function () {
            const q = this.value.trim();
            if (clearBtn) clearBtn.classList.toggle('d-none', q.length === 0);
            if (q.length < 2) {
                dropdown.classList.add('d-none');
                dropdown.innerHTML = '';
                return;
            }
            clearTimeout(debounce);
            dropdown.innerHTML = '<div class="search-loading"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Searching...</div>';
            dropdown.classList.remove('d-none');
            debounce = setTimeout(() => {
                fetch(`${SEARCH_URL}?q=${encodeURIComponent(q)}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status + ' ' + r.statusText);
                    return r.json();
                })
                .then(data => buildDropdown(data, dropdown))
                .catch(err => {
                    console.error('Search error:', err);
                    dropdown.innerHTML = '<div class="search-no-results"><i class="bi bi-exclamation-circle me-2"></i>Something went wrong.</div>';
                    dropdown.classList.remove('d-none');
                });
            }, 280);
        });

        document.addEventListener('click', function (e) {
            if (!input.closest('.position-relative').contains(e.target)) {
                dropdown.classList.add('d-none');
            }
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                input.value = '';
                dropdown.classList.add('d-none');
                dropdown.innerHTML = '';
                clearBtn.classList.add('d-none');
                input.focus();
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSearch('liveSearchInput', 'searchDropdown');
        initSearch('liveSearchMobile', 'searchDropdownMobile');

        // Mobile search bar toggle
        const toggleBtn   = document.getElementById('mobileSearchToggle');
        const mobileBar   = document.getElementById('mobileSearchBar');
        const closeBarBtn = document.getElementById('closeMobileSearchBar');
        const mobileInput = document.getElementById('liveSearchMobile');

        if (toggleBtn && mobileBar) {
            toggleBtn.addEventListener('click', function () {
                mobileBar.classList.toggle('d-none');
                if (!mobileBar.classList.contains('d-none')) {
                    setTimeout(function () { if (mobileInput) mobileInput.focus(); }, 50);
                }
            });
        }

        if (closeBarBtn) {
            closeBarBtn.addEventListener('click', function () {
                mobileBar.classList.add('d-none');
                if (mobileInput) mobileInput.value = '';
                const dd = document.getElementById('searchDropdownMobile');
                if (dd) dd.classList.add('d-none');
            });
        }
    });
})();
</script>