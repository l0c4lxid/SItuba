@php
    $icon = $icon ?? 'default';
@endphp

@switch($icon)
    @case('dashboard')
        <i class="fa-solid fa-gauge text-success"></i>
        @break
    @case('folder')
        <i class="fa-solid fa-folder-open text-success"></i>
        @break
    @case('screening')
        <i class="fa-solid fa-vials text-success"></i>
        @break
    @case('berobat')
        <i class="fa-solid fa-syringe text-success"></i>
        @break
    @case('sembuh')
        <i class="fa-solid fa-heart-circle-check text-success"></i>
        @break
    @case('anggota')
        <i class="fa-solid fa-people-group text-success"></i>
        @break
    @case('verify')
        <i class="fa-solid fa-user-check text-success"></i>
        @break
    @case('profile')
        <i class="fa-solid fa-id-badge text-success"></i>
        @break
    @case('users')
        <i class="fa-solid fa-users text-success"></i>
        @break
    @default
        <i class="fa-regular fa-circle text-success"></i>
@endswitch
