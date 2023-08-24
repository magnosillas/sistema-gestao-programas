@canany(['admin', 'servidor'])
    <div class="modal" id="modal_delete{{ $aluno->id }}_{{ $edital->id }}" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content fundomodaldelete">
                <div class="modal-header border-0">
                </div>
                <div class="modal-body">
                    <p class="titulomodal">Deseja realmente remover o estudante {{$aluno->user->name}}?</p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button stype="button" class="cancelarmodalbotao" data-bs-dismiss="modal">Cancelar</button>

                    <form
                        action="{{ route('edital.aluno.delete', ['aluno_id' => $aluno->id, 'edital_id' => $edital->id]) }}"
                        method="GET">

                        @csrf
                        <button type="submit" class="apagarmodalbotao">Remover</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal" id="modal_delete_{{ $aluno->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 15px; background-color: #F9F9F9; font-family: 'Roboto', sans-serif;">
                <div class="modal-header">
                    <h3 style="margin-top: 1rem">Você não possui permissão!</h3>
                    <a class="btn btn-primary submit" data-bs-dismiss="modal" style="margin-top: 1rem">Fechar</a>
                </div>
            </div>
        </div>
    </div>
@endcan
