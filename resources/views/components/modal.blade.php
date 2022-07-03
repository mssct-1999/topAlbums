<div {{$attributes->merge(['id' => $attributes['id']])}} class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $attributes['title'] }}
                </h5>
                <button type="button"
                        class="close text-danger"
                        data-dismiss="modal"
                        aria-label="Fermer"
                        title="Fermer la fenêtre">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>