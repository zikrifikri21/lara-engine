<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Kuncup Bahari</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menu as $mn)
            <li class="menu-item">
                <a href="{{ $mn->link }}" class="menu-link">
                    <i class="menu-icon tf-icons {{ $mn->icon }}"></i>
                    <div data-i18n="Analytics">{{ $mn->name }}</div>
                </a>
                @foreach ($mn->children as $mnc)
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ $mnc->link }}" class="menu-link">
                                <div data-i18n="Without menu">{{ $mnc->name }}</div>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </li>
            {{-- @if ($mn->parent_id == true)
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-layout"></i>
                        <div data-i18n="Layouts">{{ $mn->name }}</div>
                    </a>
                    @foreach ($mn->children as $mnc)
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="layouts-without-menu.html" class="menu-link">
                                    <div data-i18n="Without menu">{{ $mnc->name }}</div>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </li>
            @endif --}}
        @endforeach
    </ul>
    {{-- <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Pages</span>
    </li> --}}
</aside>
