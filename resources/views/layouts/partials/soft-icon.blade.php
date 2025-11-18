@php
    $icon = $icon ?? 'default';
@endphp

@switch($icon)
    @case('dashboard')
        <svg width="12px" height="12px" viewBox="0 0 45 40" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <g transform="translate(-1716 -439)" fill="#FFFFFF" fill-rule="nonzero">
                    <g transform="translate(1716 291)">
                        <g transform="translate(0 148)">
                            <path class="color-background opacity-6" d="M46.72,10.74 L40.845,0.95 C40.491,0.36 39.854,0 39.167,0 L7.833,0 C7.146,0 6.509,0.36 6.155,0.95 L0.28,10.74 C0.097,11.05 0,11.39 0,11.75 C-0.008,16.07 3.484,19.57 7.8,19.58 L7.816,19.58 C9.75,19.59 11.617,18.87 13.052,17.58 C16.017,20.26 20.529,20.26 23.494,17.58 C26.46,20.26 30.979,20.26 33.946,17.58 C36.242,19.65 39.544,20.17 42.368,18.91 C45.193,17.65 47.008,14.84 47,11.75 C47,11.39 46.903,11.05 46.72,10.74 Z"></path>
                            <path class="color-background" d="M39.198,22.49 C37.378,22.49 35.582,22.01 33.952,21.1 L33.922,21.11 C31.143,22.68 27.926,22.93 24.984,21.8 C24.475,21.61 23.978,21.37 23.496,21.1 L23.475,21.11 C20.696,22.69 17.479,22.93 14.539,21.8 C14.03,21.61 13.533,21.37 13.052,21.1 C11.425,22.02 9.632,22.49 7.816,22.49 C7.165,22.48 6.516,22.42 5.875,22.29 L5.875,44.72 C5.875,45.95 6.752,47 7.917,47 L17.208,47 L17.208,33.41 L29.792,33.41 L29.792,47 L39.083,47 C40.248,47 41.125,45.95 41.125,44.72 L41.125,22.26 C40.508,22.4 39.858,22.48 39.198,22.49 Z"></path>
                        </g>
                    </g>
                </g>
            </g>
        </svg>
        @break
    @case('folder')
        <i class="fa-solid fa-folder text-primary"></i>
        @break
    @case('screening')
        <i class="fa-solid fa-microscope text-success"></i>
        @break
    @case('berobat')
        <i class="fa-solid fa-syringe text-danger"></i>
        @break
    @case('sembuh')
        <i class="fa-solid fa-heart-circle-check text-success"></i>
        @break
    @case('anggota')
        <i class="fa-solid fa-people-group text-info"></i>
        @break
    @case('verify')
        <i class="fa-solid fa-user-check text-warning"></i>
        @break
    @case('profile')
        <i class="fa-solid fa-id-badge text-info"></i>
        @break
    @default
        <i class="fa-regular fa-circle text-secondary"></i>
@endswitch
