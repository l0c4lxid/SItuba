{{-- SIgap Card component --}}
<div {{ $attributes->merge(['class' => 'si-gap-card']) }}>
  @if(isset($title))
    <div class="d-flex justify-content-between align-items-start mb-2">
      <div class="d-flex align-items-center">
        <div class="me-2">
          @if(isset($icon))
            <span class="badge rounded-pill bg-white" style="box-shadow: var(--si-gap-shadow-sm)">{!! $icon !!}</span>
          @endif
        </div>
        <div>
          <h6 class="mb-0">{{ $title }}</h6>
          @if(isset($subtitle)) <small class="text-muted">{{ $subtitle }}</small> @endif
        </div>
      </div>
      @if(isset($actions))
        <div class="ms-2">{!! $actions !!}</div>
      @endif
    </div>
  @endif

  <div class="si-gap-card-body">
    {{ $slot }}
  </div>
</div>
