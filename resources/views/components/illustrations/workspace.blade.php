{{-- Decorative illustration for the guest (login) panel: an org chart card,
     an attendance card and a small calendar. Purely visual, hidden from screen readers. --}}
<svg {{ $attributes }} viewBox="0 0 420 300" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    {{-- Back card: org chart --}}
    <rect x="20" y="20" width="250" height="170" rx="14" fill="#fff" fill-opacity="0.06" stroke="#fff" stroke-opacity="0.12"/>
    <rect x="40" y="40" width="90" height="8" rx="4" fill="#fff" fill-opacity="0.35"/>
    <rect x="40" y="56" width="56" height="6" rx="3" fill="#fff" fill-opacity="0.15"/>

    <circle cx="145" cy="92" r="14" fill="#3B82F6"/>
    <circle cx="145" cy="88" r="4.5" fill="#fff"/>
    <path d="M137 99c1.5-4 4.5-5.5 8-5.5s6.5 1.5 8 5.5" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>

    <path d="M145 106v14M85 120h120M85 120v10M145 120v10M205 120v10" stroke="#fff" stroke-opacity="0.25" stroke-width="2"/>

    <circle cx="85" cy="146" r="12" fill="#22C3A6"/>
    <circle cx="145" cy="146" r="12" fill="#818CF8"/>
    <circle cx="205" cy="146" r="12" fill="#F59E0B"/>
    <rect x="70" y="164" width="30" height="5" rx="2.5" fill="#fff" fill-opacity="0.2"/>
    <rect x="130" y="164" width="30" height="5" rx="2.5" fill="#fff" fill-opacity="0.2"/>
    <rect x="190" y="164" width="30" height="5" rx="2.5" fill="#fff" fill-opacity="0.2"/>

    {{-- Front card: attendance --}}
    <rect x="190" y="130" width="210" height="140" rx="14" fill="#fff"/>
    <rect x="210" y="150" width="34" height="34" rx="9" fill="#E3F6F2"/>
    <path d="M220 167l5 5 9-10" stroke="#0F9B83" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    <rect x="254" y="153" width="80" height="8" rx="4" fill="#1F2937" fill-opacity="0.85"/>
    <rect x="254" y="169" width="52" height="6" rx="3" fill="#94A3B8"/>
    <rect x="350" y="154" width="32" height="16" rx="8" fill="#E8F7EE"/>
    <rect x="356" y="160" width="20" height="4" rx="2" fill="#16A34A"/>

    {{-- weekly bars --}}
    <rect x="214" y="236" width="14" height="18" rx="3" fill="#C7D7FB"/>
    <rect x="236" y="220" width="14" height="34" rx="3" fill="#3B82F6"/>
    <rect x="258" y="228" width="14" height="26" rx="3" fill="#C7D7FB"/>
    <rect x="280" y="210" width="14" height="44" rx="3" fill="#3B82F6"/>
    <rect x="302" y="224" width="14" height="30" rx="3" fill="#C7D7FB"/>
    <rect x="324" y="232" width="14" height="22" rx="3" fill="#C7D7FB"/>
    <rect x="346" y="216" width="14" height="38" rx="3" fill="#22C3A6"/>
    <path d="M210 200h170" stroke="#E5E8EF" stroke-width="1.5"/>

    {{-- Small calendar chip --}}
    <rect x="300" y="40" width="96" height="74" rx="12" fill="#fff" fill-opacity="0.1" stroke="#fff" stroke-opacity="0.15"/>
    <rect x="300" y="40" width="96" height="20" rx="10" fill="#4F46E5"/>
    <g fill="#fff" fill-opacity="0.35">
        <rect x="312" y="70" width="10" height="8" rx="2"/>
        <rect x="328" y="70" width="10" height="8" rx="2"/>
        <rect x="344" y="70" width="10" height="8" rx="2"/>
        <rect x="360" y="70" width="10" height="8" rx="2"/>
        <rect x="376" y="70" width="10" height="8" rx="2"/>
        <rect x="312" y="86" width="10" height="8" rx="2"/>
        <rect x="328" y="86" width="10" height="8" rx="2"/>
        <rect x="360" y="86" width="10" height="8" rx="2"/>
        <rect x="376" y="86" width="10" height="8" rx="2"/>
    </g>
    <rect x="344" y="86" width="10" height="8" rx="2" fill="#22C3A6"/>
</svg>
